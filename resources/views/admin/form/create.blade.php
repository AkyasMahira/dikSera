@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm border-0" style="max-width: 800px; margin: 0 auto;">
        <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
            <h4 class="card-title">Buat Form Baru</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.form.store') }}" method="POST">
                @csrf
                
                {{-- Judul --}}
                <div class="mb-3">
                    <label class="form-label">Judul Formulir / Ujian</label>
                    <input type="text" name="judul" class="form-control form-control-lg" placeholder="Contoh: Ujian Kompetensi Perawat 2024" required>
                </div>

                {{-- Deskripsi --}}
                <div class="mb-3">
                    <label class="form-label">Deskripsi / Petunjuk</label>
                    <textarea name="deskripsi" class="form-control" rows="3" placeholder="Deskripsi form..."></textarea>
                </div>

                <div class="row">
                    {{-- Waktu Mulai --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Waktu Mulai</label>
                        <input type="datetime-local" name="waktu_mulai" class="form-control" required>
                    </div>

                    {{-- Waktu Selesai --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Waktu Selesai</label>
                        <input type="datetime-local" name="waktu_selesai" class="form-control" required>
                    </div>
                </div>

                <hr>

                {{-- Target Peserta --}}
                <div class="mb-4">
                    <label class="form-label d-block">Target Peserta</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="target_peserta" id="semua" value="semua" checked>
                        <label class="form-check-label" for="semua">Semua Perawat</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="target_peserta" id="khusus" value="khusus">
                        <label class="form-check-label" for="khusus">Khusus (Dipilih Nanti)</label>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.form.index') }}" class="btn btn-light">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan & Lanjut</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection