<?php

namespace App\Http\Controllers;

use HuhSchool\User\Data\UserRepository;
use HuhSchool\User\Domain\UserService;

class DevController
{
    public function test()
    {
        $id = 1;
//        $userRepository = new UserRepository();
//        $user = $userRepository->getById($id);
//        $permission = [
//            "has_administration_rights" => true,
//            "has_onboarding_rights" => true,
//            "has_view_user_rights" => true
//        ];

        $userService = new UserService();
//        $userService->delete($id);
//        $user = $userService->updatePermission($user, $permission);
//        return $user;

        for ($i = 0; $i < 50; $i++) {
            $random = substr(hash('sha256', mt_rand()), 0, 6);
            $user = [
                "name" => $random,
                "email" => $random . "@" . $random . ".com"
            ];
            $userService->create($user);
        }
    }
}
