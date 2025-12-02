<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Daftar Perawat - DIK SERA</title>
    <link rel="icon" href="{{ asset('icon.png') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap 5 --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    {{-- Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root{
            --primary: #14b8a6;
            --secondary: #6366f1;
            --bg-base: #eef2ff;
            --glass: rgba(255,255,255,.96);
            --text-main: #0f172a;
            --text-muted: #6b7280;
            --radius: 18px;
            --shadow: 0 18px 45px rgba(15,23,42,.12);
        }

        *{ box-sizing:border-box; }

        body{
            margin:0;
            min-height:100vh;
            font-family: system-ui,-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif;
            color:var(--text-main);
            background:
              radial-gradient(circle at 0% 0%, rgba(20,184,166,.25), transparent 55%),
              radial-gradient(circle at 100% 0%, rgba(99,102,241,.25), transparent 55%),
              var(--bg-base);
            background-size: 140% 140%;
            animation: bgFloat 18s ease-in-out infinite;
        }

        @keyframes bgFloat{
            0%{ background-position: 0% 0%, 100% 0%, 50% 50%; }
            50%{ background-position: 20% 10%, 80% 5%, 50% 50%; }
            100%{ background-position: 0% 0%, 100% 0%, 50% 50%; }
        }

        .page-shell{
            max-width:1100px;
            margin:2rem auto;
            padding:0 1rem;
        }

        .card-auth{
            background:var(--glass);
            border-radius:var(--radius);
            box-shadow:var(--shadow);
            border:1px solid rgba(209,213,219,.9);
            padding:2.2rem 2rem;
            position:relative;
            overflow:hidden;
            animation: fadeZoomIn .5s ease-out;
        }

        .card-auth::before{
            content:"";
            position:absolute;
            inset:-40%;
            background: radial-gradient(circle at 0% 0%, rgba(20,184,166,.14), transparent 55%);
            opacity:0;
            transform:translate3d(-10px,-10px,0);
            transition:opacity .5s ease, transform .5s ease;
            pointer-events:none;
        }

        .card-auth:hover::before{
            opacity:1;
            transform:translate3d(0,0,0);
        }

        @keyframes fadeZoomIn{
            from{ opacity:0; transform:translate3d(0,10px,0) scale(.97); }
            to{ opacity:1; transform:translate3d(0,0,0) scale(1); }
        }

        .section-label{
            font-size:.75rem;
            letter-spacing:.18em;
            text-transform:uppercase;
            color:var(--text-muted);
        }

        .section-title{
            font-size:1.05rem;
            font-weight:600;
            display:flex;
            align-items:center;
            gap:.5rem;
            margin-bottom:.9rem;
        }
        .section-title::before{
            content:"";
            display:inline-block;
            width:16px;
            height:16px;
            border-radius:999px;
            background: conic-gradient(from 180deg, #22c1c3, #6366f1, #22c1c3);
        }

        .chip-role{
            padding:3px 9px;
            border-radius:999px;
            font-size:.75rem;
            text-transform:uppercase;
            letter-spacing:.07em;
            border:1px solid rgba(148,163,184,.8);
            color:var(--text-muted);
            background:#f9fafb;
        }

        .form-label{
            font-size:.8rem;
            color:#4b5563;
        }

        .form-control, .form-select{
            border-radius:12px;
            border:1px solid #e5e7eb;
            font-size:.9rem;
        }
        .form-control:focus, .form-select:focus{
            border-color:#14b8a6;
            box-shadow:0 0 0 1px rgba(20,184,166,.35);
        }
        .form-control::placeholder{
            color:#9ca3af;
        }

        .btn-primary-soft{
            background: linear-gradient(135deg, #22c1c3, #14b8a6);
            border:none;
            color:#ffffff;
            font-weight:600;
            box-shadow:0 10px 30px rgba(34,193,195,.25);
        }
        .btn-primary-soft:hover{
            filter:brightness(1.03);
            box-shadow:0 14px 38px rgba(34,193,195,.35);
        }

        .logo-box{
            height:60px;
            width:60px;
            border-radius:14px;
            overflow:hidden;
            display:flex;
            align-items:center;
            justify-content:center;
            box-shadow:0 0 0 3px rgba(148,163,184,.4);
        }
        .logo-box img{
            max-width:100%;
            max-height:100%;
            object-fit:cover;
        }

        .dynamic-table th, .dynamic-table td{
            font-size:.8rem;
            vertical-align:middle;
        }

        .btn-icon{
            width:32px;
            height:32px;
            border-radius:999px;
            display:inline-flex;
            align-items:center;
            justify-content:center;
            padding:0;
        }

        .photo-box{
            width:120px;
            height:160px;
            border-radius:12px;
            border:1px dashed #d1d5db;
            overflow:hidden;
            background:#f9fafb;
            display:flex;
            align-items:center;
            justify-content:center;
        }

        .alert{
            font-size:.8rem;
        }

        .input-group-text{
            background:#f9fafb;
            border-radius:12px;
            border:1px solid #e5e7eb;
        }

        .btn-eye{
            border-radius:0 12px 12px 0;
        }

        @media (max-width:768px){
            .card-auth{
                padding:1.6rem 1.3rem;
            }
        }
    </style>
</head>
<body>

<div class="page-shell">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="d-flex align-items-center gap-2">
            <div class="logo-box">
                <img src="{{ asset('icon.png') }}" alt="icon">
            </div>
            <div>
                <div class="fw-semibold" style="font-size:.9rem;letter-spacing:.05em;">DIK SERA</div>
                <div class="text-muted small">Digitalisasi Kompetensi, Sertifikasi & Evaluasi Perawat</div>
            </div>
        </div>
        <div class="d-none d-md-block">
            <a href="{{ route('auth.login') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-box-arrow-in-left me-1"></i> Kembali ke Login
            </a>
        </div>
    </div>

    <div class="card-auth">
        @if(session('ok'))
            <div class="alert alert-success py-2">{{ session('ok') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger py-2">{{ session('error') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger py-2">
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="d-flex flex-column flex-md-row justify-content-between gap-3 mb-4">
            <div>
                <div class="section-label">Formulir Daftar Perawat</div>
                <h4 class="mb-1">Daftar Akun & Daftar Riwayat Hidup Perawat</h4>
                <p class="text-muted small mb-0">
                    Data ini digunakan untuk proses <strong>kompetensi, sertifikasi & evaluasi perawat</strong>.
                </p>
            </div>
            <div class="text-md-end text-start">
                <span class="chip-role">Perawat</span>
                <div class="text-muted small mt-2">
                    Isi dengan data yang benar & dapat dipertanggungjawabkan.
                </div>
            </div>
        </div>

        <form action="{{ route('auth.register.perawat.process') }}" method="post" enctype="multipart/form-data">
            @csrf

            {{-- I. Identitas & Akun + Foto --}}
            <div class="mb-4">
                <div class="section-title">I. Identitas Diri & Akun</div>
                <div class="row g-3">
                    <div class="col-md-8">
                        <div class="row g-3">
                            <div class="col-md-8">
                                <label class="form-label">Nama Lengkap (dengan gelar)</label>
                                <input type="text" name="name" value="{{ old('name') }}"
                                       class="form-control" required placeholder="Ns. Siti Aminah, S.Kep.">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Jenis Kelamin</label>
                                <select name="gender" class="form-select">
                                    <option value="">Pilih</option>
                                    <option value="L" {{ old('gender')=='L'?'selected':'' }}>Laki-laki</option>
                                    <option value="P" {{ old('gender')=='P'?'selected':'' }}>Perempuan</option>
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Tempat Lahir</label>
                                <input type="text" name="birth_place" value="{{ old('birth_place') }}"
                                       class="form-control" placeholder="Kediri">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Tanggal Lahir</label>
                                <input type="date" name="birth_date" value="{{ old('birth_date') }}" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Agama</label>
                                <select name="religion" class="form-select">
                                    <option value="">Pilih</option>
                                    @foreach(['Islam','Kristen','Katholik','Hindu','Budha','Konghucu','Lainnya'] as $rel)
                                        <option {{ old('religion')==$rel?'selected':'' }}>{{ $rel }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Telepon / HP</label>
                                <input type="text" name="phone" value="{{ old('phone') }}"
                                       class="form-control" placeholder="08xxxxxxxxxx">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Status Pernikahan</label>
                                <select name="marital_status" class="form-select">
                                    <option value="">Pilih</option>
                                    <option {{ old('marital_status')=='Belum Menikah'?'selected':'' }}>Belum Menikah</option>
                                    <option {{ old('marital_status')=='Menikah'?'selected':'' }}>Menikah</option>
                                    <option {{ old('marital_status')=='Janda/Duda'?'selected':'' }}>Janda/Duda</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">NIP / NIRA (jika ada)</label>
                                <input type="text" name="nip" value="{{ old('nip') }}" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Alamat Rumah</label>
                                <textarea name="address" rows="2" class="form-control"
                                          placeholder="Alamat tempat tinggal">{{ old('address') }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Alamat Kantor / Unit Kerja</label>
                                <textarea name="office_address" rows="2" class="form-control"
                                          placeholder="RS / Unit / Ruangan">{{ old('office_address') }}</textarea>
                            </div>

                            <div class="col-md-4">
                                <label class="form-label">Jabatan Saat Ini</label>
                                <input type="text" name="current_position" value="{{ old('current_position') }}"
                                       class="form-control" placeholder="Perawat Pelaksana">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Unit Kerja / Ruangan</label>
                                <input type="text" name="work_unit" value="{{ old('work_unit') }}"
                                       class="form-control" placeholder="ICU, IGD, Ruang ...">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Email Aktif (Login)</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-envelope"></i>
                                    </span>
                                    <input type="email" name="email" value="{{ old('email') }}"
                                           class="form-control" required placeholder="perawat@rsudslg.go.id">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Password</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-lock"></i>
                                    </span>
                                    <input type="password" name="password" id="regPassword"
                                           class="form-control" required placeholder="Minimal 6 karakter">
                                    <button type="button" class="btn btn-outline-secondary btn-eye"
                                            onclick="togglePassword('regPassword','regPasswordIcon')">
                                        <i class="bi bi-eye" id="regPasswordIcon"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Konfirmasi Password</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="bi bi-lock-fill"></i>
                                    </span>
                                    <input type="password" name="password_confirmation" id="regPasswordConfirm"
                                           class="form-control" required placeholder="Ulangi password">
                                    <button type="button" class="btn btn-outline-secondary btn-eye"
                                            onclick="togglePassword('regPasswordConfirm','regPasswordConfirmIcon')">
                                        <i class="bi bi-eye" id="regPasswordConfirmIcon"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Foto 3x4 --}}
                    <div class="col-md-4 mt-3 mt-md-0">
                        <label class="form-label d-flex justify-content-between align-items-center">
                            Foto 3x4
                            <span class="text-muted small">jpg / png · maks 2MB</span>
                        </label>
                        <div class="d-flex flex-column align-items-center gap-2">
                            <div class="photo-box">
                                <img id="photoPreview" src="" alt="Preview Foto"
                                     style="max-width:100%;max-height:100%;display:none;object-fit:cover;">
                                <span id="photoPlaceholder" class="text-muted small">
                                    3x4
                                </span>
                            </div>
                            <input type="file" name="profile_photo" class="form-control form-control-sm"
                                   accept="image/*" onchange="previewPhoto(event)">
                        </div>
                    </div>
                </div>
            </div>

            {{-- II. Lingkungan Keluarga --}}
            <div class="mb-4">
                <div class="section-title">II. Lingkungan Keluarga</div>
                <p class="text-muted small mb-2">
                    Tambahkan anggota keluarga yang tinggal serumah / relevan.
                </p>
                <div class="table-responsive">
                    <table class="table table-sm dynamic-table align-middle" id="familyTable">
                        <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Hubungan</th>
                            <th>Usia</th>
                            <th>Pendidikan</th>
                            <th>Pekerjaan</th>
                            <th style="width:40px;"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><input type="text" name="family_name[]" class="form-control form-control-sm"></td>
                            <td><input type="text" name="family_relationship[]" class="form-control form-control-sm" placeholder="Suami/Istri/Anak"></td>
                            <td><input type="number" name="family_age[]" class="form-control form-control-sm" min="0"></td>
                            <td><input type="text" name="family_education[]" class="form-control form-control-sm"></td>
                            <td><input type="text" name="family_occupation[]" class="form-control form-control-sm"></td>
                            <td class="text-center">
                                <button type="button" class="btn btn-outline-danger btn-icon btn-sm" onclick="removeRow(this)">
                                    &times;
                                </button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <button type="button" class="btn btn-outline-secondary btn-sm mt-2" onclick="addFamilyRow()">
                    + Tambah Anggota Keluarga
                </button>
            </div>

            {{-- III. Riwayat Pendidikan --}}
            <div class="mb-4">
                <div class="section-title">III. Riwayat Pendidikan</div>
                <div class="table-responsive">
                    <table class="table table-sm dynamic-table align-middle" id="eduTable">
                        <thead>
                        <tr>
                            <th>Jenjang</th>
                            <th>Institusi</th>
                            <th>Kota</th>
                            <th>Tahun Mulai</th>
                            <th>Tahun Selesai</th>
                            <th style="width:40px;"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><input type="text" name="edu_level[]" class="form-control form-control-sm" placeholder="D3/S1/Profesi"></td>
                            <td><input type="text" name="edu_institution[]" class="form-control form-control-sm"></td>
                            <td><input type="text" name="edu_city[]" class="form-control form-control-sm"></td>
                            <td><input type="text" name="edu_year_start[]" class="form-control form-control-sm" placeholder="2020"></td>
                            <td><input type="text" name="edu_year_end[]" class="form-control form-control-sm" placeholder="2024"></td>
                            <td class="text-center">
                                <button type="button" class="btn btn-outline-danger btn-icon btn-sm" onclick="removeRow(this)">
                                    &times;
                                </button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <button type="button" class="btn btn-outline-secondary btn-sm mt-2" onclick="addEduRow()">
                    + Tambah Riwayat Pendidikan
                </button>
            </div>

            {{-- IV. Riwayat Pekerjaan --}}
            <div class="mb-4">
                <div class="section-title">IV. Riwayat Pekerjaan</div>
                <div class="table-responsive">
                    <table class="table table-sm dynamic-table align-middle" id="jobTable">
                        <thead>
                        <tr>
                            <th>Jabatan</th>
                            <th>Institusi</th>
                            <th>Tahun Mulai</th>
                            <th>Tahun Selesai</th>
                            <th>Keterangan Singkat</th>
                            <th style="width:40px;"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><input type="text" name="job_position[]" class="form-control form-control-sm" placeholder="Perawat Pelaksana"></td>
                            <td><input type="text" name="job_institution[]" class="form-control form-control-sm"></td>
                            <td><input type="text" name="job_year_start[]" class="form-control form-control-sm" placeholder="2020"></td>
                            <td><input type="text" name="job_year_end[]" class="form-control form-control-sm" placeholder="2024 / Sekarang"></td>
                            <td><input type="text" name="job_description[]" class="form-control form-control-sm"></td>
                            <td class="text-center">
                                <button type="button" class="btn btn-outline-danger btn-icon btn-sm" onclick="removeRow(this)">
                                    &times;
                                </button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <button type="button" class="btn btn-outline-secondary btn-sm mt-2" onclick="addJobRow()">
                    + Tambah Riwayat Pekerjaan
                </button>
            </div>

            {{-- V. Sertifikat Wajib --}}
            <div class="mb-4">
                <div class="section-title">V. Sertifikat Wajib</div>
                <p class="text-muted small mb-2">
                    Sertifikat yang diwajibkan rumah sakit (STR, BTCLS, PPGD, dll).  
                    Jika <strong>Tanggal Habis</strong> kosong → dianggap <strong>lifetime</strong>.
                </p>
                <div class="table-responsive">
                    <table class="table table-sm dynamic-table align-middle" id="certWajibTable">
                        <thead>
                        <tr>
                            <th>Nama Sertifikat</th>
                            <th>Keterangan</th>
                            <th>Tanggal Aktif</th>
                            <th>Tanggal Habis</th>
                            <th>Upload Dokumen</th>
                            <th style="width:40px;"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><input type="text" name="cert_wajib_name[]" class="form-control form-control-sm"></td>
                            <td><input type="text" name="cert_wajib_desc[]" class="form-control form-control-sm"></td>
                            <td><input type="date" name="cert_wajib_start[]" class="form-control form-control-sm"></td>
                            <td><input type="date" name="cert_wajib_end[]" class="form-control form-control-sm"></td>
                            <td><input type="file" name="cert_wajib_file[]" class="form-control form-control-sm" accept=".pdf,image/*"></td>
                            <td class="text-center">
                                <button type="button" class="btn btn-outline-danger btn-icon btn-sm" onclick="removeRow(this)">
                                    &times;
                                </button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <button type="button" class="btn btn-outline-secondary btn-sm mt-2" onclick="addCertWajibRow()">
                    + Tambah Sertifikat Wajib
                </button>
            </div>

            {{-- VI. Sertifikat Pengembangan --}}
            <div class="mb-4">
                <div class="section-title">VI. Sertifikat Pengembangan</div>
                <p class="text-muted small mb-2">
                    Sertifikat pelatihan / workshop / seminar untuk pengembangan kompetensi.
                </p>
                <div class="table-responsive">
                    <table class="table table-sm dynamic-table align-middle" id="certDevTable">
                        <thead>
                        <tr>
                            <th>Nama Sertifikat</th>
                            <th>Keterangan</th>
                            <th>Tanggal Aktif</th>
                            <th>Tanggal Habis</th>
                            <th>Upload Dokumen</th>
                            <th style="width:40px;"></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><input type="text" name="cert_dev_name[]" class="form-control form-control-sm"></td>
                            <td><input type="text" name="cert_dev_desc[]" class="form-control form-control-sm"></td>
                            <td><input type="date" name="cert_dev_start[]" class="form-control form-control-sm"></td>
                            <td><input type="date" name="cert_dev_end[]" class="form-control form-control-sm"></td>
                            <td><input type="file" name="cert_dev_file[]" class="form-control form-control-sm" accept=".pdf,image/*"></td>
                            <td class="text-center">
                                <button type="button" class="btn btn-outline-danger btn-icon btn-sm" onclick="removeRow(this)">
                                    &times;
                                </button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <button type="button" class="btn btn-outline-secondary btn-sm mt-2" onclick="addCertDevRow()">
                    + Tambah Sertifikat Pengembangan
                </button>
            </div>

            {{-- Submit --}}
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-3 mt-4">
                <p class="text-muted small mb-0">
                    Dengan menekan tombol <strong>Daftar & Simpan DRH</strong>, Anda menyatakan bahwa data yang diisi adalah benar.
                </p>
                <button class="btn btn-primary-soft px-4">
                    <i class="bi bi-person-check me-1"></i> Daftar & Simpan DRH
                </button>
            </div>
        </form>

        <div class="text-center mt-3 d-md-none">
            <small class="text-muted">
                Sudah punya akun? <a href="{{ route('auth.login') }}">Kembali ke Login</a>
            </small>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
function previewPhoto(e){
    const file = e.target.files[0];
    const preview = document.getElementById('photoPreview');
    const placeholder = document.getElementById('photoPlaceholder');
    if(file){
        const reader = new FileReader();
        reader.onload = function(ev){
            preview.src = ev.target.result;
            preview.style.display = 'block';
            placeholder.style.display = 'none';
        };
        reader.readAsDataURL(file);
    }else{
        preview.src = '';
        preview.style.display = 'none';
        placeholder.style.display = 'block';
    }
}

function togglePassword(inputId, iconId){
    const input = document.getElementById(inputId);
    const icon  = document.getElementById(iconId);
    if(!input) return;
    if(input.type === 'password'){
        input.type = 'text';
        if(icon) icon.classList.replace('bi-eye','bi-eye-slash');
    }else{
        input.type = 'password';
        if(icon) icon.classList.replace('bi-eye-slash','bi-eye');
    }
}

function addRow(tableId, rowHtml){
    const tbody = document.getElementById(tableId).querySelector('tbody');
    const tr = document.createElement('tr');
    tr.innerHTML = rowHtml;
    tbody.appendChild(tr);
}
function removeRow(btn){
    const tr = btn.closest('tr');
    const tbody = tr.parentElement;
    if(tbody.children.length > 1){
        tr.remove();
    }else{
        tr.querySelectorAll('input, textarea').forEach(el => el.value = '');
    }
}

// Family
function addFamilyRow(){
    addRow('familyTable', `
        <td><input type="text" name="family_name[]" class="form-control form-control-sm"></td>
        <td><input type="text" name="family_relationship[]" class="form-control form-control-sm" placeholder="Suami/Istri/Anak"></td>
        <td><input type="number" name="family_age[]" class="form-control form-control-sm" min="0"></td>
        <td><input type="text" name="family_education[]" class="form-control form-control-sm"></td>
        <td><input type="text" name="family_occupation[]" class="form-control form-control-sm"></td>
        <td class="text-center">
            <button type="button" class="btn btn-outline-danger btn-icon btn-sm" onclick="removeRow(this)">&times;</button>
        </td>
    `);
}

// Educations
function addEduRow(){
    addRow('eduTable', `
        <td><input type="text" name="edu_level[]" class="form-control form-control-sm" placeholder="D3/S1/Profesi"></td>
        <td><input type="text" name="edu_institution[]" class="form-control form-control-sm"></td>
        <td><input type="text" name="edu_city[]" class="form-control form-control-sm"></td>
        <td><input type="text" name="edu_year_start[]" class="form-control form-control-sm" placeholder="2020"></td>
        <td><input type="text" name="edu_year_end[]" class="form-control form-control-sm" placeholder="2024"></td>
        <td class="text-center">
            <button type="button" class="btn btn-outline-danger btn-icon btn-sm" onclick="removeRow(this)">&times;</button>
        </td>
    `);
}

// Jobs
function addJobRow(){
    addRow('jobTable', `
        <td><input type="text" name="job_position[]" class="form-control form-control-sm" placeholder="Perawat Pelaksana"></td>
        <td><input type="text" name="job_institution[]" class="form-control form-control-sm"></td>
        <td><input type="text" name="job_year_start[]" class="form-control form-control-sm" placeholder="2020"></td>
        <td><input type="text" name="job_year_end[]" class="form-control form-control-sm" placeholder="2024 / Sekarang"></td>
        <td><input type="text" name="job_description[]" class="form-control form-control-sm"></td>
        <td class="text-center">
            <button type="button" class="btn btn-outline-danger btn-icon btn-sm" onclick="removeRow(this)">&times;</button>
        </td>
    `);
}

// Sertifikat wajib
function addCertWajibRow(){
    addRow('certWajibTable', `
        <td><input type="text" name="cert_wajib_name[]" class="form-control form-control-sm"></td>
        <td><input type="text" name="cert_wajib_desc[]" class="form-control form-control-sm"></td>
        <td><input type="date" name="cert_wajib_start[]" class="form-control form-control-sm"></td>
        <td><input type="date" name="cert_wajib_end[]" class="form-control form-control-sm"></td>
        <td><input type="file" name="cert_wajib_file[]" class="form-control form-control-sm" accept=".pdf,image/*"></td>
        <td class="text-center">
            <button type="button" class="btn btn-outline-danger btn-icon btn-sm" onclick="removeRow(this)">&times;</button>
        </td>
    `);
}

// Sertifikat pengembangan
function addCertDevRow(){
    addRow('certDevTable', `
        <td><input type="text" name="cert_dev_name[]" class="form-control form-control-sm"></td>
        <td><input type="text" name="cert_dev_desc[]" class="form-control form-control-sm"></td>
        <td><input type="date" name="cert_dev_start[]" class="form-control form-control-sm"></td>
        <td><input type="date" name="cert_dev_end[]" class="form-control form-control-sm"></td>
        <td><input type="file" name="cert_dev_file[]" class="form-control form-control-sm" accept=".pdf,image/*"></td>
        <td class="text-center">
            <button type="button" class="btn btn-outline-danger btn-icon btn-sm" onclick="removeRow(this)">&times;</button>
        </td>
    `);
}
</script>
</body>
</html>
