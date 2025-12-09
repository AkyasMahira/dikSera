@extends('layouts.app')

@php
    $pageTitle = 'Edit Sertifikat';
    $pageSubtitle = 'Perbarui data sertifikat atau lampiran dokumen.';
@endphp

@section('title', 'Edit Sertifikat – DIKSERA')

@push('styles')
    <style>
        /* Global Card Style */
        .content-card {
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid var(--border-soft);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
            padding: 24px;
        }

        /* Section Title */
        .section-title {
            font-size: 14px;
            font-weight: 600;
            color: var(--blue-main);
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .section-title::before {
            content: '';
            display: block;
            width: 4px;
            height: 16px;
            background: var(--blue-main);
            border-radius: 4px;
        }

        /* Form Styles */
        .form-control-custom {
            border-radius: 8px;
            border: 1px solid var(--border-soft);
            padding: 10px 12px;
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

        /* Current File Box */
        .current-file-box {
            background: #f8fafc;
            border: 1px solid var(--border-soft);
            border-radius: 8px;
            padding: 12px;
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 12px;
        }
    </style>
@endpush

@section('content')

    {{-- Header Navigasi --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('perawat.certificates.index') }}" class="btn btn-sm btn-outline-secondary px-3"
            style="border-radius: 8px; font-size: 12px;">
            <i class="bi bi-arrow-left"></i> Batal & Kembali
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="content-card">

                <div class="section-title">Formulir Edit Sertifikat</div>

                <form action="{{ route('perawat.certificates.update', $certificate->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Baris 1: Nama & Lembaga --}}
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama Sertifikat <span class="text-danger">*</span></label>
                            <input type="text" name="nama" value="{{ old('nama', $certificate->nama) }}"
                                class="form-control form-control-custom @error('nama') is-invalid @enderror">
                            @error('nama')
                                <div class="invalid-feedback small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Lembaga Penerbit <span class="text-danger">*</span></label>
                            <input type="text" name="lembaga" value="{{ old('lembaga', $certificate->lembaga) }}"
                                class="form-control form-control-custom @error('lembaga') is-invalid @enderror">
                            @error('lembaga')
                                <div class="invalid-feedback small">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Baris 2: Tanggal --}}
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_mulai"
                                value="{{ old('tanggal_mulai', $certificate->tanggal_mulai) }}"
                                class="form-control form-control-custom @error('tanggal_mulai') is-invalid @enderror">
                            @error('tanggal_mulai')
                                <div class="invalid-feedback small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Berakhir <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_akhir"
                                value="{{ old('tanggal_akhir', $certificate->tanggal_akhir) }}"
                                class="form-control form-control-custom @error('tanggal_akhir') is-invalid @enderror">
                            @error('tanggal_akhir')
                                <div class="invalid-feedback small">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Keterangan --}}
                    <div class="mb-4">
                        <label class="form-label">Keterangan (Opsional)</label>
                        <textarea name="keterangan" rows="3" class="form-control form-control-custom">{{ old('keterangan', $certificate->keterangan) }}</textarea>
                    </div>

                    {{-- File Section --}}
                    <div class="mb-4 p-3 rounded-3" style="background-color: #ffff; border: 1px dashed var(--border-soft);">
                        <label class="form-label mb-2">File Lampiran</label>

                        {{-- Info File Lama --}}
                        <div class="current-file-box">
                            <div class="bg-white border rounded p-2 text-primary">
                                <i class="bi bi-file-earmark-check fs-5"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="small fw-bold text-dark">File Tersimpan Saat Ini</div>
                                <a href="{{ Storage::url($certificate->file_path) }}" target="_blank"
                                    class="small text-decoration-none text-primary">
                                    <i class="bi bi-eye"></i> Lihat File Lama
                                </a>
                            </div>
                        </div>

                        {{-- Input File Baru --}}
                        <div class="mt-3">
                            <label class="small text-muted mb-1">Upload File Baru (Biarkan kosong jika tidak ingin
                                mengubah)</label>
                            <input type="file" name="file_sertifikat" class="form-control form-control-custom"
                                accept=".pdf, .jpg, .jpeg, .png">
                            <div class="form-text small text-muted">Format: PDF/JPG/PNG, Maksimal 2MB.</div>
                            @error('file_sertifikat')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                        <button type="submit" class="btn btn-primary btn-sm px-4 shadow-sm"
                            style="border-radius: 8px; background-color: var(--blue-main); border-color: var(--blue-main);">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

@endsection
