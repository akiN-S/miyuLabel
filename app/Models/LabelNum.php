<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabelNum extends Model
{
    use HasFactory;
    protected $fillable = [
        'settingId',
        'name',
        'numInBox',
        'quota',
        'deliveryDateStr',
        'startDateStr',
        'unitPrice',
        'isSelected',

        'ongoing',
        'done',

        'doneBox',
        'left',
        'leftBox',
        'quotaBox',
        'quotaPerDay',
        'daysUntilDelivery',
        'quotaPerDay',
        'price',
    ]; 

}
