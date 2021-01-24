<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LabelNum;


class LabelNumController extends Controller
{

    const TYPE_ON_GOING="ongoing";
    const TYPE_DONE="done";
    const TYPE_QUOTA="quota";
    const TYPE_NUM_IN_BOX="numInBox";
    
    const COUNT_NUM = 10;
    //
    public function input(Request $request) {
        

        if ($request->input != NULL){
            $num = LabelNum::where('type', self::TYPE_ON_GOING)->first();
            $num->labelNum = $request->labelNumOnGoing;
            $num->save();

            $num = LabelNum::where('type', self::TYPE_DONE)->first();
            $num->labelNum = $request->labelNumDone;
            $num->save();

            // var_dump($request->labelNumOnGoing);

        }else if ($request->plus != NULL){
            $num = LabelNum::where('type', self::TYPE_ON_GOING)->first();
            $num->labelNum = $num->labelNum + $COUNT_NUM ;
            $num->save();

        }else if ($request->minus != NULL){
            $num = LabelNum::where('type', self::TYPE_ON_GOING)->first();
            $num->labelNum = $num->labelNum - $COUNT_NUM ;
            $num->save();

        }else if ($request->done != NULL){
            $numOnGoing = LabelNum::where('type', self::TYPE_ON_GOING)->first();
            $numOnGoing->labelNum = 0;
            $numOnGoing->save();

            $numDone = LabelNum::where('type', self::TYPE_DONE)->first();
            $numDone->labelNum = $numDone->labelNum + $request->labelNumOnGoing;
            $numDone->save();
        
        }

        // $nums = LabelNum::all();
        // return view('labelNum', ['nums' => $nums]);
        return redirect('/');

    }


    public function show(){
        $nums = array();

        $targetType = self::TYPE_ON_GOING;
        $num = LabelNum::where('type', $targetType)->first();
        if($num === NULL) $num = 0;
        $nums += array($targetType => $num);

        $targetType = self::TYPE_DONE;
        $num = LabelNum::where('type', $targetType)->first();
        if($num === NULL) $num = 0;
        $nums += array($targetType => $num);

        $targetType = self::TYPE_QUOTA;
        $num = LabelNum::where('type', $targetType)->first();
        if($num === NULL) $num = 0;
        $nums += array($targetType => $num);

        $targetType = self::TYPE_NUM_IN_BOX;
        $num = LabelNum::where('type', $targetType)->first();
        if($num === NULL) $num = 0;
        $nums += array($targetType => $num);

        return view('labelNum', ['nums' => $nums]);
    }


    public function test(){
        $nums = LabelNum::all();
        return view('test', ['nums' => $nums]);
    }

}
