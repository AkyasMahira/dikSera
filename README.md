# 🏥 DIKSERA
### Digitalisasi Kompetensi, Sertifikasi, dan Evaluasi Perawat  
**RSUD Simpang Lima Gumul – Kediri**

DIKSERA adalah platform internal rumah sakit untuk mengelola **kompetensi, sertifikasi, dan evaluasi perawat** dalam satu sistem terintegrasi.  
Dibangun untuk mendukung digitalisasi SDM kesehatan secara **efisien, terstruktur, dan real-time**.

---

## ✨ Fitur Utama
- 🔐 **Single Sign-On**
  - Admin
  - Perawat
  - Pewawancara / Penilai
- 📊 **Dashboard Monitoring**
  - Progres kompetensi
  - Status sertifikasi
  - Riwayat evaluasi
- 📝 **Evaluasi & Penilaian**
  - Form terstruktur
  - Skoring & catatan penilai
- 📂 **Manajemen Sertifikat**
  - Upload & verifikasi dokumen
- ⚙️ **Manajemen Akun**
  - Approve / reject / suspend
- 💬 **(Planned)** Chatbot internal (panduan & peraturan)

---

## 🧠 Tujuan Sistem
- Mengurangi proses manual & dokumen fisik  
- Menyediakan data kompetensi perawat yang **valid & terpusat**  
- Mendukung pengambilan keputusan manajemen berbasis data  

---

## 🛠️ Tech Stack
- **Backend** : Laravel
- **Frontend** : Blade + Bootstrap 5
- **Interaksi** : Livewire
- **Database** : MySQL / MariaDB
- **Auth** : Role-based Authentication
- **UI Style** : Glassmorphism, Maroon Theme

---

## 📸 Tampilan
- Login & Register Custom
- Dashboard role-based
- Form evaluasi interaktif
- Layout clean & modern (internal system friendly)

---

## 🚀 Instalasi Singkat
```bash
git clone https://github.com/username/diksera.git
cd diksera
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan storage:link
php artisan serve
