<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeeCollection extends Model
{
    protected $fillable = ['asess_id', 'grade_id', 'student_id', 'fee_type', 'months', 'tamount'];

    public function index()
    {
    	
    }
}
