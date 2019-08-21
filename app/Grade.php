<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
	protected $fillable = ['grade_name', 'grade'];

    public function sections()
    {
    	return $this->belongsToMany('App\Section')->using('App\GradeSection');
    }
}
