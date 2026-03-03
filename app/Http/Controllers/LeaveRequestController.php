<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LeaveRequest;
use App\Models\Employee;

class LeaveRequestController extends Controller
{
    public function index() {
        $leaveRequests = LeaveRequest::all();

        return view('leave-requests.index', compact('leaveRequests'));
    }

    public function create() {
        $employees = Employee::all();

        return view ('leave-requests.create',  compact('employees'));
    }

    public function store(Request $request) {
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
