@extends('layouts.app')

@section('title', 'Edit Tanda Jasa – DIKSERA')

@section('content')
<div class="container py-3">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="dash-card p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h6 class="mb-0 fw-bold text-warning">Edit Tanda Jasa</h6>
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

                <form action="{{ route('perawat.tandajasa.update', $tandajasa->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Nama Penghargaan <span class="text-danger">*</span></label>
                            <input type="text" name="nama_penghargaan" class="form-control" value="{{ old('nama_penghargaan', $tandajasa->nama_penghargaan) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Instansi Pemberi</label>
                            <input type="text" name="instansi_pemberi" class="form-control" value="{{ old('instansi_pemberi', $tandajasa->instansi_pemberi) }}">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Tahun Perolehan</label>
                            <input type="number" name="tahun" class="form-control" value="{{ old('tahun', $tandajasa->tahun) }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Nomor SK</label>
                            <input type="text" name="nomor_sk" class="form-control" value="{{ old('nomor_sk', $tandajasa->nomor_sk) }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold">Tanggal SK</label>
                            <input type="date" name="tanggal_sk" class="form-control" value="{{ old('tanggal_sk', $tandajasa->tanggal_sk) }}">
                        </div>

                        <div class="col-12">
                            <label class="form-label small fw-bold">Upload Dokumen</label>
                            <input type="file" name="dokumen" class="form-control">
                            @if($tandajasa->dokumen_path)
                                <div class="mt-2 small">
                                    <span class="text-muted">File saat ini:</span>
                                    <a href="{{ asset('storage/'.$tandajasa->dokumen_path) }}" target="_blank" class="text-decoration-none">
                                        <i class="bi bi-file-earmark-pdf"></i> Lihat Bukti
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="mt-4 text-end">
                        <button type="submit" class="btn btn-warning text-dark px-4">
                            Update Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
