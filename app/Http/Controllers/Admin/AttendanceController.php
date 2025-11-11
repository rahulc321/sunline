<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance           ;
use Carbon\Carbon;
use Auth;
use App\User;

class AttendanceController extends Controller
{

    

     # punch in
     public function punchIn()
     {
         $user = Auth::user();
         $today = Carbon::today()->toDateString();
     
         $attendance = Attendance::firstOrNew(
             ['user_id' => $user->id, 'date' => $today]
         );
     
         if (!empty($attendance->punch_in)) {
             session()->flash('success', 'You already punched in today.');
             return back();
         }
     
         $attendance->punch_in = Carbon::now()->toTimeString();
         $attendance->save();
     
         session()->flash('success', 'Punched in successfully.');
         return back();
     }
     
 
     # punch out
     public function punchOut()
     {
         $user = Auth::user();
         $today = Carbon::today();
 
         $attendance = Attendance::where('user_id', $user->id)
             ->where('date', $today)
             ->first();
 
         if (!$attendance || !$attendance->punch_in) {
             return back()->with('success', 'You need to punch in first.');
         }
 
         if ($attendance->punch_out) {
             return back()->with('success', 'You already punched out today.');
         }
 
         $attendance->update(['punch_out' => Carbon::now()->format('H:i:s')]);
 
         return back()->with('success', 'Punched out successfully.');
     }
 
     # admin view
     
     public function userAttendance(Request $request)
     {
         $month = $request->get('month', Carbon::now()->format('Y-m'));
         $startDate = Carbon::parse($month)->startOfMonth();
     
         // end date should be today if current month, else last day of that month
         $endDate = Carbon::parse($month)->isCurrentMonth()
             ? Carbon::today()
             : Carbon::parse($month)->endOfMonth();
     
         
        $user = Auth::user();

        // check if user has the "Sales Rep" role
        $isSalesRep = $user->roles->contains('title', 'Sales Rep');
        
        // base query
        $query = Attendance::with('user')
            ->whereBetween('date', [$startDate, $endDate])
            ->orderBy('date', 'asc');
        
        // if user is Sales Rep, filter by their own ID
        
        if ($isSalesRep) {
            $query->where('user_id', $user->id);
            $users =  User::where('id',$user->id)->get();
        }else{
            $users =  User::all();
        }
        
        // get and group results
        $attendances = $query->get()->groupBy('user_id');
     
         
     
         $data = [];
         foreach ($users as $user) {
             $userAttendances = $attendances->get($user->id, collect());
     
             $days = [];
             for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
                 $record = $userAttendances->firstWhere('date', $date->toDateString());
     
                 if ($record) {
                     $status = $record->punch_in && $record->punch_out ? 'P' : 'SP';
                     $punchIn = $record->punch_in ?? '-';
                     $punchOut = $record->punch_out ?? '-';
                 } else {
                     $status = 'A';
                     $punchIn = '-';
                     $punchOut = '-';
                 }
     
                 $days[] = [
                     'date' => $date->toDateString(),
                     'punch_in' => $punchIn,
                     'punch_out' => $punchOut,
                     'status' => $status,
                 ];
             }
     
             $data[] = [
                 'user' => $user,
                 'days' => $days,
             ];
         }
     
         return view('admin.attendance.index', [
             'data' => $data,
             'month' => $month,
             'startDate' => $startDate,
             'endDate' => $endDate,
         ]);
     }
     

 
     # user view (optional)
     public function userAttendance1()
     {
         $attendances = Attendance::where('user_id', Auth::id())->orderBy('date', 'desc')->get();
         return view('admin.attendance.index', compact('attendances'));
     }
}
