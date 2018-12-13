<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
	protected $fillable = ['content'];
	// 一对一  一个微博属于一个用户
    public function user()
    {
    	return $this->belongsTo(User::class);
    }
}
