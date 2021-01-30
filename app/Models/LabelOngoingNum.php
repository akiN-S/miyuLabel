<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabelOngoingNum extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'ongoing',
    ]; 
}
