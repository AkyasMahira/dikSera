@extends('layouts.app')

@section('title', 'Manajemen Akun Pengguna')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
    :root {
        --primary-blue: #2563eb;
        --primary-hover: #1d4ed8;
        --text-dark: #0f172a;
        --text-gray: #64748b;
        --bg-light: #f1f5f9;

        /* Status Colors */
        --success-bg: #dcfce7;
        --success-text: #166534;
        --danger-bg: #fee2e2;
        --danger-text: #991b1b;
        --warning-bg: #fef3c7;
        --warning-text: #92400e;
    }

    body {
        background-color: #f8fafc;
        font-family: 'Inter', sans-serif;
        color: var(--text-dark);
    }

    /* --- Header Area --- */
    .page-header {
        margin-bottom: 25px;
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        gap: 16px;
        flex-wrap: wrap;
    }

    .page-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--text-dark);
        margin: 0;
        letter-spacing: -0.5px;
    }

    .page-subtitle {
        color: var(--text-gray);
        font-size: 0.9rem;
        margin-top: 4px;
    }

    /* --- Table Card --- */
    .table-card {
        background: white;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
        overflow: hidden;
    }

    .custom-table {
        width: 100%;
        border-collapse: collapse;
    }

    .custom-table thead th {
        background-color: #f1f5f9;
        color: #475569;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        padding: 16px 24px;
        border-bottom: 1px solid #e2e8f0;
        text-align: left;
    }

    .custom-table tbody tr {
        transition: background-color 0.2s;
        border-bottom: 1px solid #f1f5f9;
    }

    .custom-table tbody tr:hover {
        background-color: #eff6ff;
    }

    .custom-table td {
        padding: 20px 24px;
        vertical-align: middle;
        font-size: 0.95rem;
        color: var(--text-gray);
    }

    /* --- Typography & Elements --- */
    .data-title {
        font-weight: 600;
        color: var(--text-dark);
        display: block;
        margin-bottom: 4px;
        font-size: 1rem;
    }

    .data-sub {
        font-size: 0.85rem;
        color: var(--text-gray);
        display: flex;
        align-items: center;
        gap: 5px;
    }

    /* --- Custom Badges --- */
    .status-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .status-badge.active { background-color: var(--success-bg); color: var(--success-text); }
    .status-badge.rejected { background-color: var(--danger-bg); color: var(--danger-text); }
    .status-badge.pending { background-color: var(--warning-bg); color: var(--warning-text); }

    /* --- Action Buttons --- */
    .action-btn {
        width: 34px;
        height: 34px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        color: #94a3b8;
        transition: 0.2s;
        background: transparent;
        border: 1px solid transparent;
        cursor: pointer;
    }

    .action-btn.approve:hover { background: var(--success-bg); color: var(--success-text); }
    .action-btn.reject:hover { background: var(--danger-bg); color: var(--danger-text); }
    .action-btn.delete:hover { background: #fee2e2; color: #ef4444; }

    /* Alert */
    .alert-blue {
        background-color: #eff6ff;
        border: 1px solid #bfdbfe;
        color: #1e40af;
        border-radius: 8px;
        padding: 12px 20px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    /* Filter bar */
    .filter-card {
        background: #ffffff;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        padding: 14px 16px;
        margin-bottom: 18px;
    }
</style>
@endpush

@section('content')
<div class="container py-5">

    {{-- 1. HEADER HALAMAN --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Manajemen Akun</h1>
            <p class="page-subtitle">Daftar registrasi dan persetujuan akun pengguna.</p>
        </div>
    </div>

    {{-- 2. ALERT NOTIFIKASI --}}
    @if(session('swal'))
        <div class="alert-blue">
            <i class="bi bi-info-circle-fill"></i> {{ session('swal')['text'] ?? 'Berhasil update data' }}
        </div>
    @endif

    {{-- 3. FILTER & SEARCH --}}
    <div class="filter-card">
        <form method="GET" action="{{ route('admin.manajemen_akun.index') }}" class="row g-2 align-items-end">
            <div class="col-md-4">
                <label class="form-label mb-1 small text-muted">Cari</label>
                <input type="text"
                       name="search"
                       class="form-control form-control-sm"
                       placeholder="Cari nama / email / NIK..."
                       value="{{ request('search') }}">
            </div>

            <div class="col-md-3">
                <label class="form-label mb-1 small text-muted">Status Akun</label>
                <select name="status_akun" class="form-select form-select-sm">
                    <option value="">Semua Status</option>
                    <option value="pending"  {{ request('status_akun') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                    <option value="active"   {{ request('status_akun') == 'active' ? 'selected' : '' }}>Disetujui</option>
                    <option value="rejected" {{ request('status_akun') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label mb-1 small text-muted">Role</label>
                <select name="role" class="form-select form-select-sm">
                    <option value="">Semua Role</option>
                    @if(isset($roles) && $roles->count())
                        @foreach($roles as $r)
                            <option value="{{ $r }}" {{ request('role') == $r ? 'selected' : '' }}>
                                {{ ucfirst($r) }}
                            </option>
                        @endforeach
                    @endif
                </select>
            </div>

            <div class="col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-sm btn-primary w-100">
                    <i class="bi bi-search"></i> Filter
                </button>
                <a href="{{ route('admin.manajemen_akun.index') }}" class="btn btn-sm btn-outline-secondary">
                    <i class="bi bi-arrow-counterclockwise"></i>
                </a>
            </div>
        </form>
    </div>

    {{-- 4. KONTEN TABEL --}}
    <div class="table-card">
        <div class="table-responsive">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th width="5%">No</th>
                        <th width="25%">User Info</th>
                        <th width="20%">Role & NIK</th>
                        <th width="20%">Tanggal Daftar</th>
                        <th width="15%">Status</th>
                        <th width="15%" class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        {{-- Nomor mengikuti pagination --}}
                        <td>
                            {{ ($users->currentPage() - 1) * $users->perPage() + $loop->iteration }}
                        </td>

                        {{-- Kolom Nama & Email --}}
                        <td>
                            <span class="data-title">{{ $user->name }}</span>
                            <span class="data-sub">
                                <i class="bi bi-envelope"></i> {{ $user->email }}
                            </span>
                        </td>

                        {{-- Kolom Role & NIK --}}
                        <td>
                            <span class="d-block text-dark fw-medium mb-1">{{ ucfirst($user->role) }}</span>
                            @if($user->profile)
                                <span class="text-muted small">
                                    <i class="bi bi-person-vcard"></i> {{ $user->profile->nik ?? '-' }}
                                </span>
                            @else
                                <span class="text-muted small">-</span>
                            @endif
                        </td>

                        {{-- Kolom Tanggal --}}
                        <td>
                            <div class="text-muted small">
                                <i class="bi bi-calendar3 me-1"></i>
                                {{ $user->created_at->format('d M Y, H:i') }}
                            </div>
                        </td>

                        {{-- Kolom Status --}}
                        <td>
                            @if($user->status_akun == 'active')
                                <span class="status-badge active">
                                    <i class="bi bi-check-circle-fill"></i> Disetujui
                                </span>
                            @elseif($user->status_akun == 'rejected')
                                <span class="status-badge rejected">
                                    <i class="bi bi-x-circle-fill"></i> Ditolak
                                </span>
                            @else
                                <span class="status-badge pending">
                                    <i class="bi bi-clock-fill"></i> Menunggu
                                </span>
                            @endif
                        </td>

                        {{-- Kolom Aksi --}}
                        <td class="text-end">
                            <div class="d-flex gap-1 justify-content-end">

                                {{-- Tombol Approve --}}
                                @if($user->status_akun != 'active')
                                <form action="{{ route('admin.manajemen_akun.update', $user->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status_akun" value="active">
                                    <button type="submit" class="action-btn approve" title="Setujui (Approve)">
                                        <i class="bi bi-check-lg fs-5"></i>
                                    </button>
                                </form>
                                @endif

                                {{-- Tombol Reject --}}
                                @if($user->status_akun != 'rejected')
                                <form action="{{ route('admin.manajemen_akun.update', $user->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menolak akun ini?')">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status_akun" value="rejected">
                                    <button type="submit" class="action-btn reject" title="Tolak (Reject)">
                                        <i class="bi bi-x-lg fs-6"></i>
                                    </button>
                                </form>
                                @endif

                                {{-- Tombol Hapus --}}
                                <form action="{{ route('admin.manajemen_akun.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Hapus permanen data user ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="action-btn delete" title="Hapus Permanen">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <div class="text-muted" style="opacity: 0.6;">
                                <i class="bi bi-people fs-1 d-block mb-2"></i>
                                Belum ada data pendaftaran akun baru.
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- 5. PAGINATION --}}
        @if($users->hasPages())
            <div class="px-3 py-2">
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                    <div class="small text-muted">
                        Menampilkan
                        <strong>{{ $users->firstItem() }}</strong>
                        -
                        <strong>{{ $users->lastItem() }}</strong>
                        dari
                        <strong>{{ $users->total() }}</strong>
                        data
                    </div>
                    <div>
                        {{ $users->links('pagination::bootstrap-5') }}
                        {{-- kalau nggak pakai bootstrap, bisa pakai: {{ $users->links() }} --}}
                    </div>
                </div>
            </div>
        @endif
    </div>

</div>
@endsection
