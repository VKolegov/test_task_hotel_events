<?php

namespace App\Presentation\RestApi\Controllers;

use App\Application\Interfaces\UsersServiceInterface;
use App\Presentation\RestApi\DTO\UserResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{

    private UsersServiceInterface $service;

    public function __construct(UsersServiceInterface $userService) {
        $this->service = $userService;
    }

    public function me(): JsonResponse
    {
        // get from auth service (jwt?)

        $user = $this->service->getById(1);

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
