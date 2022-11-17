<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Validator;

class navadminController extends Controller
{
    public function parentnavlist()
    {
        $parentnav = DB::table('parentnav')
        ->select('*')
        ->where('status_id','=',1)
        ->get();
        return view('nav.parentlist', compact('parentnav'));
    }
    public function submitnav(Request $request)
    {
        DB::table('parentnav')->insert([
            'parentnav_name'    => $request->parentnav_name,
            'parentnav_slug'    => $request->parentnav_slug,
            'status_id'         => 1,
        ]);
        return redirect('/parentnavlist')->with('success','Nav Added Successfully!!!');
    }
}
