<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabelNum extends Model
{
    use HasFactory;
    protected $fillable = [
        'ongoing',
        'done',
        'doneBox',
        'left',
        'leftBox',
        'quota',
        'quotaBox',
        'quotaPerDay',
        'deliveryDateStr',
        'numInBox',
        'daysUntilDelivery',
        'quotaPerDay',
    ]; 

}
