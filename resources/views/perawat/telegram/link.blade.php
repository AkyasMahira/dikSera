@extends('layouts.app')

@section('title', 'Link Telegram – DIKSERA')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">🔗 Hubungkan Telegram</h5>
                    </div>
                    <div class="card-body">
                        @if (auth()->user()->telegram_chat_id)
                            <div class="alert alert-success">
                                ✅ Akun Telegram sudah terhubung
                            </div>
                            <form action="{{ route('perawat.telegram.unlink') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger">Putuskan Koneksi</button>
                            </form>
                        @else
                            <p>Hubungkan akun Telegram untuk menerima notifikasi sertifikat yang akan kadaluarsa.</p>

                            <div id="step1">
                                <h6>Langkah 1: Generate Kode</h6>
                                <button type="button" class="btn btn-primary" id="generateBtn">Generate Kode</button>
                            </div>

                            <div id="step2" style="display: none;">
                                <h6>Langkah 2: Kirim Kode ke Bot</h6>
                                <div class="alert alert-info">
                                    <strong>Kode Verifikasi:</strong>
                                    <h3 id="codeDisplay" class="my-2"></h3>
                                    <small>Berlaku hingga: <span id="expiresAt"></span></small>
                                </div>
                                <p>Kirim kode di atas ke bot Telegram: <a
                                        href="https://t.me/{{ env('TELEGRAM_BOT_USERNAME') }}"
                                        target="_blank">@{{ env('TELEGRAM_BOT_USERNAME') }}</a></p>
                                <button type="button" class="btn btn-success" id="checkBtn">Cek Status</button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('generateBtn')?.addEventListener('click', async function() {
            const response = await fetch('{{ route('perawat.telegram.generate-code') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            });

            const data = await response.json();
            if (data.success) {
                document.getElementById('codeDisplay').textContent = data.code;
                document.getElementById('expiresAt').textContent = data.expires_at;
                document.getElementById('step1').style.display = 'none';
                document.getElementById('step2').style.display = 'block';
            }
        });

        document.getElementById('checkBtn')?.addEventListener('click', function() {
            location.reload();
        });
    </script>
@endsection
