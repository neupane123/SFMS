<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeeType extends Model
{
	protected $table = 'fee_types';
    protected $fillable = ['type'];
}
