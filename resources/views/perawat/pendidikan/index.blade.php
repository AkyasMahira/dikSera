@extends('layouts.app')

{{-- Mengatur Judul Halaman agar muncul di Header Layout --}}
@php
    $pageTitle = 'Riwayat Pendidikan';
    $pageSubtitle = 'Kelola data pendidikan formal dan akademik Anda.';
@endphp

@section('title', 'Pendidikan – DIKSERA')

@push('styles')
<style>
    /* Card Container Khusus Halaman Ini */
    .content-card {
        background: #ffffff;
        border-radius: 16px;
        border: 1px solid var(--border-soft);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
        padding: 24px;
    }

    /* Styling Form Input agar lebih soft */
    .form-control-custom {
        border-radius: 8px;
        border: 1px solid var(--border-soft);
        padding: 8px 12px;
        font-size: 13px;
        transition: all 0.2s;
    }
    .form-control-custom:focus {
        border-color: var(--blue-main);
        box-shadow: 0 0 0 3px var(--blue-soft);
    }
    .form-label {
        font-size: 12px;
        font-weight: 500;
        color: var(--text-muted);
        margin-bottom: 6px;
    }

    /* Styling Tabel */
    .table-custom th {
        background-color: var(--blue-soft-2);
        color: var(--text-main);
        font-weight: 600;
        font-size: 12px;
        border-bottom: 2px solid #dbeafe;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        padding: 12px 8px;
    }
    .table-custom td {
        vertical-align: middle;
        padding: 10px 8px;
        border-bottom: 1px solid var(--blue-soft-2);
    }
    
    /* Tombol Aksi */
    .btn-action {
        border-radius: 8px;
        font-size: 11px;
        padding: 6px 10px;
        font-weight: 500;
    }
</style>
@endpush

@section('content')

    {{-- Tombol Kembali (Opsional, jika ingin ditaruh di atas card) --}}
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('perawat.drh') }}" class="btn btn-sm btn-outline-secondary px-3" style="border-radius: 8px; font-size: 12px;">
            <i class="bi bi-arrow-left"></i> Kembali ke DRH
        </a>
    </div>

    <div class="content-card">
        
        {{-- Alert Error --}}
        @if($errors->any())
            <div class="alert alert-danger py-2 px-3 small rounded-3 mb-4 border-0 bg-danger-subtle text-danger">
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- FORM TAMBAH --}}
        <div class="p-3 mb-4 rounded-3" style="background-color: #f8fafc; border: 1px dashed var(--border-soft);">
            <h6 class="mb-3" style="font-size: 14px; color: var(--blue-main); font-weight: 600;">
                + Tambah Data Pendidikan
            </h6>
            <form action="{{ route('perawat.pendidikan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-3 align-items-end">
                    <div class="col-md-2">
                        <label class="form-label">Jenjang <span class="text-danger">*</span></label>
                        <input type="text" name="jenjang" class="form-control form-control-custom" placeholder="Contoh: S1">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Nama Institusi <span class="text-danger">*</span></label>
                        <input type="text" name="nama_institusi" class="form-control form-control-custom" placeholder="Nama Kampus">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Akreditasi</label>
                        <input type="text" name="akreditasi" class="form-control form-control-custom" placeholder="A/B">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Tempat</label>
                        <input type="text" name="tempat" class="form-control form-control-custom" placeholder="Kota">
                    </div>
                    <div class="col-md-1">
                        <label class="form-label">Lulus</label>
                        <input type="text" name="tahun_lulus" class="form-control form-control-custom" placeholder="202X">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Ijazah (PDF)</label>
                        <input type="file" name="dokumen" class="form-control form-control-custom" style="padding: 5px 8px;">
                    </div>
                </div>
                <div class="mt-3 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary btn-sm px-4" style="border-radius: 8px; background: var(--blue-main); border: none;">
                        Simpan Data
                    </button>
                </div>
            </form>
        </div>

        {{-- TABEL LIST --}}
        <div class="table-responsive">
            <table class="table table-custom table-hover mb-0">
                <thead>
                    <tr>
                        <th style="width:40px;">No</th>
                        <th>Jenjang & Institusi</th>
                        <th>Akreditasi</th>
                        <th>Tempat</th>
                        <th>Thn Lulus</th>
                        <th>Dokumen</th>
                        <th style="width:140px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pendidikan as $i => $row)
                        <tr>
                            <td class="text-center text-muted">{{ $i+1 }}</td>
                            
                            {{-- Form Update Inline --}}
                            <td colspan="6" class="p-0">
                                <form action="{{ route('perawat.pendidikan.update',$row->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    {{-- Menggunakan layout tabel tricky agar form sejajar --}}
                                    <table class="w-100 m-0 bg-transparent">
                                        <tr>
                                            <td style="border:none; width: 25%;">
                                                <input type="text" name="jenjang" value="{{ $row->jenjang }}" class="form-control form-control-custom mb-1" style="font-weight:600;">
                                                <input type="text" name="nama_institusi" value="{{ $row->nama_institusi }}" class="form-control form-control-custom text-muted" style="font-size: 11px;">
                                            </td>
                                            <td style="border:none;">
                                                <input type="text" name="akreditasi" value="{{ $row->akreditasi }}" class="form-control form-control-custom text-center">
                                            </td>
                                            <td style="border:none;">
                                                <input type="text" name="tempat" value="{{ $row->tempat }}" class="form-control form-control-custom">
                                            </td>
                                            <td style="border:none; width: 80px;">
                                                <input type="text" name="tahun_lulus" value="{{ $row->tahun_lulus }}" class="form-control form-control-custom text-center">
                                            </td>
                                            <td style="border:none;">
                                                <div class="d-flex flex-column gap-1" style="font-size: 11px;">
                                                    <input type="file" name="dokumen" class="form-control form-control-custom" style="padding: 4px; font-size: 10px;">
                                                    @if($row->dokumen_path)
                                                        <a href="{{ asset('storage/'.$row->dokumen_path) }}" target="_blank" class="text-decoration-none text-primary">
                                                            <i class="bi bi-file-earmark-pdf"></i> Lihat File
                                                        </a>
                                                    @else
                                                        <span class="text-muted text-opacity-50">- Kosong -</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td style="border:none; width: 140px;">
                                                <div class="d-flex gap-2">
                                                    <button type="submit" class="btn btn-action btn-outline-primary" title="Simpan Perubahan">
                                                        Update
                                                    </button>
                                </form> 
                                {{-- Tutup Form Update --}}
                                
                                                    <form action="{{ route('perawat.pendidikan.destroy',$row->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data pendidikan ini?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-action btn-outline-danger" title="Hapus Data">
                                                            Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="text-muted mb-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="text-muted opacity-25"><path d="M22 10v6M2 10v6"/><path d="M2 10l10-5 10 5-10 5z"/><path d="M12 12v9"/></svg>
                                </div>
                                <span class="text-muted" style="font-size: 13px;">Belum ada data riwayat pendidikan.</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection