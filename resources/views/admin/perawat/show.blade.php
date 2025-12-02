@extends('layouts.app')

@section('title','Detail Perawat - Admin DIK SERA')

@section('sidebar')
    <div class="sidebar-title">Admin</div>
    <div class="sidebar-menu">
        <a href="{{ route('admin.perawat.index') }}" class="active">
            <i class="bi bi-people"></i><span>Data Perawat</span>
        </a>
    </div>
@endsection

@section('content')
{{-- Profil singkat --}}
<div class="card-glass mb-3">
    <div class="card-glass-inner">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <div class="section-title mb-0">Profil Perawat</div>
            <a href="{{ route('admin.perawat.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="row g-3">
            <div class="col-md-6">
                <table class="table table-sm mb-0">
                    <tr><th style="width:130px;">Nama</th><td>{{ $perawat->name }}</td></tr>
                    <tr><th>Email</th><td>{{ $perawat->email }}</td></tr>
                    <tr><th>Role</th><td>{{ $perawat->role }}</td></tr>
                    <tr><th>Tgl Daftar</th><td>{{ $perawat->created_at ? $perawat->created_at->format('d-m-Y H:i') : '-' }}</td></tr>
                </table>
            </div>
            <div class="col-md-6">
                @if($profile && $profile->profile_photo)
                    <div class="d-flex align-items-center gap-3">
                        <img src="{{ Storage::url($profile->profile_photo) }}"
                             alt="Foto 3x4" class="rounded" style="width:90px;height:120px;object-fit:cover;">
                        <div class="text-muted small">
                            Foto 3x4 yang diunggah perawat.<br>
                            <span class="text-success"><i class="bi bi-check-circle"></i> Tersedia</span>
                        </div>
                    </div>
                @else
                    <p class="text-muted small mb-0">
                        <i class="bi bi-image"></i> Foto 3x4 belum diunggah.
                    </p>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Data DRH PerawatProfile (auto loop semua field) --}}
<div class="card-glass mb-3">
    <div class="card-glass-inner">
        <div class="section-title">Data Riwayat Hidup (DRH)</div>
        @if(!$profile)
            <p class="text-muted mb-0">Perawat ini belum mengisi DRH.</p>
        @else
            @php
                $attrs = $profile->toArray();
                unset($attrs['id'], $attrs['user_id'], $attrs['profile_photo'], $attrs['created_at'], $attrs['updated_at']);
            @endphp
            <div class="table-responsive">
                <table class="table table-sm mb-0">
                    <tbody>
                    @foreach($attrs as $key => $val)
                        <tr>
                            <th style="width:220px;">
                                {{ ucwords(str_replace('_',' ', $key)) }}
                            </th>
                            <td>{{ $val }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

{{-- Lingkungan keluarga --}}
<div class="card-glass mb-3">
    <div class="card-glass-inner">
        <div class="section-title">Lingkungan Keluarga</div>
        @if($families->isEmpty())
            <p class="text-muted mb-0">Belum ada data keluarga.</p>
        @else
            <div class="table-responsive">
                <table class="table table-sm align-middle">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Hubungan</th>
                        <th>Usia</th>
                        <th>Pendidikan</th>
                        <th>Pekerjaan</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($families as $f)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $f->name }}</td>
                            <td>{{ $f->relationship }}</td>
                            <td>{{ $f->age }}</td>
                            <td>{{ $f->education }}</td>
                            <td>{{ $f->occupation }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

{{-- Riwayat pendidikan --}}
<div class="card-glass mb-3">
    <div class="card-glass-inner">
        <div class="section-title">Riwayat Pendidikan</div>
        @if($educations->isEmpty())
            <p class="text-muted mb-0">Belum ada riwayat pendidikan.</p>
        @else
            <div class="table-responsive">
                <table class="table table-sm align-middle">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Jenjang</th>
                        <th>Institusi</th>
                        <th>Kota</th>
                        <th>Tahun</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($educations as $e)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $e->level }}</td>
                            <td>{{ $e->institution }}</td>
                            <td>{{ $e->city }}</td>
                            <td>{{ $e->year_start }} - {{ $e->year_end }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

{{-- Riwayat pekerjaan --}}
<div class="card-glass mb-3">
    <div class="card-glass-inner">
        <div class="section-title">Riwayat Pekerjaan</div>
        @if($jobs->isEmpty())
            <p class="text-muted mb-0">Belum ada riwayat pekerjaan.</p>
        @else
            <div class="table-responsive">
                <table class="table table-sm align-middle">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Jabatan</th>
                        <th>Institusi</th>
                        <th>Tahun</th>
                        <th>Keterangan</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($jobs as $j)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $j->position }}</td>
                            <td>{{ $j->institution }}</td>
                            <td>{{ $j->year_start }} - {{ $j->year_end }}</td>
                            <td>{{ $j->description }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

{{-- Sertifikat --}}
{{-- Sertifikat --}}
<div class="card-glass mb-3">
    <div class="card-glass-inner">
        <div class="section-title">Sertifikat</div>
        @if($certificates->isEmpty())
            <p class="text-muted mb-0">Belum ada sertifikat terdata.</p>
        @else
            <div class="table-responsive">
                <table class="table table-sm align-middle">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Jenis</th>
                        <th>Nama Sertifikat</th>
                        <th>Keterangan</th>
                        <th>Diinput</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($certificates as $c)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ ucfirst($c->type) }}</td>
                            <td>{{ $c->name }}</td>
                            <td>{{ $c->description }}</td>
                            <td>{{ $c->created_at ? $c->created_at->format('d/m/Y H:i') : '-' }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

@endsection
