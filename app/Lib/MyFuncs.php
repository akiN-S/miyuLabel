<?php
namespace App\Lib;

use Illuminate\Support\Facades\DB;

use App\Models\LabelNum;
use App\Models\LabelOngoingNum;
use App\Models\LabelDoneNum;
use App\Models\LabelSetting;

class Myfuncs {
    public static function getLabelNum($setting){
        $labelNum = new LabelNum();

        $labelNum->settingId = $setting->id;
        $labelNum->name = $setting->name;
        $labelNum->numInBox = $setting->numInBox;
        $labelNum->quota = $setting->quota;
        $labelNum->deliveryDate = $setting->deliveryDate;
        $labelNum->startDate = $setting->startDate;
        $labelNum->unitPrice = $setting->unitPrice;
        $labelNum->isSelected = $setting->isSelected;

        $labelNum->ongoing = LabelOngoingNum::where('settingId', $setting->id)->sum("ongoing");
        $labelNum->done = LabelDoneNum::where('settingId', $setting->id)->sum("done");
        
        $labelNum->daysUntilDelivery = (strtotime($setting->deliveryDate) - strtotime(date('Y-m-d'))) / (60 * 60 * 24) +1;;

        $labelNum->doneBox = $labelNum->done / $labelNum->numInBox;
        $labelNum->quotaBox = $labelNum->quota / $labelNum->numInBox;

        $labelNum->left = $labelNum->quota - $labelNum->done;
        $labelNum->leftBox = $labelNum->quotaBox - $labelNum->doneBox;

        if($labelNum->daysUntilDelivery == 0){
            $labelNum->quotaPerDay = "納品日後";
        }else{
            $labelNum->quotaPerDay = $labelNum->left / $labelNum->daysUntilDelivery;

        }

        $labelNum->price = $labelNum->unitPrice * $labelNum->done;

        return $labelNum;
    }

    
}