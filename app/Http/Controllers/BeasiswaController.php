<?php

namespace App\Http\Controllers;

use App\Models\Beasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

/**
 * Controller Beasiswa
 * 
 * Mengelola pendaftaran beasiswa mahasiswa
 * IPK akan berubah setiap kali refresh halaman
 * 
 * @author Your Name
 * @version 1.0
 * @date 2025-10-06
 */
class BeasiswaController extends Controller
{
    /**
     * Generate IPK random setiap kali dipanggil
     * IPK akan berubah setiap refresh halaman
     */
    private function getIpkMahasiswa(): float
    {
        // Generate IPK random antara 2.50 - 4.00
        // Setiap kali method ini dipanggil, akan generate IPK baru
        $ipk = round(mt_rand(250, 400) / 100, 2);
        
        return $ipk;
    }

    /**
     * Mendapatkan standar IPK untuk setiap jenis beasiswa
     */
    private function getStandarIpk(): array
    {
        return [
            'Akademik' => 3.5,
            'Non-Akademik' => 3.0,
            'Prestasi Olahraga' => 3.2,
            'Prestasi Seni' => 3.2,
        ];
    }

    /**
     * Menampilkan halaman utama/home
     */
    public function index()
    {
        $ipk = $this->getIpkMahasiswa();
        $isEligible = Beasiswa::isEligible($ipk);
        $standarIpk = $this->getStandarIpk();
        
        return view('beasiswa.home', compact('ipk', 'isEligible', 'standarIpk'));
    }

    /**
     * Menampilkan halaman pilihan beasiswa
     */
    public function pilihan()
    {
        $ipk = $this->getIpkMahasiswa();
        $standarIpk = $this->getStandarIpk();
        
        $jenisBeasiswa = [
            [
                'nama' => 'Beasiswa Akademik',
                'syarat' => 'IPK minimal 3.5',
                'deskripsi' => 'Beasiswa untuk mahasiswa berprestasi akademik',
                'ipk_minimum' => $standarIpk['Akademik'],
                'eligible' => $ipk >= $standarIpk['Akademik']
            ],
            [
                'nama' => 'Beasiswa Non-Akademik',
                'syarat' => 'IPK minimal 3.0',
                'deskripsi' => 'Beasiswa untuk mahasiswa aktif organisasi',
                'ipk_minimum' => $standarIpk['Non-Akademik'],
                'eligible' => $ipk >= $standarIpk['Non-Akademik']
            ],
            [
                'nama' => 'Beasiswa Prestasi Olahraga',
                'syarat' => 'IPK minimal 3.2 + Prestasi Olahraga',
                'deskripsi' => 'Beasiswa untuk mahasiswa berprestasi di bidang olahraga',
                'ipk_minimum' => $standarIpk['Prestasi Olahraga'],
                'eligible' => $ipk >= $standarIpk['Prestasi Olahraga']
            ],
            [
                'nama' => 'Beasiswa Prestasi Seni',
                'syarat' => 'IPK minimal 3.2 + Prestasi Seni',
                'deskripsi' => 'Beasiswa untuk mahasiswa berprestasi di bidang seni',
                'ipk_minimum' => $standarIpk['Prestasi Seni'],
                'eligible' => $ipk >= $standarIpk['Prestasi Seni']
            ]
        ];

        return view('beasiswa.pilihan', compact('jenisBeasiswa', 'ipk'));
    }

    /**
     * Menampilkan form pendaftaran beasiswa
     */
    public function daftar()
    {
        $ipk = $this->getIpkMahasiswa();
        $standarIpk = $this->getStandarIpk();
        
        // Cek apakah eligible untuk setidaknya satu beasiswa
        $isEligible = false;
        foreach ($standarIpk as $minIpk) {
            if ($ipk >= $minIpk) {
                $isEligible = true;
                break;
            }
        }

        return view('beasiswa.daftar', compact('ipk', 'isEligible', 'standarIpk'));
    }

    /**
     * Menyimpan data pendaftaran beasiswa
     */
    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:beasiswa,email',
            'nomor_hp' => 'required|numeric|digits_between:10,15',
            'semester' => 'required|integer|min:1|max:8',
            'pilihan_beasiswa' => 'required|in:Akademik,Non-Akademik,Prestasi Olahraga,Prestasi Seni',
            'berkas' => 'required|file|mimes:pdf,jpg,jpeg,png,zip|max:2048',
            'ipk_submit' => 'required|numeric', // Hidden field untuk simpan IPK saat submit
        ], [
            'nama.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'nomor_hp.required' => 'Nomor HP wajib diisi',
            'nomor_hp.numeric' => 'Nomor HP harus berupa angka',
            'nomor_hp.digits_between' => 'Nomor HP harus 10-15 digit',
            'semester.required' => 'Semester wajib dipilih',
            'semester.min' => 'Semester minimal 1',
            'semester.max' => 'Semester maksimal 8',
            'pilihan_beasiswa.required' => 'Pilihan beasiswa wajib dipilih',
            'berkas.required' => 'Berkas syarat wajib diupload',
            'berkas.mimes' => 'Format file harus PDF, JPG, JPEG, PNG, atau ZIP',
            'berkas.max' => 'Ukuran file maksimal 2MB',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Gunakan IPK dari form (yang di-submit user)
        $ipk = floatval($request->ipk_submit);
        $standarIpk = $this->getStandarIpk();
        $pilihanBeasiswa = $request->pilihan_beasiswa;
        $minIpkRequired = $standarIpk[$pilihanBeasiswa] ?? 3.0;

        if ($ipk < $minIpkRequired) {
            return redirect()->back()
                ->with('error', "IPK Anda ({$ipk}) tidak memenuhi syarat untuk {$pilihanBeasiswa} (minimal {$minIpkRequired})")
                ->withInput();
        }

        // Upload file
        $fileName = null;
        if ($request->hasFile('berkas')) {
            $file = $request->file('berkas');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/berkas', $fileName);
        }

        // Simpan data ke database
        $beasiswa = Beasiswa::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'nomor_hp' => $request->nomor_hp,
            'semester' => $request->semester,
            'ipk' => $ipk,
            'pilihan_beasiswa' => $request->pilihan_beasiswa,
            'berkas' => $fileName,
            'status_ajuan' => 'Belum diverifikasi',
        ]);

        return redirect()->route('beasiswa.hasil')
            ->with('success', 'Pendaftaran beasiswa berhasil! Status ajuan: Belum diverifikasi');
    }

    /**
     * Menampilkan hasil/daftar pendaftaran beasiswa
     */
    public function hasil()
    {
        $daftarBeasiswa = Beasiswa::orderBy('created_at', 'desc')->get();
        $standarIpk = $this->getStandarIpk();
        
        return view('beasiswa.hasil', compact('daftarBeasiswa', 'standarIpk'));
    }

    /**
     * Download berkas yang diupload
     */
    public function downloadBerkas($id)
    {
        $beasiswa = Beasiswa::findOrFail($id);
        
        if (!$beasiswa->berkas) {
            abort(404, 'Berkas tidak ditemukan');
        }

        $filePath = storage_path('app/public/berkas/' . $beasiswa->berkas);
        
        if (!file_exists($filePath)) {
            abort(404, 'File tidak ditemukan');
        }

        return response()->download($filePath);
    }

    /**
     * Fungsi helper untuk mendapatkan IPK
     * Akan generate IPK baru setiap kali dipanggil
     */
    public function getIpk()
    {
        return $this->getIpkMahasiswa();
    }
}