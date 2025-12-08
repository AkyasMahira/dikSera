@extends('layouts.app')

@section('title','Edit Identitas – DIKSERA')

@section('content')
<div class="container py-3">
    <div class="dash-card p-3">
        <div class="d-flex justify-content-between align-items-center mb-2">
            <h6 class="mb-0">Edit Identitas & DRH Perorangan</h6>
            <a href="{{ route('perawat.drh') }}" class="btn btn-sm btn-outline-secondary">
                Kembali ke DRH
            </a>
        </div>

        @if($errors->any())
            <div class="alert alert-danger py-2 px-3 small">
                <strong>Terjadi kesalahan:</strong>
                <ul class="mb-0 mt-1">
                    @foreach($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form menggunakan method POST (sesuai route Anda) --}}
        <form action="{{ route('perawat.identitas.update') }}" method="POST" enctype="multipart/form-data" class="small">
            @csrf

            <div class="row g-3">
                {{-- KOLOM KIRI: Identitas Pribadi & Kontak --}}
                <div class="col-md-6">
                    <h6 class="text-primary border-bottom pb-1 mb-2">A. Data Pribadi</h6>

                    {{-- Nama, NIK --}}
                    <div class="mb-2">
                        <label class="form-label">Nama Lengkap (Gelar) *</label>
                        <input type="text" name="nama_lengkap"
                               value="{{ old('nama_lengkap', $profile->nama_lengkap ?? $user->name) }}"
                               class="form-control form-control-sm">
                    </div>
                    <div class="mb-2">
                        <label class="form-label">NIK (KTP)</label>
                        <input type="text" name="nik"
                               value="{{ old('nik', $profile->nik ?? '') }}"
                               class="form-control form-control-sm">
                    </div>

                    <div class="row g-2 mb-2">
                        <div class="col-6">
                            <label class="form-label">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir"
                                   value="{{ old('tempat_lahir', $profile->tempat_lahir ?? '') }}"
                                   class="form-control form-control-sm">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir"
                                   value="{{ old('tanggal_lahir', $profile->tanggal_lahir ?? '') }}"
                                   class="form-control form-control-sm">
                        </div>
                    </div>

                    <div class="row g-2 mb-2">
                        <div class="col-6">
                            <label class="form-label">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-select form-select-sm">
                                <option value="">-- Pilih --</option>
                                <option value="L" {{ old('jenis_kelamin',$profile->jenis_kelamin ?? '')=='L'?'selected':'' }}>Laki-laki</option>
                                <option value="P" {{ old('jenis_kelamin',$profile->jenis_kelamin ?? '')=='P'?'selected':'' }}>Perempuan</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Agama</label>
                            <select name="agama" class="form-select form-select-sm">
                                <option value="">-- Pilih --</option>
                                @foreach(['Islam','Kristen','Katolik','Hindu','Buddha','Khonghucu'] as $agm)
                                    <option value="{{ $agm }}" {{ old('agama', $profile->agama ?? '') == $agm ? 'selected' : '' }}>{{ $agm }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Aliran Kepercayaan (Opsional)</label>
                        <input type="text" name="aliran_kepercayaan"
                               value="{{ old('aliran_kepercayaan', $profile->aliran_kepercayaan ?? '') }}"
                               class="form-control form-control-sm">
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Status Perkawinan</label>
                        <select name="status_perkawinan" class="form-select form-select-sm">
                            <option value="">-- Pilih --</option>
                            @foreach(['Belum Kawin','Kawin','Cerai Hidup','Cerai Mati'] as $sts)
                                <option value="{{ $sts }}" {{ old('status_perkawinan', $profile->status_perkawinan ?? '') == $sts ? 'selected' : '' }}>{{ $sts }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-2">
                        <label class="form-label">Hobi / Kegemaran</label>
                        <input type="text" name="hobby"
                               value="{{ old('hobby', $profile->hobby ?? '') }}"
                               class="form-control form-control-sm"
                               placeholder="Contoh: Membaca, Olahraga">
                    </div>

                    <h6 class="text-primary border-bottom pb-1 mb-2 mt-3">B. Kontak Domisili</h6>
                    <div class="mb-2">
                        <label class="form-label">No HP (WA)</label>
                        <input type="text" name="no_hp"
                               value="{{ old('no_hp', $profile->no_hp ?? '') }}"
                               class="form-control form-control-sm">
                    </div>
                     <div class="mb-2">
                        <label class="form-label">Kota</label>
                        <input type="text" name="kota"
                               value="{{ old('kota', $profile->kota ?? '') }}"
                               class="form-control form-control-sm">
                    </div>
                    <div class="mb-2">
                        <label class="form-label">Alamat Lengkap</label>
                        <textarea name="alamat" rows="2" class="form-control form-control-sm">{{ old('alamat', $profile->alamat ?? '') }}</textarea>
                    </div>
                </div>

                {{-- KOLOM KANAN: Fisik, Kepegawaian, Foto --}}
                <div class="col-md-6">
                    <h6 class="text-primary border-bottom pb-1 mb-2">C. Keterangan Badan & Fisik</h6>

                    {{-- Baris 1: TB, BB, Goldar --}}
                    <div class="row g-2 mb-2">
                        <div class="col-4">
                            <label class="form-label">Tinggi (cm)</label>
                            <input type="number" name="tinggi_badan"
                                   value="{{ old('tinggi_badan', $profile->tinggi_badan ?? '') }}"
                                   class="form-control form-control-sm">
                        </div>
                        <div class="col-4">
                            <label class="form-label">Berat (kg)</label>
                            <input type="number" name="berat_badan"
                                   value="{{ old('berat_badan', $profile->berat_badan ?? '') }}"
                                   class="form-control form-control-sm">
                        </div>
                        <div class="col-4">
                            <label class="form-label">Gol. Darah</label>
                            <select name="golongan_darah" class="form-select form-select-sm">
                                <option value="">-</option>
                                @foreach(['A','B','AB','O'] as $gd)
                                    <option value="{{ $gd }}" {{ old('golongan_darah', $profile->golongan_darah ?? '') == $gd ? 'selected' : '' }}>{{ $gd }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Baris 2: Rambut, Bentuk Muka, Warna Kulit --}}
                    <div class="row g-2 mb-2">
                        <div class="col-4">
                            <label class="form-label">Rambut</label>
                            <input type="text" name="rambut"
                                   value="{{ old('rambut', $profile->rambut ?? '') }}"
                                   class="form-control form-control-sm" placeholder="Ikal/Lurus">
                        </div>
                        <div class="col-4">
                            <label class="form-label">Bentuk Muka</label>
                            <input type="text" name="bentuk_muka"
                                   value="{{ old('bentuk_muka', $profile->bentuk_muka ?? '') }}"
                                   class="form-control form-control-sm" placeholder="Oval/Bulat">
                        </div>
                        <div class="col-4">
                            <label class="form-label">Warna Kulit</label>
                            <input type="text" name="warna_kulit"
                                   value="{{ old('warna_kulit', $profile->warna_kulit ?? '') }}"
                                   class="form-control form-control-sm" placeholder="Sawo Matang">
                        </div>
                    </div>

                    {{-- Baris 3: Ciri Khas & Cacat --}}
                    <div class="row g-2 mb-2">
                        <div class="col-6">
                            <label class="form-label">Ciri Khas</label>
                            <input type="text" name="ciri_khas"
                                   value="{{ old('ciri_khas', $profile->ciri_khas ?? '') }}"
                                   class="form-control form-control-sm" placeholder="Tahi lalat...">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Cacat Tubuh</label>
                            <input type="text" name="cacat_tubuh"
                                   value="{{ old('cacat_tubuh', $profile->cacat_tubuh ?? '') }}"
                                   class="form-control form-control-sm" placeholder="-">
                        </div>
                    </div>

                    <h6 class="text-primary border-bottom pb-1 mb-2 mt-3">D. Data Kepegawaian</h6>
                    <div class="row g-2 mb-2">
                        <div class="col-6">
                            <label class="form-label">Jabatan</label>
                            <input type="text" name="jabatan"
                                   value="{{ old('jabatan', $profile->jabatan ?? '') }}"
                                   class="form-control form-control-sm" placeholder="Perawat Ahli Muda">
                        </div>
                        <div class="col-3">
                            <label class="form-label">Pangkat</label>
                            <input type="text" name="pangkat"
                                   value="{{ old('pangkat', $profile->pangkat ?? '') }}"
                                   class="form-control form-control-sm" placeholder="Penata">
                        </div>
                        <div class="col-3">
                            <label class="form-label">Golongan</label>
                            <input type="text" name="golongan"
                                   value="{{ old('golongan', $profile->golongan ?? '') }}"
                                   class="form-control form-control-sm" placeholder="III/c">
                        </div>
                    </div>

                    <div class="row g-2 mb-2">
                        <div class="col-6">
                            <label class="form-label">NIP</label>
                            <input type="text" name="nip"
                                   value="{{ old('nip', $profile->nip ?? '') }}"
                                   class="form-control form-control-sm">
                        </div>
                        <div class="col-6">
                            <label class="form-label">NIRP</label>
                            <input type="text" name="nirp"
                                   value="{{ old('nirp', $profile->nirp ?? '') }}"
                                   class="form-control form-control-sm">
                        </div>
                    </div>

                    <div class="mb-2 mt-3">
                        <label class="form-label">Upload Foto 3x4 (JPG/PNG, Max 2MB)</label>
                        <input type="file" name="foto_3x4" class="form-control form-control-sm">
                        @if($profile && $profile->foto_3x4)
                            <div class="mt-2 p-2 border rounded bg-light d-inline-block">
                                <img src="{{ asset('storage/'.$profile->foto_3x4) }}"
                                     style="height:100px; object-fit:cover; border-radius:4px;">
                                <div class="small text-muted mt-1 text-center">Foto Terkini</div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="mt-4 pt-3 border-top d-flex justify-content-end">
                <a href="{{ route('perawat.drh') }}" class="btn btn-sm btn-light border me-2">Batal</a>
                <button type="submit" class="btn btn-primary btn-sm px-4">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
