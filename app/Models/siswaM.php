<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class siswaM extends Model
{
    use HasFactory;
    protected $table = 'siswa';
    protected $fillable = ['nisn', 'nama', 'alamat', 'jk', 'nis', 'tempatlahir', 'tanggallahir', 'agama', 'idkelas', 'idjurusan'];
}
