<?php

namespace App\Http\Controllers;

use App\Models\PayrollSheet;
use App\Models\Attendance;
use App\Repositories\PayrollSheetRepository;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PayrollSheetController extends Controller
{

    protected PayrollSheetRepository $payrollSheetRepository;

    /**
     * Generate or get payroll sheet for a given month.
     */
    public function generate(Request $request)
    {
    
        $month = Carbon::createFromFormat('Y-m', $request->validated['month']);
        $attendances = $this->payrollSheetRepository->getByEmployeeAndSite($month);

        $results = [];

        foreach ($attendances as $key => $records) {
            $employee = $records->first()->employee;
            $site = $records->first()->site;
            $daysWorked = $records->count();
            $dailyRate = $employee->qualification->daily_rate ?? 0;
            $totalAmount = $daysWorked * $dailyRate;

            $payroll = PayrollSheet::updateOrCreate(
                [
                    'employee_id' => $employee->id,
                    'site_id' => $site->id ?? null,
                    'month' => $month->format('Y-m-d'),
                ],
                [
                    'days_worked' => $daysWorked,
                    'total_amount' => $totalAmount,
                ]
            );

            $results[] = $payroll;
        }

        return response()->json([
            'message' => 'Payroll generated successfully.',
            'data' => $results,
        ]);
    }

    public function index()
    {
        $attendances = $this->payrollSheetRepository->getLatest();
        return response()->json(['success' => true, 'attendances' => $attendances]);
    }

    public function show($id)
    {
        $attendance = $this->payrollSheetRepository->getById($id);
        return response()->json(['success' => true, 'attendance' => $attendance]);
    }
}
