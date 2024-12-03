@extends('layouts.app') <!-- Pastikan menggunakan layout yang benar -->

@section('content')
    <div class="d-flex flex-column gap-4">
        <!-- Summary Card -->
        <div class="card">
            <div class="card-header">SUMMARY</div>
            <div class="card-body">
                <div class="row mb-4">
                    <!-- Jumlah Transaksi -->
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Jumlah Transaksi</h5>
                                <h4><span </h4>
                            </div>
                        </div>
                    </div>

                    <!-- Jumlah Item Terjual (kosong karena belum ada data) -->
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Jumlah Item Terjual</h5>
                                <h4><span class="badge text-bg-secondary">-</span></h4>
                            </div>
                        </div>
                    </div>

                    <!-- Omzet (kosong karena belum ada data) -->
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Omzet</h5>
                                <h4><span class="badge text-bg-secondary">-</span></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Links -->
        <div class="card">
            <div class="card-header">DATA</div>
            <div class="card-body">
                <div class="list-group">
                    <a href="{{ route('transaksi.create') }}" class="list-group-item list-group-item-action">Tambah
                        Transaksi</a>
                    <a href="{{ route('transaksi.index') }}" class="list-group-item list-group-item-action">Lihat
                        Transaksi</a>
                    <a href="{{ route('transaksidetail.index') }}" class="list-group-item list-group-item-action">Lihat
                        Transaksi Detail</a>
                </div>
            </div>
        </div>
    </div>
@endsection
