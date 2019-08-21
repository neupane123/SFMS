<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asession extends Model
{
	protected $table = 'asessions';
    protected $fillable = ['name'];
}
