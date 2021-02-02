<?php

namespace App\Console\Commands\Convert;

use Illuminate\Console\Command;

use App\Models\LabelSetting;

class ConvertIntDateToDateDate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:ConvertIntDateToDateDate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To convert delivery and start date int to date date on labelSetting table in DB';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $settings = LabelSetting::all(); // getting all product settings
        foreach ($settings as $setting){
            // $labelNums[] = MyFuncs::getLabelNum($setting); // calculating and setting data
            $setting->startDate = date('Y-m-d', $setting->startDateOldInt);
            $setting->deliveryDate = date('Y-m-d', $setting->deliveryDateOldInt);
            $setting->save();
        }
        
        return 0;
    }
}
