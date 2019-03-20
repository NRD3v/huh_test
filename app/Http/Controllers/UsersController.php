<?php

namespace App\Http\Controllers;

use App\Http\Responses\SuccessResponse;
use HuhSchool\User\Data\User;
use HuhSchool\User\Data\UserRepository;
use HuhSchool\User\Domain\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function list(): JsonResponse
    {
        $userRepository = new UserRepository();
        $list = $userRepository->list();

        return response()->json(SuccessResponse::send($list));
    }

    public function getById(Request $request, $id): JsonResponse
    {
        $userRepository = new UserRepository();
        $get = $userRepository->getById($id);

        return response()->json(SuccessResponse::send($get));
    }

    public function store(Request $request): User
    {
        $userService = new UserService();
        $user = $userService->create($request->input('profile'));
        return $user;
    }

    public function update(Request $request, $id): User
    {
        $userService = new UserService();
        $user = $userService->update($id, $request->input('profile'));

        return $user;
    }

    public function updatePermission(Request $request, $id): User
    {
        $user = new User();
        $permission = $request->permission;

        if ($permission) {
            $userRepository = new UserRepository();
            $user = $userRepository->getById($id);

            $userService = new UserService();
            $user = $userService->updatePermission($user, $permission);
        }

        return $user;
    }

    public function delete(Request $request, $id): void
    {
        $userService = new UserService();

        $userService->delete($id);
    }
}
