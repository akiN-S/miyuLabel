<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LabelNum;
use App\Models\LabelOngoingNum;
use App\Models\LabelDoneNum;
use App\Models\LabelSetting;


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
            
            $ongoingSum = LabelOngoingNum::sum("ongoing");
            if ($ongoingSum != $request->labelNumOnGoing){
                $ongoingInsert = new LabelOngoingNum();
                $ongoingInsert->ongoing = $request->labelNumOnGoing - $ongoingSum;
                $ongoingInsert->save();
            }

            $doneSum = LabelDoneNum::sum("done");
            if ($doneSum != $request->labelNumDone){
                $doneInsert = new LabelDoneNum();
                $doneInsert->done = $request->labelNumDone - $doneSum;
                $doneInsert->save();
            }

            $setting = LabelSetting::all()->first();
            $settingInput = new LabelSetting();
            $settingInput->quota = $request->labelNumQuota;
            $settingInput->deliveryDate = strtotime($request->deliveryDate);
            $settingInput->numInBox = $request->labelNumInBox;
            if($setting != $settingInput){
                $setting->quota = $request->labelNumQuota;
                $setting->deliveryDate = strtotime($request->deliveryDate);
                $setting->numInBox = $request->labelNumInBox;
                $setting ->save();
            }

            session()->flash('flash_message', '入力した内容を反映しました');

        }else if ($request->plus != NULL){
            $ongoingInsert = new LabelOngoingNum();
            $ongoingInsert->ongoing = self::COUNT_NUM;
            $ongoingInsert->save();

            session()->flash('flash_message', 'プラス10しました');

        }else if ($request->minus != NULL){
            $ongoingInsert = new LabelOngoingNum();
            $ongoingInsert->ongoing = self::COUNT_NUM * (-1);
            $ongoingInsert->save();

            session()->flash('flash_message', 'マイナス10しました');

        }else if ($request->done != NULL){


            $ongoingInsert = new LabelOngoingNum();
            $ongoingInsert->ongoing = $request->labelNumOnGoing * (-1);
            $ongoingInsert->save();


            $doneInsert = new LabelDoneNum();
            $doneInsert->done = $request->labelNumOnGoing;
            $doneInsert->save();

            session()->flash('flash_message', '完了！次の箱を用意してください');
        
        }

        return redirect('/');
    }


    public function show(){
        $nums = array();
        $numInBox = 1;
        
        $labelOngoingNum = LabelOngoingNum::all()->first();
        if($labelOngoingNum === NULL){
            $labelOngoingNum = new LabelOngoingNum();
            $labelOngoingNum->ongoing = 0;
            $labelOngoingNum->save();
        }

        $labelDoneNum = LabelDoneNum::all()->first();
        if($labelDoneNum === NULL){
            $labelDoneNum = new LabelDoneNum();
            $labelDoneNum->done = 0;
            $labelDoneNum->save();
        }

        $setting = LabelSetting::all()->first();
        if($setting === NULL){
            $setting = new LabelSetting();
            $setting ->quota = 0;
            $setting ->deliveryDate = strtotime(date('Y-m-d'));
            $setting ->numInBox = 1;
            $setting ->save();
        }

        $labelNum = new LabelNum();
        $labelNum->ongoing = LabelOngoingNum::sum("ongoing");
        $labelNum->done = LabelDoneNum::sum("done");
        $labelNum->quota = $setting ->quota;
        $labelNum->deliveryDateStr = date('Y-m-d', $setting->deliveryDate);
        $labelNum->numInBox = $setting->numInBox;
        
        $labelNum->daysUntilDelivery = ($setting->deliveryDate - strtotime(date('Y-m-d'))) / (60 * 60 * 24) +1;;

        $labelNum->doneBox = $labelNum->done / $labelNum->numInBox;
        $labelNum->quotaBox = $labelNum->quota / $labelNum->numInBox;

        $labelNum->left = $labelNum->quota - $labelNum->done;
        $labelNum->leftBox = $labelNum->quotaBox - $labelNum->doneBox;

        $labelNum->quotaPerDay = $labelNum->left / $labelNum->daysUntilDelivery;

        return view('labelNum', ['labelNum' => $labelNum]);
    }


    public function test(){
        $nums = LabelNum::all();
        return view('test', ['nums' => $nums]);
    }

    public function testPost(Request $request){
        $num = LabelOngoingNum::sum("ongoing");
        var_dump($num);
        return view('test', ['num' => $num]);
    }


}
