<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fees extends Model
{
    protected $fillable = ['asession_id', 'grade_id', 'fee_type', 'amount'];
}
