@extends('layouts.app')

@section('title', 'Tambah Tanda Jasa – DIKSERA')

@section('content')
<div class="container py-3">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="dash-card p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h6 class="mb-0 fw-bold text-primary">+ Tambah Tanda Jasa</h6>
                    <a href="{{ route('perawat.tandajasa.index') }}" class="btn btn-sm btn-outline-secondary">
                        Kembali
                    </a>
                </div>

                @if($errors->any())
                    <div class="alert alert-danger py-2 px-3 small mb-3">
                        <ul class="mb-0 ps-3">
                            @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('perawat.tandajasa.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Nama Penghargaan <span class="text-danger">*</span></label>
                            <input type="text" name="nama_penghargaan" class="form-control" value="{{ old('nama_penghargaan') }}" placeholder="Contoh: Perawat Teladan" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Instansi Pemberi</label>
                            <input type="text" name="instansi_pemberi" class="form-control" value="{{ old('instansi_pemberi') }}" placeholder="Nama Instansi">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Tahun Perolehan</label>
                            <input type="number" name="tahun" class="form-control" value="{{ old('tahun') }}" placeholder="YYYY">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Nomor SK</label>
                            <input type="text" name="nomor_sk" class="form-control" value="{{ old('nomor_sk') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Tanggal SK</label>
                            <input type="date" name="tanggal_sk" class="form-control" value="{{ old('tanggal_sk') }}">
                        </div>

                        <div class="col-12">
                            <label class="form-label small fw-bold">Upload Dokumen Bukti (PDF/Image)</label>
                            <input type="file" name="dokumen" class="form-control">
                        </div>
                    </div>

                    <div class="mt-4 text-end">
                        <button type="submit" class="btn btn-primary px-4">
                            Simpan Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
