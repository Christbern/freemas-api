<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {
        return Attendance::with(['employee', 'site'])->latest()->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'site_id' => 'required|exists:sites,id',
            'work_date' => 'required|date',
            'present' => 'boolean',
            'hours_worked' => 'numeric|min:0',
        ]);

        $attendance = Attendance::updateOrCreate(
            [
                'employee_id' => $validated['employee_id'],
                'site_id' => $validated['site_id'],
                'work_date' => $validated['work_date'],
            ],
            [
                'present' => $validated['present'] ?? true,
                'hours_worked' => $validated['hours_worked'] ?? 0,
            ]
        );

        return response()->json($attendance, 201);
    }

    public function show($id)
    {
        return Attendance::with(['employee', 'site'])->findOrFail($id);
    }

    public function destroy($id)
    {
        Attendance::findOrFail($id)->delete();
        return response()->noContent();
    }
}
