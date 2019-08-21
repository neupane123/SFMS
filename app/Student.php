<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = ['asession_id', 'grade_id', 'fname', 'lname', 'email'];
}
