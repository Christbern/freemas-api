<?php

namespace App\Http\Controllers;

use App\Models\PayrollSheet;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PayrollSheetController extends Controller
{
    /**
     * Generate or get payroll sheet for a given month.
     */
    public function generate(Request $request)
    {
        $validated = $request->validate([
            'month' => 'required|date_format:Y-m', // e.g. "2025-10"
        ]);

        $month = Carbon::createFromFormat('Y-m', $validated['month']);
        $startOfMonth = $month->copy()->startOfMonth();
        $endOfMonth = $month->copy()->endOfMonth();

        // Group attendances by employee and site
        $attendances = Attendance::with('employee.qualification')
            ->whereBetween('work_date', [$startOfMonth, $endOfMonth])
            ->where('present', true)
            ->get()
            ->groupBy(fn ($a) => $a->employee_id . '-' . $a->site_id);

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
        return PayrollSheet::with(['employee.qualification', 'site.client'])->latest()->get();
    }

    public function show($id)
    {
        return PayrollSheet::with(['employee', 'site'])->findOrFail($id);
    }
}
