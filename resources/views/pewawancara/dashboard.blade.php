@extends('layouts.app')

@section('title','Dashboard Pewawancara - DIK SERA')

@section('content')
<div class="card-glass p-4">
    <h5 class="mb-3">Dashboard Pewawancara</h5>
    <p class="text-muted mb-0">
        Halo, {{ auth()->user()->name }}.<br>
        Nanti di sini bisa diisi jadwal wawancara dan daftar perawat yang akan diwawancarai.
    </p>
</div>
@endsection
