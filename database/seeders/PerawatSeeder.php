<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\PerawatProfile;
use App\Models\FamilyMember;
use App\Models\Education;
use App\Models\JobHistory;
use App\Models\Certificate;

class PerawatSeeder extends Seeder
{
    public function run()
    {
        // ==================== PERAWAT 1 ====================
        $perawat1 = User::updateOrCreate(
            ['email' => 'perawat1@diksera.test'],
            [
                'name'     => 'Ns. Siti Aminah, S.Kep.',
                'password' => Hash::make('password123'),
                'role'     => 'perawat',
            ]
        );

        // PROFIL
        PerawatProfile::updateOrCreate(
            ['user_id' => $perawat1->id],
            [
                'gender'           => 'P',
                'birth_place'      => 'Kediri',
                'birth_date'       => '1995-03-20',
                'religion'         => 'Islam',
                'phone'            => '081234567890',
                'marital_status'   => 'Menikah',
                'nip'              => '987654321',
                'address'          => 'Jl. Anggrek No.10, Kediri',
                'office_address'   => 'RSUD Simpang Lima Gumul',
                'current_position' => 'Perawat Pelaksana',
                'work_unit'        => 'ICU',
                'profile_photo'    => null,
            ]
        );

        // KELUARGA
        FamilyMember::create([
            'user_id'      => $perawat1->id,
            'name'         => 'Budi Santoso',
            'relationship' => 'Suami',
            'age'          => '30',
            'education'    => 'S1 Teknik',
            'occupation'   => 'Pegawai Swasta',
        ]);

        // PENDIDIKAN (pakai format YYYY-MM-DD)
        Education::create([
            'user_id'     => $perawat1->id,
            'level'       => 'S1 Keperawatan',
            'institution' => 'Universitas Jember',
            'city'        => 'Jember',
            'year_start'  => '2013-01-01',
            'year_end'    => '2017-01-01',
        ]);

        // PEKERJAAN (pakai date juga)
        JobHistory::create([
            'user_id'     => $perawat1->id,
            'position'    => 'Perawat Pelaksana',
            'institution' => 'RSUD Simpang Lima Gumul',
            'year_start'  => '2018-01-01',
            'year_end'    => '2025-01-01', // anggap sampai 2025
            'description' => 'Perawat di ruang ICU',
        ]);

        // SERTIFIKAT WAJIB
        Certificate::create([
            'user_id'     => $perawat1->id,
            'type'        => 'wajib',
            'name'        => 'BTCLS',
            'description' => 'Basic Trauma & Cardiac Life Support',
            'date_start'  => '2024-01-01',
            'date_end'    => '2025-01-01',
            'file_path'   => null,
        ]);

        // SERTIFIKAT PENGEMBANGAN
        Certificate::create([
            'user_id'     => $perawat1->id,
            'type'        => 'pengembangan',
            'name'        => 'Pelatihan Manajemen ICU',
            'description' => 'Pelatihan pengembangan kompetensi ICU',
            'date_start'  => '2023-06-01',
            'date_end'    => null, // lifetime
            'file_path'   => null,
        ]);

        // ==================== PERAWAT 2 ====================
        $perawat2 = User::updateOrCreate(
            ['email' => 'perawat2@diksera.test'],
            [
                'name'     => 'Ns. Budi Santoso, S.Kep.',
                'password' => Hash::make('password123'),
                'role'     => 'perawat',
            ]
        );

        PerawatProfile::updateOrCreate(
            ['user_id' => $perawat2->id],
            [
                'gender'           => 'L',
                'birth_place'      => 'Malang',
                'birth_date'       => '1992-07-10',
                'religion'         => 'Islam',
                'phone'            => '081122334455',
                'marital_status'   => 'Belum Menikah',
                'nip'              => null,
                'address'          => 'Jl. Kenanga No.20, Malang',
                'office_address'   => 'RSUD Simpang Lima Gumul',
                'current_position' => 'Perawat Pelaksana',
                'work_unit'        => 'IGD',
                'profile_photo'    => null,
            ]
        );

        Education::create([
            'user_id'     => $perawat2->id,
            'level'       => 'D3 Keperawatan',
            'institution' => 'Poltekkes Malang',
            'city'        => 'Malang',
            'year_start'  => '2011-01-01',
            'year_end'    => '2014-01-01',
        ]);

        JobHistory::create([
            'user_id'     => $perawat2->id,
            'position'    => 'Perawat IGD',
            'institution' => 'RSUD Simpang Lima Gumul',
            'year_start'  => '2015-01-01',
            'year_end'    => '2025-01-01',
            'description' => 'Bertugas di bagian IGD',
        ]);

        Certificate::create([
            'user_id'     => $perawat2->id,
            'type'        => 'wajib',
            'name'        => 'STR',
            'description' => 'Surat Tanda Registrasi',
            'date_start'  => '2022-01-01',
            'date_end'    => '2027-01-01',
            'file_path'   => null,
        ]);

        Certificate::create([
            'user_id'     => $perawat2->id,
            'type'        => 'pengembangan',
            'name'        => 'Seminar PPNI',
            'description' => 'Workshop keperawatan nasional',
            'date_start'  => '2023-05-01',
            'date_end'    => null,
            'file_path'   => null,
        ]);

        echo "Seeder Perawat + DRH lengkap selesai\n";
    }
}
