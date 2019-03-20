<?php

namespace HuhSchool\User\Data;

use Illuminate\Database\Eloquent\Collection;

class UserRepository
{
    public function list(): Collection
    {
        return User::with("permission")->get();
    }

    public function getById(int $id): User
    {
        return User::with("permission")->where("id", $id)->firstOrFail();
    }
}
