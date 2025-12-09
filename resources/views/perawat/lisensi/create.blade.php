@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Tambah Dokumen Lisensi</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('perawat.lisensi.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- PERUBAHAN: Input Jenis diketik manual (String) --}}
                <div class="mb-3">
                    <label>Jenis Dokumen <span class="text-danger">*</span></label>
                    <input type="text" name="jenis" class="form-control" placeholder="Contoh: STR, SIP, Sertifikat ACLS" required>
                </div>

                <div class="mb-3">
                    <label>Nomor Dokumen <span class="text-danger">*</span></label>
                    <input type="text" name="nomor" class="form-control" placeholder="Nomor Surat/Sertifikat" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Tanggal Terbit <span class="text-danger">*</span></label>
                        <input type="date" name="tgl_terbit" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Tanggal Expired (Berlaku Sampai) <span class="text-danger">*</span></label>
                        <input type="date" name="tgl_expired" class="form-control" required>
                        <small class="text-muted">Status (Aktif/Expired) dihitung otomatis oleh sistem.</small>
                    </div>
                </div>

                <div class="mb-3">
                    <label>Upload File Dokumen <span class="text-danger">*</span></label>
                    <input type="file" name="dokumen" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
</div>
@endsection
