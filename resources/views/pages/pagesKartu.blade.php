@extends('layout.master')

@section('activekuKartu')
    activeku
@endsection

@section('judul')
    <i class="fa fa-indent"></i> Cetak Kartu Siswa
@endsection

@section('content')
<div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3>Form Cetak</h3>
            </div>

            <div class="card-body">
                <div class="form-group">
                    <label for="">Jurusan</label>
                    <select name="jurusan" class="form-control" id="">
                        <option value=""></option>

                    </select>
                </div>
            </div>
        </div>

    </div>
</div>


@endsection
