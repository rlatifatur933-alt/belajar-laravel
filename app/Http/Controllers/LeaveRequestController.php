<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LeaveRequest;
use App\Models\Employee;

class LeaveRequestController extends Controller
{
    public function index() {

        if (session('role') == 'Belajar Laravel') {
            $leaveRequests = LeaveRequest::all();
        } else {
            $leaveRequests = LeaveRequest::where('employee_id', session('employee_id'))->get();
        }

        return view('leave-requests.index', compact('leaveRequests'));
    }

    public function create() {
        $employees = Employee::all();

        return view ('leave-requests.create',  compact('employees'));
    }

    public function store(Request $request) {

        if (session('role') == 'Belajar Laravel') {
            $request->validate ([
                 'employee_id' => 'Required',
                 'leave_type' => 'Required|string',
                 'start_date' => 'Required|date',
                 'end_date' => 'Required|date'
            ]);

            $request->merge([
                'status' => 'pending'
            ]);
    
            LeaveRequest::create($request->all());
    
        } else {
            LeaveRequest::create([
                'employee_id' => session('employee_id'),
                'leave_type' => $request->leave_type,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'status' => 'pending'
            ]);
        }
        
        return redirect()->route('leave-requests.index')->with('success', 'leave request created succesfully');
    }

    public function edit(LeaveRequest $leaveRequest) {
        $employees = Employee::all();

        return view ('leave-requests.edit',  compact('leaveRequest', 'employees'));
    }

    public function update(Request $request, LeaveRequest $leaveRequest) {
        $request->validate ([
            'employee_id' => 'Required',
            'leave_type' => 'Required|string',
            'start_date' => 'Required|date',
            'end_date' => 'Required|date'
         ]);

         $leaveRequest->update($request->all());

         return redirect()->route('leave-requests.index')->with('success', 'leave request updated succesfully');
    }

    public function confirm(int $id) {
        $leaveRequest = LeaveRequest::findOrFail($id);
        $leaveRequest->update([
            'status' => 'confirm'
        ]);

        return redirect()->route('leave-requests.index')->with('success', 'leave request confirmed succesfully');
    }

    public function reject(int $id) {
        $leaveRequest = LeaveRequest::findOrFail($id);
        $leaveRequest->update([
            'status' => 'reject'
        ]);

        return redirect()->route('leave-requests.index')->with('success', 'leave request rejected succesfully');
    }

    public function destroy(LeaveRequest $leaveRequest) {
        $leaveRequest->delete();

        return redirect()->route('leave-requests.index')->with('success', 'leave request deleted succesfully');
    }
}
