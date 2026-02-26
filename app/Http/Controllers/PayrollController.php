<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payroll;
use App\Models\Employee;

class PayrollController extends Controller
{
    public function index() {

        $payrolls = Payroll::all();

        return view('payrolls.index', compact('payrolls'));
    }

    public function create() {
        $employees = Employee::all();

        return view('payrolls.create', compact('employees'));
    }

    public function store(Request $request) {

        $request->validate([
            'employee_id' => 'required',
            'salary' => 'required|numeric',
            'bonuses' => 'required|numeric',
            'deductions' => 'required|numeric',
            'pay_date' => 'required|date'
        ]);

        $netSalary = $request->input('salary') - $request->input('deductions') + $request->input('bonuses');

        $request->merge(['net_salary' => $netSalary]);

        Payroll::create($request->all());

        return redirect()->route('payrolls.index')->with('success', 'Payroll created succesfully');
    }
}
