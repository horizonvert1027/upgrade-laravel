<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Helper;

class DeviceToken extends Model
{
   protected $fillable = ['token','category','ip'];

    public static function updateToken($category) {
        $ip = Helper::getIp();
        $token_info = DeviceToken::where(['ip' => $ip])->first();
        if (!empty($token_info) && !strpos($token_info->category, $category, 0)){
            $category = $token_info->category.','.$category;
            $token_info->update(['category' => $category]);
        }
    }

    public function scopeHasCategory($query, $cat_id)
    {
        return $query->where('category', 'like', "%".','.$cat_id."%");
    }
}