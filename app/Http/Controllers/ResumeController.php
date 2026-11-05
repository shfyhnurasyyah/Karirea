<?php

namespace App\Http\Controllers;

use App\Models\Resume;
use Illuminate\Http\Request;

class ResumeController extends Controller
{
    public function create()
    {
        return view('resume.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'posisi'        => 'nullable|string|max:255',
            'nama_depan'    => 'required|string|max:255',
            'nama_belakang' => 'required|string|max:255',
            'email'         => 'required|email|max:255',
            'foto'          => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('foto', 'public');
        }

        Resume::create($data);

        return redirect()
            ->route('resume.create')
            ->with('sukses', 'Data pribadi berhasil disimpan.');
    }
}