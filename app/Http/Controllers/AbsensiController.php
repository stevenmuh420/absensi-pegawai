<?php 
namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    public function index()
    {
        return view('absensi.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'foto' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imageName = time().'.'.$request->foto->extension();
        $request->foto->move(public_path('images'), $imageName);

        $pegawai = Pegawai::create([
            'nama' => $request->nama,
            'foto' => $imageName,
        ]);

        return response()->json([
            'message' => 'Absensi Berhasil!',
            'pegawai' => $pegawai,
        ]);
    }
}

