<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use App\Repositories\AttendanceRepository;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{

    protected AttendanceRepository $attendanceRepository;

    public function __construct(AttendanceRepository $attendanceRepository)
    {
        $this->attendanceRepository = $attendanceRepository;
    }

    public function index()
    {
        $attendances = $this->attendanceRepository->getAll();
        return response()->json(['success' => true, 'attendances' => $attendances]);
    }

    public function store(Request $request)
    {
        // update or create process
    }

    public function show($id)
    {
        $attendance = $this->attendanceRepository->getById($id);
        return response()->json(['success' => true, 'attendance' => $attendance]);
    }

    public function destroy($id)
    {
        $this->attendanceRepository->destroy($id);
        return response()->json(['success' => true, 'message' => 'Attendance deleted successfully']);
    }
}
