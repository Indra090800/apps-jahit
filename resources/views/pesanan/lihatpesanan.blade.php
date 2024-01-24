@extends('layout.presensi');
@section('header')

    <div class="appHeader bg-success text-light">
        <div class="left">
            <a href="javascript:;" class="headerButton goBacc">
                <ion-icon name="chevron-bacc-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Data Pesanan</div>
        <div class="right"></div>
    </div>
    <style>
        table, th, td
         {

        border
        : 2px solid green;
        }
    </style>
@endsection

@section('content')

<div class="row" style="margin-top: 3rem;">
    <div class="col">
    @php
        $messagesuccess = Session::get('success');
        $messageerror = Session::get('error');
    @endphp
    @if (Session::get('success'))
        <div class="alert alert-outline-success">
            {{ $messagesuccess }}
        </div>
    @else
        <div class="alert alert-outline-error">
            {{ $messageerror }}
        </div>
    @endif

    </div>
</div>

<div class="row">
    <div class="col">
        <div class="card mt-2">
            <div class="card-body">
                <div class="table-responsive" style="overflow-x:auto;">
                    <table class="table table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th class="text-center">No Antrian</th>
                                <th class="text-center">No Pesanan</th>
                                <th class="text-center">Jenis Jahit</th>
                                <th class="text-center">Jumlah</th>
                                <th class="text-center">Bahan</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Bukti</th>
                                <th class="text-center">Tanggal Pesan</th>
                                <th class="text-center">Tanggal Kirim</th>
                                <th class="text-center">Total Bayar</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($mypes as $k)
                                <?php
                                    $bayar = DB::table('tb_pembayaran')->where('pesanan_id', $k->pesanan_id)->first();
                                    $path = Storage::url('uploads/bukti_bayar/'.$bayar->bukti_bayar);
                                ?>
                                <tr>
                                    <td class="text-center">{{ $k->no_antrian }}</td>
                                    <td class="text-center">{{ $k->pesanan_id }}</td>
                                    <td class="text-center">{{ $k->jenis_jahitan }}</td>
                                    <td class="text-center">{{ $k->jumlah }}</td>
                                    <td class="text-center">{{ $k->bahan }}</td>
                                    <td class="text-center">
                                        @if ($k->status_pesanan == 0)
                                            <button class="btn btn-danger btn-sm">Not Verified</button>
                                        @else
                                            <button class="btn btn-success btn-sm"> Verified</button>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        @if (empty($bayar->bukti_bayar))
                                        -
                                        @else
                                        <img src="{{ url($path) }}" width="50px" class="avatar" alt="">
                                        @endif
                                    </td>
                                    <td class="text-center">{{ $k->tgl_pemesanan }}</td>
                                    <td class="text-center">{{ $k->tgl_kirim == null ? 'on progress' : $k->tgl_kirim }}</td>
                                    <td class="text-center">{{ currency_IDR($bayar->total_bayar) }}</td>
                                    <td class="text-center">
                                        @if ($k->status_pesanan == 1)
                                            <button class="btn btn-danger btn-sm">No Access</button>
                                        @else
                                            <div class="btn-group">
                                            <form action="/pesanan/{{ $k->pesanan_id }}/deleteS" method="POST" style="margin-left: 5px;">
                                                @csrf
                                                <a class="btn btn-danger btn-sm btnEdit">
                                                    <ion-icon name="trash-outline"></ion-icon>
                                                </a>
                                                <a href="/editpesan/{{ $k->pesanan_id }}" class="btn btn-warning btn-sm">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                                    <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path>
                                                    <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path>
                                                    <path d="M16 5l3 3"></path>
                                                    </svg>
                                                </a>
                                            </form>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="fab-button animate bottom-right dropdown" style="margin-bottom: 70px;">
    <a href="/jahit/pesan" class="fab bg-success" >
        <ion-icon name="add-outline" role="img" class="md hydrated"></ion-icon>
    </a>
</div>

@endsection

@push('myscript')

<script>
    $(function(){
        $(".btnEdit").click(function(e){
                var form = $(this).closest('form');
                e.preventDefault();
                Swal.fire({
                    title: 'Apakah yakin ingin menghapus?',
                    showCancelButton: true,
                    confirmButtonText: 'Hapus',
                }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                if (result.isConfirmed) {
                    form.submit();
                    Swal.fire('Data Berhasil Di Hapus !!!', '', 'success')
                }
                })
        });
        $("#frmmetode").submit(function(){
            var metode_bayar = $("#metode_bayar").val();
                var bukti_bayar = $("#fileuploadInput").val();

                if(metode_bayar == "Transfer Bank" && bukti_bayar == ""){
                    Swal.fire({
                    title: 'Oops!',
                    text: "Bukti Bayar harus diisi!!",
                    icon: 'warning',
                    });
                    return false;
                }
        });

    });


</script>
@endpush