@extends('layout.master')

@php
  

@endphp

@section('activekuPerangkat')
    activeku
@endsection

@section('judul')
    <i class="fa fa-gear"></i> Akses Perangkat
@endsection

@section('content')
<div class="row">
    <div class="col-md-6">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary my-2" data-toggle="modal" data-target="#ruangan">
            Kelola Perangkat Ruangan
        </button>

        <a href="{{ url('/perangkat', []) }}" class="btn btn-secondary">Refresh</a>
        
        <!-- Modal -->
        <div class="modal fade" id="ruangan" tabindex="-1" aria-labelledby="ruanganLabel" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="ruanganLabel">Ruangan Perangkat Ruangan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <form action="{{ route('tambah.perangkat') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class='form-group'>
                            <label for='fornamaperangkat' class='text-capitalize'>NamaLabel</label>
                            <select name='namaperangkat' required id='fornamaperangkat' class='form-control'>
                                <option value=''>Pilih</option>
                                <option value='absensi guru'>Absensi Guru</option>
                            <select>
                        </div> 
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </form>
            </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <form action="{{ url()->current() }}" class="form-inline justify-content-end">
            <div class="input-group mb-3">
                <input type="text" class="form-control" value="{{empty($_GET['keyword'])?'':$_GET['keyword']}}" name="keyword" aria-describedby="button-addon2">
                <div class="input-group-append">
                  <button class="btn btn-outline-success" type="submit" id="button-addon2">Cari</button>
                </div>
            </div>
            
        </form>
    </div>
</div>

<div class="row">

    @foreach ($perangkat as $data)
    <div class="col-md-3 m-3 rounded-lg text-center bg-dark">
            <h1 class="text-bold">{{ $data->namaperangkat }}</h1>
        
            <div class="row">
                <div class="col-sm-6 mx-0 px-0">
                    <button type="button" class="btn btn-success btn-block rounded-0" data-toggle="modal" data-target="#info{{ $data->idperangkat }}" ><i class="fa fa-eye"></i></button>
                </div>

                <div class="col-sm-6 mx-0 px-0">
                    <form action="{{ route('hapus.perangkat', [$data->idperangkat]) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Yakin ingin menghapus perangkat {{ $data->nama_ruangan }}?')" class="btn btn-danger btn-block rounded-0"><i class="fa fa-trash"></i></button>
                    </form>
                </div>
            </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="info{{ $data->idperangkat }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title text-bold" id="exampleModalLabel">perangkat</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                
                <div class="form-group">
                    <label for="">PERANGKAT</label>
                    <input type="text" readonly class="form-control" value="{{ $data->idperangkat }}">
                </div>


                <div class="form-group">
                    <label for="">KEY POST</label>
                    <textarea class="form-control" readonly>{{ $data->key_post }}</textarea>
                </div>

                <div class="form-group">
                    <label for="">COMPUTER ID</label>
                    <textarea class="form-control" readonly>{{ $data->computerId }}</textarea>
                </div>

                <div class="form-group">
                    <label for="">IP</label>
                    <textarea class="form-control" readonly>{{ $data->ip }}</textarea>
                </div>

                @php
                    $myUrl = url('/scan');
                    $myUrl = str_replace("localhost", $_SERVER['REMOTE_ADDR'], $myUrl);
                    $myUrl = str_replace("::1", "Ipaddress or DNS", $myUrl);
                @endphp
                

                <div class="form-group">
                    <label for="">LINKS</label>
                    <textarea class="form-control" readonly>{{ $myUrl."/" }}</textarea>
                </div>

                <center>
                    <p class="text-success text-lowercase">> Silahkan salin info perangkat tersebut kedalam perangkat NodeMCU < </p>
                </center>


            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <form onclick="return confirm('lanjutkan proses reset IP')" action="{{ route('ubah.ip', [$data->idperangkat]) }}" method="post">
                @csrf
                <button type="submit" class="btn btn-success">Reset IP</button>
            </form>
            </div>
        </div>
        </div>
    </div>

        
    @endforeach




    

</div>  


@endsection



@section('myScript')

{{-- <script>
    
    $(document).ready(function(){
        $("#getUID").load("{{ url('perangkatUID/perangkatContainer.php') }}");
        setInterval(function() {
            $("#getUID").load("{{ url('perangkatUID/perangkatContainer.php') }}");

            var isi = document.getElementById("getUID").value;
            if(!isi || isi.length === 0){
                console.log('kosong');
                // document.forms["myForm"].submit();
            }
            
        }, 500);
    });
</script> --}}
    
@endsection