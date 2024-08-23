<?php

namespace App\Http\Controllers;

use App\Models\{Matches, User};
use Carbon\Carbon;

class DashboardController extends Controller
{
    
    public function index()
    {
      
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth   = Carbon::now()->endOfMonth();

        // This month's users
        $data['thisMonthUsers']    = User::where('id','!=','1')->whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
 
        // Adjust the query based on your matches table structure
        $data['totalMatchedUsers'] = Matches::count();

        // Overall users
        $data['overallUsers']      = User::where('id','!=','1')->count();
 
        return view('index',compact('data'));
    }

}
