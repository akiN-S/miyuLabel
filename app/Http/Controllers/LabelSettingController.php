<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\LabelNum;
use App\Models\LabelOngoingNum;
use App\Models\LabelDoneNum;
use App\Models\LabelSetting;

use App\Lib\MyFuncs;


class LabelSettingController extends Controller
{
    //
    public function show(){
        $labelNums = array();
        $setting = LabelSetting::where('isSelected', true)->first();
        $labelNums += array(MyFuncs::getLabelNum($setting));
        var_dump($labelNums);
        
        return view('labelSetting', ['labelNums'=>$labelNums]);
    }
}
