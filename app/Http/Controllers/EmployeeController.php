<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Repositories\EmployeeRepository;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{

    protected EmployeeRepository $employeeRepository;

    public function __construct(EmployeeRepository $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }

    public function index()
    {
        $employees = $this->employeeRepository->getAll();
        return response()->json(['success' => true, 'employees' => $employees]);

    }

    public function store(Request $request)
    {
        $employee = $this->employeeRepository->store($request->validated());
        return response()->json(['success' => true, 'employee' => $employee]);
    }

    public function show($id)
    {
        $employee = $this->employeeRepository->getById($id);
        return response()->json(['success' => true, 'employee' => $employee]);
    }

    public function update(Request $request, $id)
    {
        $this->employeeRepository->update($id, $request->validated());
        return response()->json(['success' => true, 'message' => 'Employee updated successfully.']);
    }

    public function destroy($id)
    {
        $this->employeeRepository->destroy($id);
        return response()->json(['success' => true, 'message' => 'Employee deleted successfully.']);
    }
}
