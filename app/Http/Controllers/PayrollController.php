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
}
