@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header bg-warning">
            <h5 class="mb-0">Edit Dokumen Lisensi</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('perawat.lisensi.update', $lisensi->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- PERUBAHAN: Input Jenis diketik manual --}}
                <div class="mb-3">
                    <label>Jenis Dokumen <span class="text-danger">*</span></label>
                    <input type="text" name="jenis" class="form-control" value="{{ $lisensi->jenis }}" required>
                </div>

                <div class="mb-3">
                    <label>Nomor Dokumen <span class="text-danger">*</span></label>
                    <input type="text" name="nomor" class="form-control" value="{{ $lisensi->nomor }}" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label>Tanggal Terbit</label>
                        <input type="date" name="tgl_terbit" class="form-control" value="{{ $lisensi->tgl_terbit->format('Y-m-d') }}" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label>Tanggal Expired</label>
                        <input type="date" name="tgl_expired" class="form-control" value="{{ $lisensi->tgl_expired->format('Y-m-d') }}" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label>Ganti File (Kosongkan jika tidak ingin mengubah)</label>
                    <input type="file" name="dokumen" class="form-control">
                    @if($lisensi->file_path)
                        <small class="text-info">File saat ini tersimpan.</small>
                    @endif
                </div>

                <button type="submit" class="btn btn-success">Update</button>
            </form>
        </div>
    </div>
</div>
@endsection
