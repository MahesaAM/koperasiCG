<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AnggotaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $daftarAnggota = \App\Models\Anggota::latest()->paginate(10);
        return view('anggota.index', compact('daftarAnggota'));
    }

    public function createUser(Request $request, $id)
    {
        $anggota = \App\Models\Anggota::findOrFail($id);
        if ($anggota->user_id) {
            return back()->with('error', 'Anggota sudah memiliki akun pengguna.');
        }

        $user = \App\Models\User::create([
            'name' => $anggota->name,
            'email' => strtolower(str_replace(' ', '.', $anggota->name)) . '@example.com', // Simple generation
            'password' => bcrypt('password'), // Default password
            'role' => 'member',
        ]);

        $anggota->update(['user_id' => $user->id]);

        return back()->with('success', 'Akun pengguna berhasil dibuat. Email: ' . $user->email . ', Password: password');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('anggota.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nik' => 'required|unique:members',
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'join_date' => 'required|date',
            'status' => 'required|in:active,inactive',
        ]);

        \App\Models\Anggota::create($validated);

        return redirect()->route('anggota.index')->with('success', 'Anggota berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $anggota = \App\Models\Anggota::findOrFail($id);
        return view('anggota.show', compact('anggota'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $anggota = \App\Models\Anggota::findOrFail($id);
        return view('anggota.edit', compact('anggota'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $anggota = \App\Models\Anggota::findOrFail($id);
        
        $validated = $request->validate([
            'nik' => 'required|unique:members,nik,' . $anggota->id,
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'join_date' => 'required|date',
            'status' => 'required|in:active,inactive',
        ]);

        $anggota->update($validated);

        return redirect()->route('anggota.index')->with('success', 'Data anggota berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $anggota = \App\Models\Anggota::findOrFail($id);
        $anggota->delete();

        return redirect()->route('anggota.index')->with('success', 'Anggota berhasil dihapus.');
    }
}
