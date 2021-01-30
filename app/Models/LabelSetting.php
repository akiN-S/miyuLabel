<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabelSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'quota',
        'deliveryDate',
        'numInBox',
    ]; 
}
