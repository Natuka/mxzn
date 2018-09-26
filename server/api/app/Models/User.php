<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    // 登录关联
    private static $userables = [
        'App\Models\Engineer',
        'App\Models\Customer',
        'App\Models\Staff',
        'App\Models\OutStaff',
    ];

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

    public static function findBy($input, $field = 'email')
    {
        return self::where($field, $input)->first();
    }

    public static function findByEmailMobileName($input)
    {
        return self::where('email', $input)
        ->orWhere('name', $input)
        ->orWhere('mobile', $input)
        ->first();
    }

    public function userable()
    {
        return $this->morphTo();
    }

    /**
     * 验证是否是管理者
     * @return bool
     */
    public function isAdmin()
    {
        if (empty($this->attributes['userable_type']) || $this->attributes['userable_id'] === 0) {
            return true;
        }

        return false;
    }

    /**
     * 获取第三方登录
     * @return null
     */
    public function getTypeModel()
    {
        if (in_array($this->attributes['userable_type'], self::$userables) && $this->attributes['userable_id'] > 0) {
            $className = $this->attributes['userable_type'];
            return $className::find($this->attributes['userable_id']);
        }

        return null;
    }
}
