@extends('layouts.app')

{{-- Mengatur Header Layout --}}
@php
    $pageTitle = 'Sertifikat & Kompetensi';
    $pageSubtitle = 'Kelola data sertifikat, lisensi, dan bukti kompetensi Anda.';
@endphp

@section('title', 'Sertifikat – DIKSERA')

@push('styles')
    <style>
        /* Card Container */
        .content-card {
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid var(--border-soft);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
            padding: 24px;
        }

        /* Custom Table Style */
        .table-custom th {
            background-color: var(--blue-soft-2);
            color: var(--text-main);
            font-weight: 600;
            font-size: 12px;
            border-bottom: 2px solid #dbeafe;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 12px 16px;
            vertical-align: middle;
        }

        .table-custom td {
            vertical-align: middle;
            padding: 12px 16px;
            border-bottom: 1px solid var(--blue-soft-2);
            font-size: 13px;
        }

        /* Action Buttons (Icon Only) */
        .btn-action {
            width: 32px;
            height: 32px;
            padding: 0;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }

        .btn-action:hover {
            transform: translateY(-2px);
        }
    </style>
@endpush

@section('content')

    {{-- Tombol Navigasi Atas --}}
    <div class="d-flex justify-content-end mb-3 gap-2">
        <a href="{{ route('perawat.drh') }}" class="btn btn-sm btn-outline-secondary px-3"
            style="border-radius: 8px; font-size: 12px;">
            <i class="bi bi-arrow-left"></i> Kembali ke DRH
        </a>
        <a href="{{ route('perawat.certificates.create') }}" class="btn btn-sm btn-primary px-3"
            style="border-radius: 8px; font-size: 12px; background-color: var(--blue-main); border-color: var(--blue-main);">
            <i class="bi bi-plus-lg"></i> Tambah Sertifikat
        </a>
    </div>

    <div class="content-card">

        {{-- Alert Notification --}}
        @if (session('success'))
            <div
                class="alert alert-success border-0 bg-success-subtle text-success small rounded-3 mb-4 d-flex align-items-center gap-2">
                <i class="bi bi-check-circle-fill"></i>
                {{ session('success') }}
            </div>
        @endif

        {{-- Tabel Data --}}
        <div class="table-responsive">
            <table class="table table-custom table-hover mb-0">
                <thead>
                    <tr>
                        <th style="width:50px;" class="text-center">No</th>
                        <th>Nama Sertifikat / Lembaga</th>
                        <th>Masa Berlaku</th>
                        <th>Dokumen</th>
                        <th style="width:120px;" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($certificates as $key => $item)
                        <tr>
                            <td class="text-center text-muted">{{ $loop->iteration }}</td>
                            <td>
                                <div class="fw-bold text-dark">{{ $item->nama }}</div>
                                <div class="text-muted small mb-1">
                                    <i class="bi bi-building me-1"></i> {{ $item->lembaga }}
                                </div>
                                @if ($item->keterangan)
                                    <div class="text-muted fst-italic" style="font-size: 11px;">
                                        "{{ Str::limit($item->keterangan, 40) }}"
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex flex-column gap-1" style="font-size: 12px;">
                                    <span class="text-success">
                                        <i class="bi bi-calendar-check me-1"></i>
                                        {{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M Y') }}
                                    </span>
                                    <span class="text-danger">
                                        <i class="bi bi-calendar-x me-1"></i>
                                        {{ \Carbon\Carbon::parse($item->tanggal_akhir)->format('d M Y') }}
                                    </span>
                                </div>
                            </td>
                            <td>
                                <a href="{{ Storage::url($item->file_path) }}" target="_blank"
                                    class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center gap-1"
                                    style="font-size: 11px; border-radius: 6px;">
                                    <i class="bi bi-file-earmark-pdf text-danger"></i> Lihat
                                </a>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('perawat.certificates.edit', $item->id) }}"
                                        class="btn btn-action btn-outline-warning" title="Edit" data-bs-toggle="tooltip">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    <form action="{{ route('perawat.certificates.destroy', $item->id) }}" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus sertifikat ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-action btn-outline-danger" title="Hapus"
                                            data-bs-toggle="tooltip">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="text-muted mb-2">
                                    <i class="bi bi-award display-6 opacity-25"></i>
                                </div>
                                <span class="text-muted small">Belum ada data sertifikat yang ditambahkan.</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
