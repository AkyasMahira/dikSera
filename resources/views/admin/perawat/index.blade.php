@extends('layouts.app')

@section('title','Data Perawat - DIK SERA')

@section('sidebar')
    <div class="sidebar-title">Admin</div>
    <div class="sidebar-menu">
        <a href="{{ route('admin.perawat.index') }}" class="active">
            <i class="bi bi-people"></i><span>Data Perawat</span>
        </a>
    </div>
@endsection

@section('content')
<div class="card-glass mb-3">
    <div class="card-glass-inner">
        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
            <div class="section-title mb-0">Data Perawat</div>
            <a href="{{ route('admin.perawat.create') }}" class="btn btn-sm btn-success">
                <i class="bi bi-person-plus me-1"></i> Tambah Perawat
            </a>
        </div>

        <form method="get" action="{{ route('admin.perawat.index') }}" class="row g-2 mb-3">
            <div class="col-md-4 col-8">
                <input type="text" name="q" value="{{ $q ?? '' }}" class="form-control form-control-sm"
                       placeholder="Cari nama / email perawat">
            </div>
            <div class="col-md-2 col-4">
                <button class="btn btn-sm btn-outline-primary w-100">
                    <i class="bi bi-search"></i> Cari
                </button>
            </div>
        </form>

        @if($perawats->isEmpty())
            <p class="text-muted mb-0">Belum ada perawat terdaftar.</p>
        @else
            <div class="table-responsive">
                <table class="table table-sm align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Perawat</th>
                            <th>Email</th>
                            <th>Info Sertifikat</th>
                            <th>Tgl Daftar</th>
                            <th style="width:190px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $today = date('Y-m-d'); @endphp
                        @foreach($perawats as $p)
                            @php
                                // ambil sertifikat dengan date_end terdekat
                                $certs = $p->certificates ?? collect();
                                $nearest = $certs
                                    ->filter(function($c){ return !is_null($c->date_end); })
                                    ->sortBy('date_end')
                                    ->first();
                                $infoText = 'Belum ada info kedaluwarsa sertifikat.';
                                if ($nearest) {
                                    $endStr = $nearest->date_end ? $nearest->date_end->format('d-m-Y') : '-';
                                    $endRaw = $nearest->date_end ? $nearest->date_end->toDateString() : null;
                                    if ($endRaw && $endRaw < $today) {
                                        $infoText = "Sertifikat {$nearest->name} sudah kadaluarsa {$endStr}.";
                                    } elseif ($endRaw) {
                                        $infoText = "Sertifikat {$nearest->name} akan habis {$endStr}.";
                                    }
                                }
                            @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <strong>{{ $p->name }}</strong>
                                </td>
                                <td>{{ $p->email }}</td>
                                <td>
                                    <small class="text-muted">{{ $infoText }}</small>
                                </td>
                                <td>{{ $p->created_at ? $p->created_at->format('d-m-Y H:i') : '-' }}</td>
                                <td>
                                    <a href="{{ route('admin.perawat.show',$p->id) }}"
                                       class="btn btn-sm btn-outline-info">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.perawat.edit',$p->id) }}"
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.perawat.destroy',$p->id) }}"
                                          method="post" class="d-inline form-delete">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const forms = document.querySelectorAll('.form-delete');
    forms.forEach(function (f) {
        f.addEventListener('submit', function (e) {
            e.preventDefault();
            Swal.fire({
                title: 'Hapus perawat ini?',
                text: 'Data akun akan dihapus.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    f.submit();
                }
            });
        });
    });
});
</script>
@endpush
