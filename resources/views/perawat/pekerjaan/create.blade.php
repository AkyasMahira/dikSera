@extends('layouts.app')

@section('title', 'Tambah Pekerjaan – DIKSERA')

@section('content')
<div class="container py-3">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="dash-card p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h6 class="mb-0 fw-bold text-primary">+ Tambah Riwayat Pekerjaan</h6>
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

                <form action="{{ route('perawat.pekerjaan.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Nama Instansi *</label>
                            <input type="text" name="nama_instansi" class="form-control" value="{{ old('nama_instansi') }}" placeholder="Contoh: RSUD Kediri" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Jabatan *</label>
                            <input type="text" name="jabatan" class="form-control" value="{{ old('jabatan') }}" placeholder="Contoh: Perawat Pelaksana" required>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label small fw-bold">Tahun Mulai</label>
                            <input type="number" name="tahun_mulai" class="form-control" value="{{ old('tahun_mulai') }}" placeholder="YYYY">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-bold">Tahun Selesai</label>
                            <input type="number" name="tahun_selesai" class="form-control" value="{{ old('tahun_selesai') }}" placeholder="YYYY">
                            <small class="text-muted" style="font-size: 10px;">Kosongi jika masih aktif</small>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Keterangan</label>
                            <input type="text" name="keterangan" class="form-control" value="{{ old('keterangan') }}" placeholder="Catatan tambahan (opsional)">
                        </div>

                        <div class="col-12">
                            <label class="form-label small fw-bold">Upload Dokumen / SK (PDF/Image)</label>
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
