<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        return Employee::with('qualification')->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'qualification_id' => 'required|exists:qualifications,id',
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'nullable|email|unique:employees,email',
            'phone' => 'nullable|string',
            'hire_date' => 'nullable|date',
            'status' => 'in:active,inactive',
        ]);

        return Employee::create($validated);
    }

    public function show($id)
    {
        return Employee::with('qualification')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);
        $employee->update($request->all());
        return $employee;
    }

    public function destroy($id)
    {
        Employee::findOrFail($id)->delete();
        return response()->noContent();
    }
}
