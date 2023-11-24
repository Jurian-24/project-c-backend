<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $next_week = Carbon::now()->addWeek()->week;
        $current_year = Carbon::now()->year;

        $attendances = Attendance::where('week_number', $next_week)
            ->where('year', $current_year)
            ->where('employee_id', auth()->user()->employee->id)
            ->get();
        return view('employee.attendance-schedule', [
            'attendances' => $attendances,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($employee_id)
    {
        for ($i=0; $i < 7; $i++) {
            Attendance::create([
                'employee_id' => $employee_id,
                'week_number' => Carbon::now()->addWeek()->week,
                'week_day' => $i + 1,
                'year' => Carbon::now()->year,
                'onSite' => false
            ]);
        }

        return;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Attendance $attendence)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attendance $attendence)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $weekNumber, $weekDay)
    {
        $attendance = Attendance::where('employee_id', auth()->user()->employee->id)
            ->where('week_number', $weekNumber)
            ->where('week_day', $weekDay)
            ->first();

        $attendance->update([
            'onSite' => !$attendance->onSite,
        ]);

        return;
    }

    public function copy() {
        $next_week = Carbon::now()->addWeek()->week;
        $second_week = Carbon::now()->addWeeks(2)->week;
        $current_year = Carbon::now()->year;

        $current_attendances = Attendance::where('week_number', $next_week)
            ->where('year', $current_year)
            ->where('employee_id', auth()->user()->employee->id)
            ->get();

        foreach ($current_attendances as $attendance) {
            Attendance::create([
                'employee_id' => $attendance->employee_id,
                'week_number' => $second_week,
                'week_day' => $attendance->week_day,
                'year' => $current_year,
                'onSite' => $attendance->onSite,
            ]);
        }

        return redirect()->route('attendance-schedule')->with('success', 'Your attendance ahs been copied!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attendance $attendence)
    {
        //
    }
}
