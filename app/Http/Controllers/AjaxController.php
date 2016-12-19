<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AjaxController extends Controller
{
    public function AddCourse()
    {
        if(! isset($_REQUEST['Email'])){
//            return response()->json(array('msg'=>1), 200);
        }
//        $Email = $_REQUEST['Email'];
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
