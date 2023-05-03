<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class Smk extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perangkat', function (Blueprint $table) {
            $table->String('idperangkat')->primary();
            $table->String('namaperangkat');
            $table->String('ip');
            $table->text('key_post')->unique();
            $table->text('computerId')->unique();
            $table->timestamps();
        });


        Schema::create('siswa', function (Blueprint $table) {
            $table->bigIncrements('idsiswa');
            $table->String('nisn')->unique();
            $table->String('nis')->nullable();
            $table->String('nama');
            $table->enum('jk', ['P', 'L']);
            $table->String('tempatlahir');
            $table->date('tanggallahir');
            $table->String('agama');
            $table->String('alamat');
            $table->String('gambar')->nullable();
            $table->Integer('idkelas');
            $table->Integer('idjurusan');
            $table->timestamps();
        });

        Schema::create('kelas', function (Blueprint $table) {
            $table->bigIncrements('idkelas');
            $table->enum('kelas', ['X', 'XI', 'XII']);
            $table->timestamps();
        });

        Schema::create('jurusan', function (Blueprint $table) {
            $table->bigIncrements('idjurusan');
            $table->String('jurusan');
            $table->String('namajurusan');
            $table->timestamps();
        });

        $kelas = [
            'X',
            'XI',
            'XII',
        ];
        foreach ($kelas as $k) {
            DB::table('kelas')->insert([
                'kelas' => $k,
            ]);
        }
        $jurusan = [
            'TKJ-Teknik Komputer dan Jaringan',
            'ATPH-Agribisnis Tanaman Pangan dan Hortikultura',
            'DPIB-Desain Pemodelan dan Informasi Bangunan',
            'LDP-Lanskap dan Pertamanan',
        ];

        foreach ($jurusan as $j) {
            $ex = explode('-', $j);
            $jurusan = $ex[0];
            $namajurusan = $ex[1];
            DB::table('jurusan')->insert([
                'jurusan' => $jurusan,
                'namajurusan' => $namajurusan,
            ]);
        }


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
