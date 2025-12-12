@extends('layouts.app') {{-- Sesuaikan dengan layout utamamu --}}

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="text-dark">Manajemen Google Form</h3>
        <a href="{{ route('admin.form.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Buat Form Baru
        </a>
    </div>

    <div class="card shadow border-0">
        <div class="card-body">
            <table class="table table-hover">
                <thead class="bg-light">
                    <tr>
                        <th>Judul Form</th>
                        <th>Jadwal</th>
                        <th>Target</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($forms as $form)
                    <tr>
                        <td>
                            <strong>{{ $form->judul }}</strong>
                            <br>
                            <small class="text-muted">{{ Str::limit($form->deskripsi, 50) }}</small>
                        </td>
                        <td>
                            <small>Mulai: {{ $form->waktu_mulai->format('d M Y, H:i') }}</small><br>
                            <small>Selesai: {{ $form->waktu_selesai->format('d M Y, H:i') }}</small>
                        </td>
                        <td>
                            <span class="badge bg-info text-dark">{{ ucfirst($form->target_peserta) }}</span>
                        </td>
                        <td>
                            <span class="badge {{ $form->status == 'publish' ? 'bg-success' : 'bg-secondary' }}">
                                {{ ucfirst($form->status) }}
                            </span>
                        </td>
                        <td>
                            <a href="#" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                            {{-- Tombol hapus nanti --}}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection