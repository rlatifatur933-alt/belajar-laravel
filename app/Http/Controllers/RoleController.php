<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;

class RoleController extends Controller
{
    public function index() {

        $roles = Role::all();

        return view('roles.index', compact('roles'));
    }

    public function create() {
        return view('roles.create');
    }

    public function store(Request $request) {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable'
        ]);

        role::create($request->all());

        return redirect()->route('roles.index')->with('success', 'Roles created succesfully');
    }

    public function edit(Role $role) {
        return view('roles.edit', compact('role'));
    }

    public function update(Request $request, Role $role) {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable'
        ]);

        $role->update($request->all());

        return redirect()->route('roles.index')->with('success', 'Roles updated succesfully');
    }

    public function destroy(Role $role) {
        $role->delete();

        return redirect()->route('roles.index')->with('success', 'Roles deleted succesfully');
    }
}
