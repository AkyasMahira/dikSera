@extends('layouts.app')

@section('title', 'Edit Pekerjaan – DIKSERA')

@section('content')
<div class="container py-3">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="dash-card p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h6 class="mb-0 fw-bold text-warning">Edit Riwayat Pekerjaan</h6>
                    <a href="{{ route('perawat.pekerjaan.index') }}" class="btn btn-sm btn-outline-secondary">
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

                <form action="{{ route('perawat.pekerjaan.update', $pekerjaan->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Nama Instansi *</label>
                            <input type="text" name="nama_instansi" class="form-control" value="{{ old('nama_instansi', $pekerjaan->nama_instansi) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Jabatan *</label>
                            <input type="text" name="jabatan" class="form-control" value="{{ old('jabatan', $pekerjaan->jabatan) }}" required>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label small fw-bold">Tahun Mulai</label>
                            <input type="number" name="tahun_mulai" class="form-control" value="{{ old('tahun_mulai', $pekerjaan->tahun_mulai) }}" placeholder="YYYY">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-bold">Tahun Selesai</label>
                            <input type="number" name="tahun_selesai" class="form-control" value="{{ old('tahun_selesai', $pekerjaan->tahun_selesai) }}" placeholder="YYYY">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Keterangan</label>
                            <input type="text" name="keterangan" class="form-control" value="{{ old('keterangan', $pekerjaan->keterangan) }}">
                        </div>

                        <div class="col-12">
                            <label class="form-label small fw-bold">Upload Dokumen / SK</label>
                            <input type="file" name="dokumen" class="form-control">
                            @if($pekerjaan->dokumen_path)
                                <div class="mt-2 small">
                                    <span class="text-muted">File saat ini:</span>
                                    <a href="{{ asset('storage/'.$pekerjaan->dokumen_path) }}" target="_blank" class="text-decoration-none">
                                        <i class="bi bi-file-earmark-text"></i> Lihat Dokumen
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
