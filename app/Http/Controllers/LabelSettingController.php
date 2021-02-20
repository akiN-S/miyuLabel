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
    const NEW_ID = -1;


    public function show(){
        $settings = array();
        $labelNums = array();

        $settings = LabelSetting::all(); // getting all product settings
        foreach ($settings as $setting){
            $labelNums[] = MyFuncs::getLabelNum($setting); // calculating and setting data
        }
        return view('labelSetting', ['labelNums'=>$labelNums]);
    }

    public function input(Request $request){

        if ($request->new != NULL){ // when new is clicked
            $labelNum = new LabelNum(); // making a new object
            $labelNum->settingId = self::NEW_ID; // setting id as new id which is -1
        }else if ($request->edit != NULL){ // when edit is clicked
            $setting = LabelSetting::where('id', $request->settingId)->first(); // getting the setting
            $labelNum = MyFuncs::getLabelNum($setting); // calculating and setting data
        }

        return view('labelSettingInput', ['labelNum'=>$labelNum]);
    }

    public function save(Request $request){
        
        if($request->settingId == self::NEW_ID){ // for new item, checking by the new id which is -1
            $setting = new LabelSetting();
        }else{ // for existing item
            $setting = LabelSetting::where('id', $request->settingId)->first();
        }

        if ($request->save != NULL){ // when save is clicked

            if($request->isSelected === "on"){ // when isSelected is selected, it gives "on" as String. Note: when it's not selected, it's NULL
                $settingSelected = LabelSetting::where('isSelected', true)->first(); // getting current selected item
                if( $settingSelected === null){ //if $settingSelected is null (means saving itme is the first item)
                    $setting->isSelected = true;
                } else if($settingSelected->id !== $setting->id){ // if inputted selected item is different from current selected item
                    $settingSelected->isSelected = false; // making the current selected item false
                    $settingSelected->save();
                    $setting->isSelected = true; // making the inputted selected item true
                }
            }

            // setting other inputted data
            $setting->name = $request->settingName; 
            $setting->startDate = $request->startDate;
            $setting->deliveryDate = $request->deliveryDate;
            $setting->quota = $request->labelNumQuota;
            $setting->numInBox = $request->labelNumInBox;
            $setting->unitPrice = $request->unitPrice;
            $setting ->save();

            // setting a flash message
            session()->flash('flash_message', '入力した保存を反映しました');
            session()->flash('flash_message_type', "success");
        }

        // else if ($request->back != NULL) // nothing to do when "back" is clicked

        return redirect('/labelSetting');
        // return view('test');

    }

}
