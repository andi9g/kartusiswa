<?php

namespace App\Http\Controllers;

use App\Models\siswaM;
use Illuminate\Http\Request;
use PDF;

class kartuC extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('pages.pagesKartu');
    }

    public function cetak(Request $request, $kelas, $jurusan)
    {
        $pkelas = ($kelas==0)?"":$kelas;
        $pjurusan = ($jurusan==0)?"":$jurusan;

        // dd($pkelas);
        $siswa = siswaM::join('kelas', 'kelas.idkelas', 'siswa.idkelas')
        ->join('jurusan', 'jurusan.idjurusan', 'siswa.idjurusan')
        ->orderBy('kelas.kelas', 'asc')
        ->orderBy('jurusan.jurusan', 'desc')
        ->orderBy('siswa.nama', 'asc')
        ->where('kelas.idkelas','like', $pkelas."%")
        ->where('jurusan.idjurusan','like', $pjurusan."%")
        ->select('siswa.*', 'kelas.kelas', 'jurusan.jurusan', 'jurusan.namajurusan')
        ->get();

        $pdf = PDF::LoadView('laporan.pagesCetak', [
            'siswa' => $siswa,
        ])->setPaper('a4', 'landscape');

        return $pdf->stream('buka.pdf');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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
