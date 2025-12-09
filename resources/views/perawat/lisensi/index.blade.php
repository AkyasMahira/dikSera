@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-md-6">
            <h3>Dokumen Lisensi (STR, SIP, Sertifikat)</h3>
            <p class="text-muted">Kelola masa berlaku dokumen legal keperawatan Anda.</p>
        </div>
        <div class="col-md-6 text-end">
            <a href="{{ route('perawat.lisensi.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Dokumen
            </a>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Jenis Dokumen</th>
                            <th>Nomor Dokumen</th>
                            <th>Tgl Terbit</th>
                            <th>Tgl Expired</th>
                            <th>Status</th>
                            <th>File</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lisensi as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->jenis }}</td>
                            <td>{{ $item->nomor }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tgl_terbit)->format('d M Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tgl_expired)->format('d M Y') }}</td>
                            <td>
                                @if($item->status == 'aktif')
                                    <span class="badge bg-success">Aktif</span>
                                @elseif($item->status == 'hampir_expired')
                                    <span class="badge bg-warning text-dark">Hampir Expired</span>
                                @else
                                    <span class="badge bg-danger">Expired</span>
                                @endif
                            </td>
                            <td>
                                @if($item->file_path)
                                    <a href="{{ asset('storage/'.$item->file_path) }}" target="_blank" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i> Lihat
                                    </a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('perawat.lisensi.edit', $item->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('perawat.lisensi.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus dokumen ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">Belum ada dokumen lisensi.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
