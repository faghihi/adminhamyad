<?php

namespace App\Http\Controllers;

use App\Pack;
use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function AddCourse()
    {
        if(! isset($_REQUEST['conceptName']) || isset($_REQUEST['packId'])){
//            return response()->json(array('msg'=>1), 200);
        }
        $conceptName = $_REQUEST['conceptName'];
        $packId = $_REQUEST['packId'];
        $pack = Pack::find($packId);

        try{
            $pack->courses()->attach($conceptName);
        }
        catch ( \Illuminate\Database\QueryException $e){
            return response()->json(array('msg'=> 2), 200);
        }
//        $sub=new Subscribe();
//        $sub->email=$Email;
//        try{
//            $sub->save();
//        }
//        catch ( \Illuminate\Database\QueryException $e){
//            return response()->json(array('msg'=> 2), 200);
//        }
//        return response()->json(array('msg'=> 3), 200);

    }
}
