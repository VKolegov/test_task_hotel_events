<?php

namespace App\Presentation\RestApi\Controllers;

use App\Application\Interfaces\UsersService;
use App\Presentation\RestApi\DTO\UserResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response as Response;

class UserController extends Controller
{

    public function __construct(
        private readonly UsersService $userService
    ) {
    }

    public function me(): JsonResponse
    {
        // get id from auth service (jwt?)

        $user = $this->userService->getById(1);

        if (!$user) {
            return new JsonResponse(
                null,
                Response::HTTP_NOT_FOUND
            );
        }

        return new JsonResponse(
            UserResponse::fromEntity($user),
            Response::HTTP_OK
        );
    }
}
