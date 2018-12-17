<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ResetPassword;

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

    // 发送密码重置消息
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPassword($token));
    }

    // 一对多 一个用户拥有多个微博
    public function statuses()
    {
        return $this->hasMany(Status::class);
    }

    // 当前用户的微博列表和关注人的微博动态数据
    public function feed()
    {
        $user_ids = Auth::user()->followings->pluck('id')->toArray();

        array_push($user_ids,Auth::user()->id);

        return Status::whereIn('user_id',$user_ids)->with('user')->orderBy('created_at','desc');
        //return $this->statuses()->OrderBy('created_at','desc');
    }

    // 多对多 一个用户拥有多个粉丝
    public function followers()
    {
        return $this->belongsToMany(User::Class,'followers','user_id','follower_id');
    }

    // 多对多 一个粉丝可以关注多个用户
    public function followings()
    {
        return $this->belongsToMany(User::Class,'followers','follower_id','user_id');
    } 

    // 关注用户
    public function follow($user_ids)
    {
        if(!(is_array($user_ids))) {
            $user_ids = compact($user_ids);
        }
        $this->followings()->sync($user_ids,false);
    }

    // 取消关注
    public function unfollow($user_ids)
    {
        if(!(is_array($user_ids))) {
            $user_ids = compact($user_ids);
        }
        $this->followings()->detach($user_ids);
    }

    // 当前用户A是否关注了用户B
    public function isFollowing($user_id)
    {
        return $this->followings->contains($user_id);
    }
}
