<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Payroll;
use App\Models\Presence;
use App\Models\Task;

class DashboardController extends Controller
{
     public function index()
     {
        $employee = Employee::count();
        $department = Department::count();
        $payroll = Employee::count();
        $presence = Presence::count();

        $tasks = Task::all();

        return view('dashboard.index', compact('employee', 'department', 'payroll', 'presence', 'tasks'));
     }

     public function presence() {
         $data = Presence::where('status', 'present')
                 ->selectRaw('MONTH(date) as month, YEAR(date) as year, COUNT(*) as total_present')
                 ->groupBy('year', 'month')
                 ->orderBy('month', 'asc') // Jan, Feb, Mer, ...
                 ->get();
         
         $temp = [];
         $i = 0;

         // Contoh yang digunakan : [5, 10, 15, 20, 25, 30]

         foreach ($data as $item) {
            $temp[$i] = $item->total_present;
            $i++;
         }

         return response()->json($temp);
     }
}
