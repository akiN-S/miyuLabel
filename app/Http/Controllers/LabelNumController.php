<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LabelNum;
use App\Models\LabelOngoingNum;
use App\Models\LabelDoneNum;
use App\Models\LabelSetting;

use App\Lib\MyFuncs;


class LabelNumController extends Controller
{

    const COUNT_NUM = 10;
    //
    public function input(Request $request) {

        $setting = LabelSetting::where('id', $request->settingId)->first();
        if ($request->input != NULL){ 
            
            $ongoingSum = LabelOngoingNum::where('settingId', $setting->id)->sum("ongoing");;
            if ($ongoingSum != $request->labelNumOnGoing){
                $ongoingInsert = new LabelOngoingNum();
                $ongoingInsert->ongoing = $request->labelNumOnGoing - $ongoingSum;
                $ongoingInsert->settingId = $setting->id;
                $ongoingInsert->save();
            }

            $doneSum = LabelDoneNum::where('settingId', $setting->id)->sum("done");
            if ($doneSum != $request->labelNumDone){
                $doneInsert = new LabelDoneNum();
                $doneInsert->done = $request->labelNumDone - $doneSum;
                $doneInsert->settingId = $setting->id;
                $doneInsert->save();
            }
            
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
            session()->flash('flash_message_type', "success");

        }else if ($request->plus != NULL){
            $ongoingInsert = new LabelOngoingNum();
            $ongoingInsert->ongoing = self::COUNT_NUM;
            $ongoingInsert->settingId = $setting->id;
            $ongoingInsert->save();

            session()->flash('flash_message', 'プラス10しました');
            session()->flash('flash_message_type', "success");

        }else if ($request->minus != NULL){
            $ongoingInsert = new LabelOngoingNum();
            $ongoingInsert->ongoing = self::COUNT_NUM * (-1);
            $ongoingInsert->settingId = $setting->id;
            $ongoingInsert->save();

            session()->flash('flash_message', 'マイナス10しました');
            session()->flash('flash_message_type', "success");

        }else if ($request->done != NULL){
            $ongoingInsert = new LabelOngoingNum();
            $ongoingInsert->ongoing = $request->labelNumOnGoing * (-1);
            $ongoingInsert->settingId = $setting->id;
            $ongoingInsert->save();


            $doneInsert = new LabelDoneNum();
            $doneInsert->done = $request->labelNumOnGoing;
            $doneInsert->settingId = $setting->id;
            $doneInsert->save();

            session()->flash('flash_message', '完了！次の箱を用意してください');
            session()->flash('flash_message_type', "success");
        
        }

        return redirect('/');
    }


    public function show(){
        $nums = array();
        $numInBox = 1;
        
        $setting = LabelSetting::where('isSelected', true)->first();
        if($setting === NULL){
            $setting = new LabelSetting();
            $setting->quota = 0;
            $setting->deliveryDate = strtotime(date('Y-m-d'));
            $setting->numInBox = 1;
            $setting->startDate = strtotime(date('Y-m-d'));
            $setting->unitPrice = 0;
            $setting->name = 'product';
            $setting->isSelected = true;
            $setting->save();
        }
        $setting = LabelSetting::where('isSelected', true)->first();

        $labelOngoingNum = LabelOngoingNum::all()->first();
        if($labelOngoingNum === NULL){
            $labelOngoingNum = new LabelOngoingNum();
            $labelOngoingNum->ongoing = 0;
            $labelOngoingNum->settingId = $setting->id;
            $labelOngoingNum->save();
        }

        $labelDoneNum = LabelDoneNum::all()->first();
        if($labelDoneNum === NULL){
            $labelDoneNum = new LabelDoneNum();
            $labelDoneNum->done = 0;
            $labelDoneNum->settingId = $setting->id;
            $labelDoneNum->save();
        }
        
        $labelNum = MyFuncs::getLabelNum($setting);

        return view('labelNum', ['labelNum' => $labelNum]);
    }


    public function dailyCount(Request $request){
        $dailyCountData = array(); // array for daily total number
        $dailyCountLabel = array(); // array for a month of days as a graph label
        $datesInfo = array(); // array to store date information for view
        $date = new \DateTime(); // getting today date

        $thisYear = (int) $date->format('Y'); // getting this year of today
        $thisMonth = (int) $date->format('m');  // getting this month of today

        if($request->year !== NULL && $request->month !== NULL){ // using parameters for target year and month if there are
            $targetYear = $request->year;
            $targetMonth = $request->month;
        }else{ // using this year and month of today for tartgt year and month if there are no parameters
            $targetYear = $thisYear;
            $targetMonth = $thisMonth;
        }

        // getting first and last days of the target year and month
        $firstDay  = (int) $date->setDate($targetYear, $targetMonth, 1)->format('d'); // 1 is fixed date for a month
        $lastDay  = (int) $date->setDate($targetYear, $targetMonth, 1)->format('t'); // 1 is fixed date for a month
        
        // counting daily total
        $setting = LabelSetting::where('isSelected', true)->first(); // getting target setting id

        $dailyCountDoneSum = LabelDoneNum::where('settingId', $setting->id)
        ->whereYear('created_at', $targetYear)
        ->whereMonth('created_at', $targetMonth)
        ->orderBy('created_at')
        ->get()
        ->groupBy(function ($row) {
            return (int) $row->created_at->format('d'); // it returns string with 02 digits padding by "0" , so converting to int
        })
        ->map(function ($day) {
            return $day->sum('done');
        });

        $dailyCountOngoingSum = LabelOngoingNum::where('settingId', $setting->id)
        ->whereYear('created_at', $targetYear)
        ->whereMonth('created_at', $targetMonth)
        ->orderBy('created_at')
        ->get()
        ->groupBy(function ($row) {
            return (int) $row->created_at->format('d'); // it returns string with 02 digits padding by "0" , so converting to int
        })
        ->map(function ($day) {
            return $day->sum('ongoing');
        });


        // making arrays for graph data and label
        $isGraphData = false; // a  flag to check a data exists
        for($i = $firstDay; $i <= $lastDay; $i++){ // going thorough first day to last day of the tartget month
            $dailyCountLabel[] = $i; // making lables for the graph

            $dailyCountData[] = 0; // adding new item in the array and initializing with 0
            $dailyCountDataIndex = $i - 1;

            if(isset($dailyCountDoneSum[$i])){ // if there are data
                $dailyCountData[$dailyCountDataIndex] += $dailyCountDoneSum[$i]; // adding the data 
                $isGraphData = true; // the flag is up
                // var_dump($dailyCount[$i]);
            }

            if(isset($dailyCountOngoingSum[$i])){ // if there are data

                $dailyCountData[$dailyCountDataIndex] += $dailyCountOngoingSum[$i]; // adding the data 
                $isGraphData = true; // the flag is up
                // var_dump($dailyCount[$i]);
            }
        }

        // gettting first date of year and month for form selection
        $firstDone = LabelDoneNum::orderBy('created_at', 'asc')->first();
        $firstDoneDate = new \DateTime($firstDone->created_at);
        $firstDoneYear = (int) $firstDoneDate->format('Y');
        $firstDoneMonth = (int) $firstDoneDate->format('m');

        // making an array for a selection of years
        $selectionYear = array();
        for($i = $firstDoneYear; $i <= $thisYear; $i++) $selectionYear += array($i => $i);

        // making an array for a selection of months
        $selectionMonth = array();
        for($i = 1; $i <= 12; $i++) $selectionMonth += array($i => $i);
        
        // setting up date information for view
        $datesInfo += array('selectionYear' => $selectionYear);
        $datesInfo += array('selectionMonth' => $selectionMonth);
        $datesInfo += array('targetYear' => $targetYear);
        $datesInfo += array('targetMonth' => $targetMonth);

        // showing a flush message if there is no date for the graph
        if($isGraphData === false){
            session()->flash('flash_message', $targetYear."年".$targetMonth."月はデータがありません");
            session()->flash('flash_message_type', "warning");
        }

        return view('dailyCount', ['dailyCountData' => $dailyCountData, 'dailyCountLabel' => $dailyCountLabel, 'datesInfo' => $datesInfo]);
    }


    public function test(){
        $setYear = 2021;
        $setMonth = 1;

        $dailyCount = array();

        $date = new \DateTime();
        $firstDay  = (int) $date->setDate($setYear, $setMonth, 1)->format('d'); // 日を1で固定値を入れている
        $lastDay  = (int) $date->setDate($setYear, $setMonth, 1)->format('t'); // 日を1で固定値を入れている

        
        $dailyCountSum = LabelDoneNum::whereYear('created_at', $setYear)
        ->whereMonth('created_at', $setMonth)
        ->orderBy('created_at')
        ->get()
        ->groupBy(function ($row) {
            return $row->created_at->format('d');
        })
        ->map(function ($day) {
            return $day->sum('done');
        });

        for($i = $firstDay; $i <= $lastDay; $i++){
            if(isset($dailyCountSum[$i])){
                $dailyCount += array($i => $dailyCountSum[$i]);
                // var_dump($dailyCount[$i]);
            }else{
                $dailyCount += array($i => 0);
            }
        }

        return view('test');
    }

    public function testPost(Request $request){
        $num = LabelOngoingNum::sum("ongoing");
        var_dump($num);
        return view('test', ['num' => $num]);
    }


}
