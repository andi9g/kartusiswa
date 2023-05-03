<?php

namespace App\Imports;

use App\Models\siswaM;
use App\Models\kelasM;
use App\Models\jurusanM;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class siswaImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {

        $exKelas = explode(" ", $row['kelas']);
        // dd($exKelas);
        $kelas = $exKelas[0];
        $jurusan = $exKelas[1];
        // dd($jurusan);
        $data = kelasM::where('kelas', $kelas)->first();
        $idkelas = $data->idkelas;

        $data = jurusanM::where('jurusan', $jurusan)->first();
        $idjurusan = $data->idjurusan;

        $RTRW = "";
        if(!empty($row['rt'])){
            $RT = $row['rt'];
            $RW = $row['rw'];
            if($RT > 0 && $RW > 0) {
                if($RT < 10) {
                    $rt = "RT.0".$RT;
                }else {
                    $rt = "RT.".$RT;
                }
                if($RW < 10) {
                    $rw = "RW.0".$RW;
                }else {
                    $rw = "RW.".$RW;
                }
                $RTRW = $rt." ".$rw.", ";
            }
        }

        $dusun = empty($row['dusun'])?"":"Dusun ".str_replace("dusun ", "",strtolower($row['dusun'])).", ";
        $kelurahan = ucwords(strtolower(empty($row['kelurahan'])?"":"Kel. ".str_replace("Kel.", "",$row['kelurahan'])).", ");
        $kecamatan = ucwords(strtolower(empty($row['kecamatan'])?"":"Kec. ".str_replace("Kec.", "",$row['kecamatan'])).", ");
        $alamat = ucwords(strtolower($row['alamat'])).", ".$RTRW.$dusun.$kelurahan.$kecamatan;

        return new siswaM([
            'nisn' => $row['nisn'],
            'nama' => $row['nama'],
            'jk' => $row['jk'],
            'tempatlahir' => $row['tempat_lahir'],
            'tanggallahir' => $row['tanggal_lahir'],
            'agama' => $row['agama'],
            'alamat' => $alamat,
            'idkelas' => $idkelas,
            'idjurusan' => $idjurusan,
        ]);
    }
}
