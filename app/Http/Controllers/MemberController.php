<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $members = \App\Models\Member::latest()->paginate(10);
        return view('members.index', compact('members'));
    }

    public function createUser(Request $request, $id)
    {
        $member = \App\Models\Member::findOrFail($id);
        if ($member->user_id) {
            return back()->with('error', 'Member already has a user account.');
        }

        $user = \App\Models\User::create([
            'name' => $member->name,
            'email' => strtolower(str_replace(' ', '.', $member->name)) . '@example.com', // Simple generation
            'password' => bcrypt('password'), // Default password
            'role' => 'member',
        ]);

        $member->update(['user_id' => $user->id]);

        return back()->with('success', 'User account created for member. Email: ' . $user->email . ', Password: password');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('members.create');
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

        \App\Models\Member::create($validated);

        return redirect()->route('members.index')->with('success', 'Member created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $member = \App\Models\Member::findOrFail($id);
        return view('members.show', compact('member'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $member = \App\Models\Member::findOrFail($id);
        return view('members.edit', compact('member'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $member = \App\Models\Member::findOrFail($id);
        
        $validated = $request->validate([
            'nik' => 'required|unique:members,nik,' . $member->id,
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'join_date' => 'required|date',
            'status' => 'required|in:active,inactive',
        ]);

        $member->update($validated);

        return redirect()->route('members.index')->with('success', 'Member updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $member = \App\Models\Member::findOrFail($id);
        $member->delete();

        return redirect()->route('members.index')->with('success', 'Member deleted successfully.');
    }
}
