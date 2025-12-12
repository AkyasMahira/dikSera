@php
    $now = \Carbon\Carbon::now();
    $expired = \Carbon\Carbon::parse($item->tgl_expired);
    $daysLeft = $now->diffInDays($expired, false);

    if ($daysLeft < 0) {
        $badgeClass = 'badge-soft-danger';
        $icon = 'bi-x-circle';
        $text = 'Expired (' . abs($daysLeft) . ' hari)';
    } elseif ($daysLeft <= 90) {
        // Warning 3 bulan sebelum
        $badgeClass = 'badge-soft-warning';
        $icon = 'bi-exclamation-circle';
        $text = 'Exp: ' . $daysLeft . ' hari lagi';
    } else {
        $badgeClass = 'badge-soft-success';
        $icon = 'bi-check-circle';
        $text = 'Aktif';
    }
@endphp

<tr>
    <td class="font-monospace text-dark">{{ $item->nomor }}</td>
    <td class="fw-bold text-dark">{{ $item->nama }}</td>
    <td class="text-muted">{{ $item->lembaga }}</td>
    <td>
        <div class="d-flex flex-column" style="font-size: 11px;">
            <span class="text-muted">Mulai: {{ \Carbon\Carbon::parse($item->tgl_terbit)->format('d M Y') }}</span>
            <span class="{{ $daysLeft < 0 ? 'text-danger fw-bold' : 'text-dark' }}">
                Akhir: {{ $expired->format('d M Y') }}
            </span>
        </div>
    </td>
    <td>
        {{-- Status Masa Berlaku --}}
        <span class="badge-soft {{ $badgeClass }} mb-2 d-inline-flex">
            <i class="bi {{ $icon }}"></i> {{ $text }}
        </span>

        <div class="border-top border-light pt-2 mt-1">
            {{-- Label Status --}}
            <div class="d-flex align-items-center gap-2 mb-2">
                <span class="text-muted" style="font-size: 10px;">Verifikasi:</span>
                <span class="badge-soft badge-soft-secondary status-kelayakan-{{ $item->id }}">
                    <span class="fw-bold text-uppercase kelayakan-label">{{ $item->kelayakan ?? 'pending' }}</span>
                </span>
            </div>

            {{-- Tombol Aksi UI Baru --}}
            <div class="verify-actions">
                <button type="button" class="btn-verify btn-verify-success btn-kelayakan"
                    data-id="{{ $item->id }}"
                    data-tipe="{{ isset($item->jenis) ? 'tambahan' : (isset($item->nomor) && isset($item->lembaga) ? (str_contains(strtolower($item->nama), 'str') ? 'str' : (str_contains(strtolower($item->nama), 'sip') ? 'sip' : 'lisensi')) : 'lisensi') }}"
                    data-status="layak" title="Layak">
                    <i class="bi bi-check-lg"></i>
                </button>

                <button type="button" class="btn-verify btn-verify-danger btn-kelayakan" data-id="{{ $item->id }}"
                    data-tipe="{{ isset($item->jenis) ? 'tambahan' : (isset($item->nomor) && isset($item->lembaga) ? (str_contains(strtolower($item->nama), 'str') ? 'str' : (str_contains(strtolower($item->nama), 'sip') ? 'sip' : 'lisensi')) : 'lisensi') }}"
                    data-status="tidak_layak" title="Tidak Layak">
                    <i class="bi bi-x-lg"></i>
                </button>

                <button type="button" class="btn-verify btn-verify-secondary btn-kelayakan"
                    data-id="{{ $item->id }}"
                    data-tipe="{{ isset($item->jenis) ? 'tambahan' : (isset($item->nomor) && isset($item->lembaga) ? (str_contains(strtolower($item->nama), 'str') ? 'str' : (str_contains(strtolower($item->nama), 'sip') ? 'sip' : 'lisensi')) : 'lisensi') }}"
                    data-status="pending" title="Reset">
                    <i class="bi bi-arrow-counterclockwise"></i>
                </button>
            </div>
        </div>
    </td>
    <td class="text-end">
        @if ($item->file_path)
            <a href="{{ Storage::url($item->file_path) }}" target="_blank" class="btn-file">
                <i class="bi bi-file-earmark-pdf text-danger"></i> Lihat
            </a>
        @else
            <span class="text-muted small opacity-50">Kosong</span>
        @endif
    </td>
</tr>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.btn-kelayakan').forEach(function(btn) {
                btn.addEventListener('click', function() {
                    var id = this.getAttribute('data-id');
                    var tipe = this.getAttribute('data-tipe');
                    var kelayakan = this.getAttribute('data-status');
                    var row = this.closest('tr');
                    fetch("{{ route('admin.perawat.verifikasi.kelayakan') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]')
                                    .getAttribute('content')
                            },
                            body: JSON.stringify({
                                id: id,
                                tipe: tipe,
                                kelayakan: kelayakan
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                row.querySelector('.kelayakan-label').textContent = kelayakan;
                            }
                        });
                });
            });
        });
    </script>
@endpush
