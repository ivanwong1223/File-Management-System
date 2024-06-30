<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class ForderController extends Controller
{
    public function create(Request $request){
        $request->validate([
            'name' => 'required'
        ]);

        $forder = DB::table('forders')->insert($request->all());

        return $forder;
    }

    public function edit($id){
        $forder = DB::table('forders')->where('id',$id)->first();

        return $forder;
    }

    public function update(Request $request, $id){
        $request->validate([
            'name' => 'required'
        ]);

        $forder = DB::table('forders')->where('id',$id)->update($request->all());

        return $forder;
    }

    public function delete($id){
        $files = DB::table('files')->where('forder_id', $id)->get();
        foreach($files as $file){
            unlink(storage_path('app/public/uploads/', $file->name));
        }

        $forder = DB::table('forders')->where('id',$id)->delete();
        $files = DB::table('files')->where('forder_id',$id)->delete();

        return $forder;
    }
}
