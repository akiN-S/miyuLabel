<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LabelNum;


class LabelNumController extends Controller
{

    const TYPE_ON_GOING="ongoing";
    const TYPE_DONE="done";
    const TYPE_DONE_BOX="doneBox";
    const TYPE_LEFT="labelNumLeft";
    const TYPE_LEFT_BOX="labelNumLeftBox";
    const TYPE_QUOTA="quota";
    const TYPE_QUOTA_BOX="quotaBox";
    const TYPE_QUOTA_PER_DAY="quotaPerDay";
    const TYPE_DELIVERY_DATE="deliveryDate";
    const TYPE_NUM_IN_BOX="numInBox";
    const TYPE_DYAS_UNTIL_DELIVERY="daysUntilDelivery";
    
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

            $num = LabelNum::where('type', self::TYPE_QUOTA)->first();
            $num->labelNum = $request->labelNumQuota;
            $num->save();

            $num = LabelNum::where('type', self::TYPE_DELIVERY_DATE)->first();
            $num->labelNum = strtotime($request->deliveryDate);
            $num->save();

            $num = LabelNum::where('type', self::TYPE_NUM_IN_BOX)->first();
            $num->labelNum = $request->labelNumInBox;
            $num->save();



        }else if ($request->plus != NULL){
            $num = LabelNum::where('type', self::TYPE_ON_GOING)->first();
            $num->labelNum = $num->labelNum + self::COUNT_NUM ;
            $num->save();

        }else if ($request->minus != NULL){
            $num = LabelNum::where('type', self::TYPE_ON_GOING)->first();
            $num->labelNum = $num->labelNum - self::COUNT_NUM ;
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
        $numInBox = 1;


        $targetType = self::TYPE_NUM_IN_BOX;
        $num = LabelNum::where('type', $targetType)->first();
        if($num === NULL) {
            $num = new LabelNum();
            $num->type = $targetType;
            $num->labelNum = 1;
            $num->save();
        }
        $nums += array($targetType => $num->labelNum);
        $numInBox = $num->labelNum;

        $targetType = self::TYPE_DELIVERY_DATE ;
        $num = LabelNum::where('type', $targetType)->first();
        if($num === NULL) {
            $num = new LabelNum();
            $num->type = $targetType;
            $num->labelNum = strtotime(date('Y-m-d'));
            $num->save();
        }
        $nums += array($targetType=> date('Y-m-d', $num->labelNum));
        $deliveryDate = $num->labelNum;

        $targetType = self::TYPE_DYAS_UNTIL_DELIVERY;
        $daysUntilDelivery = ($deliveryDate - strtotime(date('Y-m-d'))) / (60 * 60 * 24) +1;
        $nums += array($targetType => $daysUntilDelivery);

        $targetType = self::TYPE_QUOTA;
        $num = LabelNum::where('type', $targetType)->first();
        if($num === NULL) {
            $num = new LabelNum();
            $num->type = $targetType;
            $num->labelNum = 0;
            $num->save();
        }
        $nums += array($targetType => $num->labelNum);
        $numQuota = $num->labelNum;



        $targetType = self::TYPE_ON_GOING;
        $num = LabelNum::where('type', $targetType)->first();
        if($num === NULL) {
            $num = new LabelNum();
            $num->type = $targetType;
            $num->labelNum = 0;
            $num->save();
        }
        $nums += array($targetType => $num->labelNum);

        $targetType = self::TYPE_DONE;
        $num = LabelNum::where('type', $targetType)->first();
        if($num === NULL) {
            $num = new LabelNum();
            $num->type = $targetType;
            $num->labelNum = 0;
            $num->save();
        }
        $nums += array($targetType => $num->labelNum);
        $numDone = $num->labelNum;

        $targetType = self::TYPE_DONE_BOX;
        $numDoneBox = $numDone / $numInBox;
        $nums += array($targetType => $numDoneBox);

        $targetType = self::TYPE_QUOTA_BOX;
        $numQuotaBox = $numQuota / $numInBox;
        $nums += array($targetType => $numQuotaBox);

        $targetType = self::TYPE_LEFT;
        $nums += array($targetType => $numQuota - $numDone);

        $targetType = self::TYPE_LEFT_BOX;
        $nums += array($targetType => $numQuotaBox - $numDoneBox);

        $targetType = self::TYPE_QUOTA_PER_DAY;
        $nums += array($targetType => ($numQuota - $numDone) / $daysUntilDelivery);


       

        return view('labelNum', ['nums' => $nums]);
    }


    public function test(){
        $nums = LabelNum::all();
        return view('test', ['nums' => $nums]);
    }

    public function testPost(Request $request){
        $nums = LabelNum::all();
        var_dump(strtotime($request->deliveryDate));

        return view('test', ['nums' => $nums]);
    }

}
