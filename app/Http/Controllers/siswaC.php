<?php

namespace App\Http\Controllers;

use App\Models\siswaM;
use App\Models\kelasM;
use App\Models\jurusanM;
use Illuminate\Http\Request;
use App\Imports\siswaImport;
use Maatwebsite\Excel\Facades\Excel;
use Hash;

class siswaC extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $keyword = empty($request->keyword)?"":$request->keyword;

        $kelas = kelasM::get();
        $jurusan = jurusanM::get();

        $pkelas = empty($request->kelas)?"":$request->kelas;
        $pjurusan = empty($request->jurusan)?"":$request->jurusan;

        $siswa = siswaM::join('kelas', 'kelas.idkelas', 'siswa.idkelas')
        ->join('jurusan', 'jurusan.idjurusan', 'siswa.idjurusan')
        ->where(function ($query) use ($keyword){
            $query->where('siswa.nama', 'like', "%$keyword%")
            ->orWhere('jurusan.jurusan', 'like', "$keyword%")
            ->orWhere('kelas.kelas', 'like', "$keyword%");
        })
        ->orderBy('kelas.kelas', 'asc')
        ->orderBy('jurusan.jurusan', 'desc')
        ->orderBy('siswa.nama', 'asc')
        ->where('kelas.idkelas','like', $pkelas."%")
        ->where('jurusan.idjurusan','like', $pjurusan."%")
        ->select('siswa.*', 'kelas.kelas', 'jurusan.jurusan', 'jurusan.namajurusan')
        // ->orderBy()
        ->paginate(15);

        $jml = siswaM::join('kelas', 'kelas.idkelas', 'siswa.idkelas')
        ->join('jurusan', 'jurusan.idjurusan', 'siswa.idjurusan')
        ->where(function ($query) use ($keyword){
            $query->where('siswa.nama', 'like', "%$keyword%")
            ->orWhere('jurusan.jurusan', 'like', "$keyword%")
            ->orWhere('kelas.kelas', 'like', "$keyword%");
        })
        ->orderBy('kelas.kelas', 'asc')
        ->orderBy('jurusan.jurusan', 'desc')
        ->orderBy('siswa.nama', 'asc')
        ->where('kelas.idkelas','like', $pkelas."%")
        ->where('jurusan.idjurusan','like', $pjurusan."%")
        ->select('siswa.*', 'kelas.kelas', 'jurusan.jurusan', 'jurusan.namajurusan')
        // ->orderBy()
        ->count();

        $siswa->appends($request->only(['keyword', 'limit', 'kelas', 'jurusan']));

        return view('pages.pagesSiswa', [
            'siswa' => $siswa,
            'kelas' => $kelas,
            'jurusan' => $jurusan,

            'pkelas' => $pkelas,
            'pjurusan' => $pjurusan,
            'jml' => $jml,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function import(Request $request)
    {
        Excel::import(new siswaImport, $request->file);

        return redirect()->back()->with('success', 'User Imported Successfully');
    }

    public function updategambar(Request $request, $idsiswa)
    {
        $request->validate([
            'gambar_utama' => 'required|mimes:png,jpg',
        ]);

        try {
            if ($request->hasFile('gambar_utama')) {
                $originName = $request->file('gambar_utama')->getClientOriginalName();
                $fileName = pathinfo($originName, PATHINFO_FILENAME);
                $extension = $request->file('gambar_utama')->getClientOriginalExtension();

                $format = strtolower($extension);
                if($format == 'jpg' || $format == 'jpeg' || $format == 'png') {
                    $fileName = $fileName.'_'.time().'.'.$extension;
                    $upload = $request->file('gambar_utama')->move(\base_path() ."/public/gambar/siswa", $fileName);

                    $update = siswaM::where('idsiswa', $idsiswa)->update([
                        'gambar' => $fileName,
                    ]);
                    if($update) {
                        return redirect()->back()->with('toast_success', 'Success')->withInput();
                    }
                }

            }

            return redirect()->back()->with('toast_error', 'terjadi kesalahan')->withInput();
        } catch (\Throwable $th) {
            return redirect()->back()->with('toast_error', 'terjadi kesalahan')->withInput();
            //throw $th;
        }

    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\siswaM  $siswaM
     * @return \Illuminate\Http\Response
     */
    public function show(siswaM $siswaM)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\siswaM  $siswaM
     * @return \Illuminate\Http\Response
     */
    public function edit(siswaM $siswaM)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\siswaM  $siswaM
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, siswaM $siswaM)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\siswaM  $siswaM
     * @return \Illuminate\Http\Response
     */
    public function destroy(siswaM $siswaM)
    {
        //
    }
}
