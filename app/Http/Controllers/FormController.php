<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Str; // Import ini untuk buat Slug

class FormController extends Controller
{
    public function index()
    {
        $forms = Form::latest()->get();
        return view('admin.form.index', compact('forms'));
    }

    public function create()
    {
        return view('admin.form.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'waktu_mulai' => 'required|date',
            'waktu_selesai' => 'required|date|after:waktu_mulai',
            'target_peserta' => 'required',
        ]);

        Form::create([
            'judul' => $request->judul,
            'slug' => Str::slug($request->judul) . '-' . Str::random(5), // Slug unik
            'deskripsi' => $request->deskripsi,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'target_peserta' => $request->target_peserta,
            'status' => 'draft', // Default draft dulu
        ]);

        return redirect()->route('admin.form.index')->with('success', 'Form berhasil dibuat!');
    }
    
    // Nanti tambahkan edit, update, destroy di sini
}