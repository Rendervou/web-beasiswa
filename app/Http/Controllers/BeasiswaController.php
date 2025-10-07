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
 * 
 * @author Your Name
 * @version 1.0
 * @date 2025-10-06
 */
class BeasiswaController extends Controller
{
    /**
     * Konstanta IPK mahasiswa
     * Simulasi IPK yang didapat dari sistem
     */
    const IPK_MAHASISWA = 3.4; // Ubah nilai ini untuk testing (misal: 2.9 atau 3.4)

    /**
     * Menampilkan halaman utama/home
     */
    public function index()
    {
          $ipk = self::IPK_MAHASISWA;
    $isEligible = Beasiswa::isEligible($ipk);
    $standarIpk = 3.0; // IPK minimal untuk beasiswa
    
    return view('beasiswa.home', compact('ipk', 'isEligible', 'standarIpk'));
    }

    /**
     * Menampilkan halaman pilihan beasiswa
     */
    public function pilihan()
    {
        $jenisBeasiswa = [
            [
                'nama' => 'Beasiswa Akademik',
                'syarat' => 'IPK minimal 3.0',
                'deskripsi' => 'Beasiswa untuk mahasiswa berprestasi akademik'
            ],
            [
                'nama' => 'Beasiswa Non-Akademik',
                'syarat' => 'IPK minimal 3.0',
                'deskripsi' => 'Beasiswa untuk mahasiswa aktif organisasi'
            ],
            [
                'nama' => 'Beasiswa Prestasi Olahraga',
                'syarat' => 'IPK minimal 3.0 + Prestasi Olahraga',
                'deskripsi' => 'Beasiswa untuk mahasiswa berprestasi di bidang olahraga'
            ],
            [
                'nama' => 'Beasiswa Prestasi Seni',
                'syarat' => 'IPK minimal 3.0 + Prestasi Seni',
                'deskripsi' => 'Beasiswa untuk mahasiswa berprestasi di bidang seni'
            ]
        ];

        return view('beasiswa.pilihan', compact('jenisBeasiswa'));
    }

    /**
     * Menampilkan form pendaftaran beasiswa
     */
    public function daftar()
    {
        $ipk = self::IPK_MAHASISWA;
        $isEligible = Beasiswa::isEligible($ipk);

        return view('beasiswa.daftar', compact('ipk', 'isEligible'));
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

        // Cek IPK
        $ipk = self::IPK_MAHASISWA;
        if (!Beasiswa::isEligible($ipk)) {
            return redirect()->back()
                ->with('error', 'IPK Anda tidak memenuhi syarat (minimal 3.0)')
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
        
        return view('beasiswa.hasil', compact('daftarBeasiswa'));
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
     * Bisa dipanggil dari view atau controller lain
     */
    public static function getIpk()
    {
        return self::IPK_MAHASISWA;
    }
}