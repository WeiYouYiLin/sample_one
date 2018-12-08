<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    //  监听到模型的创建 boot 方法会在用户模型类完成初始化之后进行加载
    public static function boot()
    {
        parent::boot();

        static::creating(function ($user) {

            $user->activation_token = str_random(30);

        });
    }
    
    //  用户头像链接
    public function gravatar($size = '100')
    {
        $hash = md5(strtolower(trim($this->attributes['email'])));
        return "http://gravatar.com/avatar/$hash?s=$size";
    }
}
