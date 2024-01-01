<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\DB as FacadesDB;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($employeeId = null)
    {
        if(!$employeeId) {
            $employeeId = auth()->user()->employee->id;
        }

        $next_week = Carbon::now()->addWeek()->week;

        // week starts at sunday, prevents that it returns the wrong week for the upcoming week
        // Example: week 47 sunday == week 49 accourding to the next week. This prevents that.
        if(Carbon::now()->formatLocalized('%A') == 'Sunday') {
            $next_week--;
        }

        $current_year = Carbon::now()->year;

        $attendances = Attendance::where('week_number', $next_week)
            ->where('year', $current_year)
            ->where('employee_id', $employeeId)
            ->get();

        //api call
        return response()->json($attendances);

        // dd($next_week);
        // web call
        return view('employee.attendance-schedule', [
            'attendances' => $attendances,
        ]);
    }

    public function getYearlyEmployeeAttendance(Request $request) {
        $request->validate([
            'employee_id' => 'required',
        ]);

        // get the attendances of the employee and group them by daynumber
        $attendances = Attendance::whereRaw('WEEK(created_at) = WEEK(NOW())')
            ->where('on_site', true)
            ->groupBy('week_day')
            ->get(['week_day', DB::raw('COUNT(*) as count')]);

        $currentWeekDays = [
            'Monday' => $attendances[0]->count,
            'Tuesday' => $attendances[1]->count,
            'Wednesday' => $attendances[2]->count,
            'Thursday' => $attendances[3]->count,
            'Friday' => $attendances[4]->count,
        ];


        // $attendances = Attendance::where('employee_id', $request->employee_id)
        //     ->where('year', Carbon::now()->year)
        //     ->get();

        return response()->json($currentWeekDays);
    }

    public function getCompanyAttendance(Request $request)
    {
        $request->validate([
            'company_id' => 'required|integer',
        ]);

        $lastYearRecords = Attendance::whereYear('created_at', now()->subYear())->get();

        $currentYearRecords = Attendance::whereYear('created_at', now()->year())->get();

        $lastYearQuarters = [
            'Q1' => 0,
            'Q2' => 0,
            'Q3' => 0,
            'Q4' => 0,
        ];

        $currentYearQuarters = [
            'Q1' => 0,
            'Q2' => 0,
            'Q3' => 0,
            'Q4' => 0,
        ];

        foreach ($lastYearRecords as $record) {
            if ($record->created_at->month <= 3) {
                $lastYearQuarters['Q1']++;
            } elseif ($record->created_at->month <= 6) {
                $lastYearQuarters['Q2']++;
            } elseif ($record->created_at->month <= 9) {
                $lastYearQuarters['Q3']++;
            } elseif ($record->created_at->month <= 12) {
                $lastYearQuarters['Q4']++;
            }
        }

        foreach ($currentYearRecords as $record) {
            if ($record->created_at->month <= 3) {
                $currentYearQuarters['Q1']++;
            } elseif ($record->created_at->month <= 6) {
                $currentYearQuarters['Q2']++;
            } elseif ($record->created_at->month <= 9) {
                $currentYearQuarters['Q3']++;
            } elseif ($record->created_at->month <= 12) {
                $currentYearQuarters['Q4']++;
            }
        }

        return response()->json([
            'lastYearAttendance' => [
                'year' => (string)now()->subYear()->year,
                'quarters' => $lastYearQuarters,
            ],
            'currentYearAttendance' => [
                'year' => (string)now()->year,
                'quarters' => $currentYearQuarters,
            ],
        ]);
    }

    public function getWeeklyAttendance(Request $request)
    {
        $request->validate([
            'company_id' => 'required|integer',
        ]);

        $currentWeekRecords = Attendance::whereRaw('WEEK(created_at) = WEEK(NOW())')
            ->where('on_site', true)
            ->groupBy('week_day')
            ->get(['week_day', DB::raw('COUNT(*) as count')]);

        $currentWeekDays = [
            'Monday' => $currentWeekRecords[0],
            'Tuesday' => $currentWeekRecords[1],
            'Wednesday' => $currentWeekRecords[2],
            'Thursday' => $currentWeekRecords[3],
            'Friday' => $currentWeekRecords[4],
        ];

        return response()->json($currentWeekDays);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($employee_id): void
    {
        for($i=0; $i < 7; $i++) {
            Attendance::create([
                'employee_id' => $employee_id,
                'week_number' => Carbon::now()->addWeek()->week,
                'week_day'    => $i + 1,
                'year'        => Carbon::now()->year,
                'on_site'     => false
            ]);
        }

        return;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): void
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Attendance $attendence): void
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attendance $attendence): void
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $weekNumber, $weekDay)
    {
        if($request->employeeId) {
            $employeeId = $request->employeeId;
        }
        else {
            $employeeId = auth()->user()->employee->id;
        }

        $attendance = Attendance::where('employee_id', $employeeId)
            ->where('week_number', $weekNumber)
            ->where('week_day', $weekDay)
            ->first();

        $attendance->update([
            'on_site' => !$attendance->on_site,
        ]);

        return response()->json([
            'success' => 'Attendance updated.'
        ], 200);
    }

    public function copy()
    {
        $next_week = Carbon::now()->addWeek()->week;
        $second_week = Carbon::now()->addWeeks(2)->week;
        $current_year = Carbon::now()->year;

        $current_attendances = Attendance::where('week_number', $next_week)
            ->where('year', $current_year)
            ->where('employee_id', auth()->user()->employee->id)
            ->get();

        foreach($current_attendances as $attendance) {
            Attendance::create([
                'employee_id' => $attendance->employee_id,
                'week_number' => $second_week,
                'week_day'    => $attendance->week_day,
                'year'        => $current_year,
                'on_site'     => $attendance->on_site,
            ]);
        }

        return redirect()->route('attendance-schedule')->with('success', 'Your attendance ahs been copied!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attendance $attendence): void
    {
        //
    }
}
