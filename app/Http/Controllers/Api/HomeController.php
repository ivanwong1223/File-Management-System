<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class HomeController extends Controller
{
    public function getDataHome(){
        $forders = DB::table('forders')->get();
        $files = DB::table('files')->orderBy('id','desc')->get();
        

        return[
            'forders' => $forders,
            'files' => $files
        ];
    }
}
