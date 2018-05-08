<?php

namespace App\Http\Controllers\Index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    //
    public function returnView () {
        $user = DB::table('admin')->get();
        return view('index');
    }
}
