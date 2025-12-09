@extends('layouts.app')

@php
    $pageTitle = 'Tambah Sertifikat';
    $pageSubtitle = 'Upload sertifikat kompetensi atau pelatihan baru.';
@endphp

@section('title', 'Tambah Sertifikat – DIKSERA')

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

        /* Upload Area */
        .upload-area {
            border: 2px dashed var(--border-soft);
            border-radius: 12px;
            padding: 30px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
            background: #f8fafc;
            position: relative;
        }

        .upload-area:hover {
            border-color: var(--blue-main);
            background: var(--blue-soft);
        }

        .upload-icon {
            font-size: 32px;
            color: var(--text-muted);
            margin-bottom: 10px;
        }
    </style>
@endpush

@section('content')

    {{-- Header Navigasi --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('perawat.certificates.index') }}" class="btn btn-sm btn-outline-secondary px-3"
            style="border-radius: 8px; font-size: 12px;">
            <i class="bi bi-arrow-left"></i> Kembali ke Daftar
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="content-card">

                <div class="section-title">Formulir Tambah Sertifikat</div>

                <form action="{{ route('perawat.certificates.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Baris 1: Nama & Lembaga --}}
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Nama Sertifikat <span class="text-danger">*</span></label>
                            <input type="text" name="nama" value="{{ old('nama') }}"
                                class="form-control form-control-custom @error('nama') is-invalid @enderror"
                                placeholder="Contoh: BTCLS 2024">
                            @error('nama')
                                <div class="invalid-feedback small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Lembaga Penerbit <span class="text-danger">*</span></label>
                            <input type="text" name="lembaga" value="{{ old('lembaga') }}"
                                class="form-control form-control-custom @error('lembaga') is-invalid @enderror"
                                placeholder="Contoh: PPNI Pusat">
                            @error('lembaga')
                                <div class="invalid-feedback small">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Baris 2: Tanggal --}}
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}"
                                class="form-control form-control-custom @error('tanggal_mulai') is-invalid @enderror">
                            @error('tanggal_mulai')
                                <div class="invalid-feedback small">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tanggal Berakhir (Expired) <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_akhir" value="{{ old('tanggal_akhir') }}"
                                class="form-control form-control-custom @error('tanggal_akhir') is-invalid @enderror">
                            @error('tanggal_akhir')
                                <div class="invalid-feedback small">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Keterangan --}}
                    <div class="mb-4">
                        <label class="form-label">Keterangan (Opsional)</label>
                        <textarea name="keterangan" rows="3" class="form-control form-control-custom" placeholder="Catatan tambahan...">{{ old('keterangan') }}</textarea>
                    </div>

                    {{-- Upload Area --}}
                    <div class="mb-4">
                        <label class="form-label">Upload File (PDF/Gambar, Max 2MB) <span
                                class="text-danger">*</span></label>

                        <div class="upload-area" onclick="document.getElementById('fileInput').click()">
                            <input type="file" name="file_sertifikat" id="fileInput" class="d-none"
                                accept=".pdf, .jpg, .jpeg, .png" onchange="previewFile(this)">

                            {{-- Placeholder Default --}}
                            <div id="uploadPlaceholder">
                                <div class="upload-icon"><i class="bi bi-cloud-arrow-up"></i></div>
                                <div class="text-muted small">Klik untuk memilih file atau tarik file ke sini</div>
                            </div>

                            {{-- Preview Container --}}
                            <div id="previewContainer" class="d-none mt-2">
                                <div
                                    class="d-inline-flex align-items-center gap-2 bg-white px-3 py-2 rounded shadow-sm border">
                                    <i class="bi bi-file-earmark-check text-success"></i>
                                    <span id="fileNamePreview" class="small fw-bold text-dark"></span>
                                </div>
                                <div class="mt-2 border rounded overflow-hidden bg-white p-1 d-none" id="imgPreviewBox">
                                    <img id="imgPreview" class="img-fluid" style="max-height: 200px;">
                                </div>
                            </div>
                        </div>
                        @error('file_sertifikat')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                        <button type="reset" class="btn btn-light btn-sm px-4" style="border-radius: 8px;">Reset</button>
                        <button type="submit" class="btn btn-primary btn-sm px-4 shadow-sm"
                            style="border-radius: 8px; background-color: var(--blue-main); border-color: var(--blue-main);">
                            Simpan Data
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <script>
        function previewFile(input) {
            const uploadPlaceholder = document.getElementById('uploadPlaceholder');
            const previewContainer = document.getElementById('previewContainer');
            const fileNamePreview = document.getElementById('fileNamePreview');
            const imgPreviewBox = document.getElementById('imgPreviewBox');
            const imgPreview = document.getElementById('imgPreview');

            const file = input.files[0];

            if (file) {
                // Update UI Text
                fileNamePreview.textContent = file.name;
                uploadPlaceholder.classList.add('d-none');
                previewContainer.classList.remove('d-none');

                // Check File Type for Image Preview
                if (file.type.startsWith('image/')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imgPreview.src = e.target.result;
                        imgPreviewBox.classList.remove('d-none');
                    }
                    reader.readAsDataURL(file);
                } else {
                    // Reset if PDF (No Image Preview)
                    imgPreview.src = '';
                    imgPreviewBox.classList.add('d-none');
                }
            }
        }
    </script>
@endsection
