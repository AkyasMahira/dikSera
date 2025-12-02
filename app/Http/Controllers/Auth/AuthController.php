<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PerawatProfile;
use App\Models\FamilyMember;
use App\Models\Education;
use App\Models\JobHistory;
use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    // FORM LOGIN
    public function loginForm()
    {
        return view('auth.login');
    }

    // PROSES LOGIN
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            if ($user->role === User::ROLE_ADMIN) {
                return redirect()->route('admin.perawat.index');
            }

            if ($user->role === User::ROLE_PERAWAT) {
                return redirect()->route('perawat.dashboard');
            }

            if ($user->role === User::ROLE_PEWAWANCARA) {
                return redirect()->route('pewawancara.dashboard');
            }

            Auth::logout();
            return redirect()->route('auth.login')->with('error', 'Role tidak dikenali.');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput();
    }

    // FORM REGISTER PERAWAT
    public function registerPerawatForm()
    {
        return view('auth.register-perawat');
    }

    // PROSES REGISTER PERAWAT + DRH
    public function registerPerawat(Request $request)
    {
        // validasi dasar untuk akun
        $dataUser = $request->validate([
            'name'                  => 'required|string|max:255',
            'email'                 => 'required|email|unique:users,email',
            'password'              => 'required|min:6|confirmed',
            'profile_photo'         => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // buat user
        $user = User::create([
            'name'     => $dataUser['name'],
            'email'    => $dataUser['email'],
            'password' => Hash::make($dataUser['password']),
            'role'     => User::ROLE_PERAWAT,
        ]);

        // simpan foto 3x4 jika ada
        $photoPath = null;
        if ($request->hasFile('profile_photo')) {
            $photoPath = $request->file('profile_photo')->store('perawat_photos', 'public');
        }

        // simpan profil perawat
        PerawatProfile::create([
            'user_id'               => $user->id,
            'birth_place'           => $request->birth_place,
            'birth_date'            => $request->birth_date,
            'gender'                => $request->gender,
            'religion'              => $request->religion,
            'phone'                 => $request->phone,
            'marital_status'        => $request->marital_status,
            'address'               => $request->address,
            'office_address'        => $request->office_address,
            'nip'                   => $request->nip,
            'current_position'      => $request->current_position,
            'work_unit'             => $request->work_unit,
            'last_education'        => $request->last_education,
            'education_institution' => $request->education_institution,
            'profile_photo'    => $photoPath,
        ]);

        // lingkungan keluarga (loop array)
        $familyNames = $request->family_name ?? [];
        if (is_array($familyNames)) {
            foreach ($familyNames as $idx => $fname) {
                if (!trim($fname)) continue;
                FamilyMember::create([
                    'user_id'     => $user->id,
                    'name'        => $fname,
                    'relationship'=> $request->family_relationship[$idx] ?? null,
                    'age'         => $request->family_age[$idx] ?? null,
                    'education'   => $request->family_education[$idx] ?? null,
                    'occupation'  => $request->family_occupation[$idx] ?? null,
                ]);
            }
        }

        // riwayat pendidikan
        $eduLevels = $request->edu_level ?? [];
        if (is_array($eduLevels)) {
            foreach ($eduLevels as $idx => $lvl) {
                if (!trim($lvl)) continue;
                Education::create([
                    'user_id'     => $user->id,
                    'level'       => $lvl,
                    'institution' => $request->edu_institution[$idx] ?? null,
                    'city'        => $request->edu_city[$idx] ?? null,
                    'year_start'  => $request->edu_year_start[$idx] ?? null,
                    'year_end'    => $request->edu_year_end[$idx] ?? null,
                ]);
            }
        }

        // riwayat pekerjaan
        $jobPositions = $request->job_position ?? [];
        if (is_array($jobPositions)) {
            foreach ($jobPositions as $idx => $pos) {
                if (!trim($pos)) continue;
                JobHistory::create([
                    'user_id'     => $user->id,
                    'position'    => $pos,
                    'institution' => $request->job_institution[$idx] ?? null,
                    'year_start'  => $request->job_year_start[$idx] ?? null,
                    'year_end'    => $request->job_year_end[$idx] ?? null,
                    'description' => $request->job_description[$idx] ?? null,
                ]);
            }
        }

        // sertifikat WAJIB
        $certWajibNames = $request->cert_wajib_name ?? [];
        if (is_array($certWajibNames)) {
            foreach ($certWajibNames as $idx => $cname) {
                if (!trim($cname)) continue;

                $filePath = null;
                if ($request->hasFile('cert_wajib_file.' . $idx)) {
                    $filePath = $request->file('cert_wajib_file.' . $idx)->store('certificates', 'public');
                }

                Certificate::create([
                    'user_id'     => $user->id,
                    'type'        => 'wajib',
                    'name'        => $cname,
                    'description' => $request->cert_wajib_desc[$idx] ?? null,
                    'date_start'  => $request->cert_wajib_start[$idx] ?? null,
                    'date_end'    => $request->cert_wajib_end[$idx] ?? null,
                    'file_path'   => $filePath,
                ]);
            }
        }

        // sertifikat PENGEMBANGAN
        $certDevNames = $request->cert_dev_name ?? [];
        if (is_array($certDevNames)) {
            foreach ($certDevNames as $idx => $cname) {
                if (!trim($cname)) continue;

                $filePath = null;
                if ($request->hasFile('cert_dev_file.' . $idx)) {
                    $filePath = $request->file('cert_dev_file.' . $idx)->store('certificates', 'public');
                }

                Certificate::create([
                    'user_id'     => $user->id,
                    'type'        => 'pengembangan',
                    'name'        => $cname,
                    'description' => $request->cert_dev_desc[$idx] ?? null,
                    'date_start'  => $request->cert_dev_start[$idx] ?? null,
                    'date_end'    => $request->cert_dev_end[$idx] ?? null,
                    'file_path'   => $filePath,
                ]);
            }
        }

        Auth::login($user);

        return redirect()->route('perawat.dashboard')->with('ok', 'Akun perawat & DRH berhasil dibuat.');
    }

    // LOGOUT
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('auth.login')->with('ok','Logout berhasil.');
    }
}
