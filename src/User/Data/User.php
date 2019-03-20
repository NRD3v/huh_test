<?php

namespace HuhSchool\User\Data;

use HuhSchool\Permission\Data\Permission;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = "users";
    protected $fillable = ["name", "email", "password", "email_verified_at", "remember_token"];
    protected $hidden = ["email_verified_at", "remember_token", 'created_at', "updated_at"];

    public function permission()
    {
        return $this->hasOne(Permission::class);
    }
}
