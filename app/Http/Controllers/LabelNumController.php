<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LabelNum;


class LabelNumController extends Controller
{
    //
    public function input(Request $request) {
        $ID_ON_GOING=1;
        $TYPE_ON_GOING="ongoing";
        $ID_DONE=2;
        $TYPE_DONE="done";
        $COUNT_NUM = 10;

        if ($request->inputOnGoing != NULL){
            $num = LabelNum::where('type', $TYPE_ON_GOING)->get();
            $num[0]->labelNum = $request->labelNumeOnGoing;
            $num[0]->save();

            // var_dump($request->labelNumeOnGoing);

        }else if ($request->plus != NULL){
            $num = LabelNum::where('type', $TYPE_ON_GOING)->get();
            $num[0]->labelNum = $num[0]->labelNum + $COUNT_NUM ;
            $num[0]->save();

        }else if ($request->minus != NULL){
            $num = LabelNum::where('type', $TYPE_ON_GOING)->get();
            $num[0]->labelNum = $num[0]->labelNum - $COUNT_NUM ;
            $num[0]->save();

        }else if ($request->done != NULL){
            $numOnGoing = LabelNum::where('type', $TYPE_ON_GOING)->get();
            $numOnGoing[0]->labelNum = 0;
            $numOnGoing[0]->save();

            $numDone = LabelNum::where('type', $TYPE_DONE)->get();
            $numDone[0]->labelNum = $numDone[0]->labelNum + $request->labelNumeOnGoing;
            $numDone[0]->save();
        
        }else if($request->inputDone != NULL){
            $num = LabelNum::where('type', $TYPE_DONE)->get();
            $num[0]->labelNum = $request->labelNumeDone;
            $num[0]->save();

        }

        // $nums = LabelNum::all();
        // return view('labelNum', ['nums' => $nums]);
        return redirect('/');

    }


    public function show(){
        $nums = LabelNum::all();
        return view('labelNum', ['nums' => $nums]);

    }


}
