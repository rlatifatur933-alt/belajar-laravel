<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Presence;
use App\Models\Employee;
use Carbon\Carbon;

class PresenceController extends Controller
{
    public function index() {

        if (session('role') == 'Belajar Laravel') {
            $presences = Presence::all();
        } else {
            $presences = Presence::where('employee_id', session('employee_id'))->get();
        }
        
        return view('presences.index', compact('presences'));
    }

    public function create() {
        $employees = Employee::all();

        return view('presences.create', compact('employees'));
    }

    public function store(Request $request) {

        if (session('role') == 'Belajar Laravel') {
            $request->validate([
            'employee_id' => 'required',
            'check_in' => 'required',
            'check_out' => 'required',
            'date' => 'required|date',
            'status' => 'required|string'
        ]);

        Presence::create($request->all()); 
        } else {
        Presence::create([
            'employee_id' => session('employee_id'),
            'check_in' => Carbon::now()->format('Y-m-d H:i:s'),
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'date' => Carbon::now()->format('Y-m-d'),
            'status' => 'present'
        ]);
    }

        return redirect()->route('presences.index')->with('success', 'Presence recorded succesfully');
    }

    public function edit(Presence $presence) {
        $employees = Employee::all();

        return view('presences.edit', compact('presence','employees'));
    }

    public function update(Request $request, Presence $presence) {
        $request->validate([
            'employee_id' => 'required',
            'check_in' => 'required',
            'check_out' => 'required',
            'date' => 'required|date',
            'status' => 'required|string'
        ]);

        $presence->update($request->all());

        return redirect()->route('presences.index')->with('success', 'Presence updated succesfully');

    }

    public function destroy(Presence $presence) {
        $presence->delete();
        return redirect()->route('presences.index')->with('success', 'Presence deleted succesfully');
    }
}
