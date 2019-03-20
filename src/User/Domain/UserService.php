<?php

namespace HuhSchool\User\Domain;

use HuhSchool\User\Data\User;
use HuhSchool\User\Data\UserRepository;

class UserService
{
    public function create(array $data): User
    {
        $user = new User($data);
        $user->save();
        $user->permission()->create();

        $userRepository = new UserRepository();

        return $userRepository->getById($user->id);
    }

    public function update(int $userId, array $data): User
    {
        $user = new User();

        try {
            if ($userId && $data) {
                $userRepository = new UserRepository();
                $user = $userRepository->getById($userId);
                $user->update($data);
            }
        } catch (\Exception $e) {
            $e->getMessage();
        }

        return $user;
    }

    public function delete(int $userId): void
    {
        try {
            if ($userId) {
                $userRepository = new UserRepository();
                $user = $userRepository->getById($userId);
                if ($user->permission()) {
                    $user->permission()->delete();
                }
                $user->delete();
            }
        } catch (\Exception $e) {
            $e->getMessage();
        }
    }

    public function updatePermission(User $user, array $permission)
    {
        if ($user && $permission) {
            $user->permission()->update($permission);
        }

        return $user;
    }
}
