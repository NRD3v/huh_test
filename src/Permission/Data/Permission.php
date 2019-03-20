<?php

namespace HuhSchool\Permission\Data;

use HuhSchool\User\Data\User;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = "permissions";
    protected $fillable = ["user_id", "has_administration_rights", "has_onboarding_rights", "has_view_user_rights"];
    protected $hidden = ['user_id', 'created_at', "updated_at"];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
