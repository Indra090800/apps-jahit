@extends('layout.presensi')
@section('content')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
        <div class="section" id="user-section">
            <div id="user-detail">
                <div class="avatar">

                    <!-- @if (!empty(Auth::guard()->user()->foto_pelanggan))
                    @php
                        $path = Storage::url('public/uploads/saksi/'.Auth::guard('buy')->user()->foto_pelanggan);
                    @endphp
                    <img src="{{ url($path) }}" alt="avatar" class="imaged w64 rounded" style="height: 60px;">
                    @else -->
                    <img src="{{ asset('assets/img/sample/avatar/avatar1.jpg') }}" alt="avatar" class="imaged w32 rounded" style="height: 40px;">
                    <!-- @endif -->

                </div>
                <div id="user-info">
                    <h2 id="user-name">{{ Auth::guard('buy')->user()->nama_pelanggan }}</h2>
                    <span id="user-role"><b>Users</span>
                </div>
            </div>
        </div>

        <div class="section" id="menu-section">
            <div class="card">
                <div class="card-body text-center">
                    <div class="list-menu">
                        <div class="item-menu text-center">
                            <div class="menu-icon">
                                <a href="/editprofile" class="green" style="font-size: 40px;">
                                    <ion-icon name="person-sharp"></ion-icon>
                                </a>
                            </div>
                            <div class="menu-name">
                                <span class="text-center">Profil</span>
                            </div>
                        </div>
                        <div class="item-menu text-center">
                            <div class="menu-icon">
                                <a href="/metodebayar" class="danger" style="font-size: 40px;">
                                    <ion-icon name="wallet-outline"></ion-icon>
                                </a>
                            </div>
                            <div class="menu-name">
                                <span class="text-center">Metode Bayar</span>
                            </div>
                        </div>
                        <div class="item-menu text-center">
                            <div class="menu-icon">
                                <a href="" class="warning" style="font-size: 40px;">
                                    <ion-icon name="pricetags-outline"></ion-icon>
                                </a>
                            </div>
                            <div class="menu-name">
                                <span class="text-center">Lihat Pesanan</span>
                            </div>
                        </div>
                        <div class="item-menu text-center">
                            <div class="menu-icon">
                                <a href="" class="orange" style="font-size: 40px;">
                                    <ion-icon name="location"></ion-icon>
                                </a>
                            </div>
                            <div class="menu-name">
                                Lokasi
                            </div>
                        </div>
                        <div class="item-menu text-center">
                            <div class="menu-icon">
                                <a href="/proseslogout" class="danger" style="font-size: 40px;">
                                    <ion-icon name="log-out-outline"></ion-icon>
                                </a>
                            </div>
                            <div class="menu-name">
                                Logout
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="section mt-2" id="presence-section">
            <div class="todaypresence">
                <div class="row">
                    <div class="col-12">
                        <form action="/dashboard" method="GET">
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-group">
                                        <input type="text" name="jenis_jahitan" class="form-control" value="{{ Request('jenis_jahitan') }}" placeholder="Jenis Jahitan">
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="form-group">
                                        <button class="btn btn-primary">Cari</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <tr>
                                    <th>Jenis Jahitan</th>
                                    <th>Harga</th>
                                </tr>
                                @foreach ($jenis as $j)
                                    <tr>
                                        <td>{{ $j->jenis_jahitan }}</td>
                                        <td>{{ $j->harga }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>


            <div class="presencetab mt-2">
                <div class="tab-pane fade show active" id="pilled" role="tabpanel">
                    <ul class="nav nav-tabs style1" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#home" role="tab">
                                Pesanan Saya
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#profile" role="tab">
                                Leaderboard
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content mt-2" style="margin-bottom:100px;">
                    <div class="tab-pane fade show active" id="home" role="tabpanel">
                        <ul class="listview image-listview">


                            <li>
                                <div class="item">
                                    <div class="icon-box bg-primary">
                                        <img src="assets/img/sample/avatar/avatar1.jpg" alt="avatar" class="imaged w32 rounded">
                                    </div>
                                    <div class="in">
                                        <div>Dewi</div>
                                        <span class="badge badge-warning">Kemeja</span>
                                        <span class="badge badge-success">Done</span>
                                    </div>
                                </div>
                            </li>


                        </ul>
                        <style>
                            .historycontent{
                                display: flex;
                            }
                            .datapresensi{
                                margin-left: 10px
                            }
                        </style>
                    </div>
                    <div class="tab-pane fade" id="profile" role="tabpanel">
                        <ul class="listview image-listview">

                            {{-- @foreach ($leaderboard as $l)
                            <li>
                                <div class="item">
                                    <img src="assets/img/sample/avatar/avatar1.jpg" alt="image" class="image">
                                    <div class="in">
                                        <div>
                                            <b>{{ $l->nama_lengkap }}</b><br>
                                            <small class="text-muted">{{ $l->jabatan }}</small>
                                        </div>
                                        <span class="badge {{ $l->jam_in < "07:00" ? "bg-success" : "bg-danger"}}">{{ $l->jam_in }}</span>
                                    </div>
                                </div>
                            </li>
                            @endforeach --}}

                        </ul>
                    </div>

                </div>
            </div>
        </div>

@endsection

