@extends('layouts.app')

@php
    $pageTitle = 'Buat Form Baru';
    $pageSubtitle = 'Buat jadwal ujian atau formulir pengumpulan data.';
@endphp

@section('title', 'Buat Form – Admin DIKSERA')

@push('styles')
    <style>
        /* Global Card */
        .content-card {
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid var(--border-soft);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
            padding: 32px;
        }

        /* Form Styles */
        .form-control-custom {
            border-radius: 8px;
            border: 1px solid var(--border-soft);
            padding: 10px 12px;
            font-size: 14px;
            transition: all 0.2s;
        }

        .form-control-custom:focus {
            border-color: var(--blue-main);
            box-shadow: 0 0 0 3px var(--blue-soft);
        }

        .form-label {
            font-size: 12px;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 6px;
        }

        /* Target Selection Cards */
        .target-option {
            cursor: pointer;
        }

        .target-card {
            border: 1px solid var(--border-soft);
            border-radius: 10px;
            padding: 15px;
            background: #f8fafc;
            transition: all 0.2s;
            height: 100%;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .target-radio:checked+.target-card {
            border-color: var(--blue-main);
            background: var(--blue-soft);
            box-shadow: 0 0 0 2px var(--blue-soft);
        }

        .target-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: var(--text-muted);
            border: 1px solid var(--border-soft);
        }

        .target-radio:checked+.target-card .target-icon {
            background: var(--blue-main);
            color: #fff;
            border-color: var(--blue-main);
        }

        /* Participant List Item */
        .participant-item {
            border: 1px solid var(--border-soft);
            border-radius: 8px;
            padding: 10px;
            transition: all 0.2s;
            background: #fff;
        }

        .participant-item:hover {
            background: #fcfcfc;
        }

        .participant-item.urgent {
            border-color: #fecaca;
            /* Red-200 */
            background: #fef2f2;
            /* Red-50 */
        }

        .custom-scroll {
            max-height: 320px;
            overflow-y: auto;
            padding-right: 5px;
        }

        /* Custom Scrollbar */
        .custom-scroll::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scroll::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .custom-scroll::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
    </style>
@endpush

@section('content')

    <div class="row justify-content-center">
        <div class="col-lg-8">

            {{-- Tombol Kembali (Kanan Atas) --}}
            <div class="d-flex justify-content-end mb-3">
                <a href="{{ route('admin.form.index') }}" class="btn btn-sm btn-outline-secondary px-3"
                    style="border-radius: 8px;">
                    <i class="bi bi-arrow-left"></i> Kembali ke Daftar Form
                </a>
            </div>

            <form action="{{ route('admin.form.store') }}" method="POST">
                @csrf
                <div class="content-card">

                    <h5 class="mb-4 fw-bold text-dark border-bottom pb-3">Buat Formulir Baru</h5>

                    {{-- 1. Informasi Dasar --}}
                    <div class="mb-4">
                        <label class="form-label">Judul Formulir / Ujian <span class="text-danger">*</span></label>
                        <input type="text" name="judul" class="form-control form-control-custom fw-bold"
                            placeholder="Contoh: Ujian Kompetensi Perawat 2024" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Deskripsi / Petunjuk</label>
                        <textarea name="deskripsi" class="form-control form-control-custom" rows="4"
                            placeholder="Tuliskan deskripsi singkat atau instruksi pengerjaan..."></textarea>
                    </div>

                    {{-- 2. Jadwal --}}
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label">Waktu Mulai <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0 text-muted"
                                    style="border-color: var(--border-soft);"><i class="bi bi-calendar-event"></i></span>
                                <input type="datetime-local" name="waktu_mulai"
                                    class="form-control form-control-custom border-start-0 ps-0" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Waktu Selesai <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0 text-muted"
                                    style="border-color: var(--border-soft);"><i class="bi bi-calendar-check"></i></span>
                                <input type="datetime-local" name="waktu_selesai"
                                    class="form-control form-control-custom border-start-0 ps-0" required>
                            </div>
                        </div>
                    </div>

                    <hr class="border-light my-4">

                    {{-- 3. Target Peserta (Selection Cards) --}}
                    <div class="mb-4">
                        <label class="form-label mb-3">Siapa yang dapat mengakses form ini?</label>

                        <div class="row g-3">
                            {{-- Pilihan: Semua --}}
                            <div class="col-md-6">
                                <label class="target-option w-100 h-100">
                                    <input class="form-check-input d-none target-radio" type="radio" name="target_peserta"
                                        value="semua" checked onclick="togglePeserta(false)">
                                    <div class="target-card">
                                        <div class="target-icon"><i class="bi bi-people"></i></div>
                                        <div>
                                            <div class="fw-bold text-dark">Semua Perawat</div>
                                            <div class="text-muted small" style="font-size: 11px;">Form terbuka untuk
                                                seluruh perawat terdaftar.</div>
                                        </div>
                                    </div>
                                </label>
                            </div>

                            {{-- Pilihan: Khusus --}}
                            <div class="col-md-6">
                                <label class="target-option w-100 h-100">
                                    <input class="form-check-input d-none target-radio" type="radio" name="target_peserta"
                                        value="khusus" onclick="togglePeserta(true)">
                                    <div class="target-card">
                                        <div class="target-icon"><i class="bi bi-person-check"></i></div>
                                        <div>
                                            <div class="fw-bold text-dark">Perawat Tertentu</div>
                                            <div class="text-muted small" style="font-size: 11px;">Pilih manual perawat yang
                                                diizinkan.</div>
                                        </div>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>

                    {{-- Daftar Peserta --}}
                    <div id="list-peserta-container" class="card p-3 bg-light border-0 mb-4" style="display: none;">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <label class="form-label text-muted small mb-0">Silakan centang perawat yang diizinkan:</label>
                            <small class="text-danger fw-bold" style="font-size: 0.75rem;">
                                <i class="bi bi-exclamation-circle-fill"></i> Dokumen mau/sudah expired
                            </small>
                        </div>

                        <div class="row" style="max-height: 300px; overflow-y: auto;">
                            @foreach ($users as $user)
                                @php
                                    // Panggil accessor yang kita buat di Model tadi
                                    $warnings = $user->dokumen_warning;
                                    $isUrgent = count($warnings) > 0;

                                    $bgClass = $isUrgent ? 'bg-warning-subtle border-warning' : '';
                                    $textClass = $isUrgent ? 'text-dark fw-bold' : 'text-secondary';
                                @endphp

                                <div class="col-md-6 mb-2">
                                    <div class="form-check p-2 rounded {{ $bgClass }}">
                                        <input class="form-check-input" type="checkbox" name="participants[]"
                                            value="{{ $user->id }}" id="user_{{ $user->id }}">

                                        <label class="form-check-label w-100 {{ $textClass }}"
                                            for="user_{{ $user->id }}">
                                            {{ $user->name }}

                                            {{-- Loop untuk menampilkan Badge dokumen apa saja yang expired --}}
                                            @if ($isUrgent)
                                                <div class="mt-1">
                                                    @foreach ($warnings as $docName)
                                                        <span class="badge bg-danger"
                                                            style="font-size: 0.6rem;">{{ $docName }} Exp!</span>
                                                    @endforeach
                                                </div>
                                            @endif

                                            <div class="text-muted fw-normal mt-1" style="font-size: 0.75rem;">
                                                {{ $user->email ?? $user->nip }}
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @if ($users->isEmpty())
                            <div class="text-danger small">Belum ada data perawat di database.</div>
                        @endif
                    </div>

                    {{-- Action Buttons --}}
                    <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                        <button type="reset" class="btn btn-light px-4" style="border-radius: 8px;">Reset</button>
                        <button type="submit" class="btn btn-primary px-4 shadow-sm" style="border-radius: 8px;">
                            <i class="bi bi-save me-1"></i> Simpan Form
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>

    {{-- Script Toggle --}}
    <script>
        function togglePeserta(show) {
            const container = document.getElementById('list-peserta-container');
            if (show) {
                // Efek fade in simple
                container.style.display = 'block';
                container.style.opacity = 0;
                setTimeout(() => {
                    container.style.opacity = 1;
                    container.style.transition = 'opacity 0.3s';
                }, 10);
            } else {
                container.style.display = 'none';
            }
        }

        // Jalankan saat load (untuk handle old input jika validasi gagal)
        document.addEventListener("DOMContentLoaded", function() {
            const selected = document.querySelector('input[name="target_peserta"]:checked');
            if (selected && selected.value === 'khusus') {
                togglePeserta(true);
            }
        });
    </script>
@endsection
