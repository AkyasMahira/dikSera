<?php

namespace App\Http\Controllers\Admin;

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

class PerawatController extends Controller
{
    protected function ensureAdmin()
    {
        if (!Auth::check() || Auth::user()->role !== User::ROLE_ADMIN) {
            return redirect()->route('auth.login')->with('error', 'Akses hanya untuk admin.');
        }
        return null;
    }

    // Helper: convert "2013" -> "2013-01-01"
   protected function toDateOrNull(?string $value): ?string
{
    if ($value === null) return null;
    $value = trim($value);
    if ($value === '') return null;

    // Jika cuma tahun 4 digit -> jadikan YYYY-01-01
    if (preg_match('/^\d{4}$/', $value)) {
        return $value . '-01-01';
    }

    // Jika sudah format YYYY-MM-DD, pakai saja
    if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $value)) {
        return $value;
    }

    // Selain itu (1, 202, abc, dsb) dianggap null biar tidak error
    return null;
}


    public function index(Request $request)
    {
        if ($r = $this->ensureAdmin()) return $r;

        $q = trim($request->q ?? '');

        $perawats = User::where('role', User::ROLE_PERAWAT)
            ->when($q, function ($s) use ($q) {
                $s->where(function ($x) use ($q) {
                    $x->where('name', 'like', "%$q%")
                      ->orWhere('email', 'like', "%$q%");
                });
            })
            ->with(['perawatProfile', 'certificates'])
            ->orderBy('name')
            ->get();

        return view('admin.perawat.index', compact('perawats', 'q'));
    }

    public function create()
    {
        if ($r = $this->ensureAdmin()) return $r;

        return view('admin.perawat.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'name'                  => 'required|string|max:255',
        'email'                 => 'required|email|unique:users,email',
        'password'              => 'nullable|min:6',
        'gender'                => 'nullable|in:L,P',
        'birth_place'           => 'nullable|string|max:255',
        'birth_date'            => 'nullable|date',
        'religion'              => 'nullable|string|max:50',
        'phone'                 => 'nullable|string|max:50',
        'marital_status'        => 'nullable|string|max:50',
        'nip'                   => 'nullable|string|max:100',
        'address'               => 'nullable|string',
        'office_address'        => 'nullable|string',
        'current_position'      => 'nullable|string|max:100',
        'work_unit'             => 'nullable|string|max:100',
        'last_education'        => 'nullable|string|max:100',
        'education_institution' => 'nullable|string|max:150',
        'profile_photo'         => 'nullable|image|max:2048',
    ]);

    // 1. User
    $user = User::create([
        'name'     => $request->name,
        'email'    => $request->email,
        'password' => Hash::make($request->password ?: 'password123'),
        'role'     => 'perawat',
    ]);

    // 2. Profil
    $profileData = [
        'user_id'              => $user->id,
        'birth_place'          => $request->birth_place,
        'birth_date'           => $request->birth_date,
        'gender'               => $request->gender,
        'religion'             => $request->religion,
        'phone'                => $request->phone,
        'marital_status'       => $request->marital_status,
        'address'              => $request->address,
        'office_address'       => $request->office_address,
        'nip'                  => $request->nip,
        'current_position'     => $request->current_position,
        'work_unit'            => $request->work_unit,
        'last_education'       => $request->last_education,
        'education_institution'=> $request->education_institution,
    ];

    if ($request->hasFile('profile_photo')) {
        $path = $request->file('profile_photo')->store('perawat_photos', 'public');
        // PENTING: profile_photo
        $profileData['profile_photo'] = $path;
    }

    $profile = PerawatProfile::create($profileData);

    // 3. Keluarga
    $this->syncFamilies($request, $user->id);

    // 4. Pendidikan
    $this->syncEducations($request, $user->id);

    // 5. Pekerjaan
    $this->syncJobs($request, $user->id);

    // 6. Sertifikat
    $this->syncCertificates($request, $user->id);

    return redirect()->route('admin.perawat.index')->with('ok', 'Perawat berhasil ditambahkan.');
}


    public function show($id)
    {
        if ($r = $this->ensureAdmin()) return $r;

        $perawat = User::where('role', User::ROLE_PERAWAT)->findOrFail($id);

        $profile      = PerawatProfile::where('user_id', $perawat->id)->first();
        $educations   = Education::where('user_id', $perawat->id)->orderBy('year_start')->get();
        $jobs         = JobHistory::where('user_id', $perawat->id)->orderBy('year_start')->get();
        $families     = FamilyMember::where('user_id', $perawat->id)->get();
        $certificates = Certificate::where('user_id', $perawat->id)
            ->orderBy('date_start')
            ->get();

        $today = date('Y-m-d');

        return view('admin.perawat.show', compact(
            'perawat',
            'profile',
            'educations',
            'jobs',
            'families',
            'certificates',
            'today'
        ));
    }

    public function edit($id)
    {
        if ($r = $this->ensureAdmin()) return $r;

        $perawat = User::where('role', User::ROLE_PERAWAT)->findOrFail($id);

        $profile      = PerawatProfile::where('user_id', $perawat->id)->first();
        $families     = FamilyMember::where('user_id', $perawat->id)->get();
        $educations   = Education::where('user_id', $perawat->id)->orderBy('year_start')->get();
        $jobs         = JobHistory::where('user_id', $perawat->id)->orderBy('year_start')->get();
        $certificates = Certificate::where('user_id', $perawat->id)->orderBy('date_start')->get();

        return view('admin.perawat.edit', compact(
            'perawat',
            'profile',
            'families',
            'educations',
            'jobs',
            'certificates'
        ));
    }

public function update(Request $request, $id)
{
    $perawat = User::where('role', 'perawat')->findOrFail($id);

    $request->validate([
        'name'                  => 'required|string|max:255',
        'email'                 => 'required|email|unique:users,email,' . $perawat->id,
        'password'              => 'nullable|min:6',
        'gender'                => 'nullable|in:L,P',
        'birth_place'           => 'nullable|string|max:255',
        'birth_date'            => 'nullable|date',
        'religion'              => 'nullable|string|max:50',
        'phone'                 => 'nullable|string|max:50',
        'marital_status'        => 'nullable|string|max:50',
        'nip'                   => 'nullable|string|max:100',
        'address'               => 'nullable|string',
        'office_address'        => 'nullable|string',
        'current_position'      => 'nullable|string|max:100',
        'work_unit'             => 'nullable|string|max:100',
        'last_education'        => 'nullable|string|max:100',
        'education_institution' => 'nullable|string|max:150',
        'profile_photo'         => 'nullable|image|max:2048',
    ]);

    // 1. Update user
    $perawat->name  = $request->name;
    $perawat->email = $request->email;
    if ($request->filled('password')) {
        $perawat->password = Hash::make($request->password);
    }
    $perawat->save();

    // 2. Update profil
    $profileData = [
        'birth_place'          => $request->birth_place,
        'birth_date'           => $request->birth_date,
        'gender'               => $request->gender,
        'religion'             => $request->religion,
        'phone'                => $request->phone,
        'marital_status'       => $request->marital_status,
        'address'              => $request->address,
        'office_address'       => $request->office_address,
        'nip'                  => $request->nip,
        'current_position'     => $request->current_position,
        'work_unit'            => $request->work_unit,
        'last_education'       => $request->last_education,
        'education_institution'=> $request->education_institution,
    ];

    if ($request->hasFile('profile_photo')) {
        $path = $request->file('profile_photo')->store('perawat_photos', 'public');
        $profileData['profile_photo'] = $path;
    }

    PerawatProfile::updateOrCreate(
        ['user_id' => $perawat->id],
        $profileData
    );

    // 3. Sinkron keluarga, pendidikan, pekerjaan, sertifikat
    $this->syncFamilies($request, $perawat->id);
    $this->syncEducations($request, $perawat->id);
    $this->syncJobs($request, $perawat->id);
    $this->syncCertificates($request, $perawat->id);

    return redirect()->route('admin.perawat.index')->with('ok', 'Data perawat berhasil diperbarui.');
}


    public function destroy($id)
    {
        if ($r = $this->ensureAdmin()) return $r;

        $perawat = User::where('role', User::ROLE_PERAWAT)->findOrFail($id);
        $perawat->delete();

        return redirect()->route('admin.perawat.index')->with('ok', 'Perawat dihapus.');
    }
}
