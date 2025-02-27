<?php

namespace App\Presentation\RestApi\Controllers;

use App\Application\Exceptions\UnauthorizedException;
use App\Application\Interfaces\UsersServiceInterface;
use App\Application\Services\AuthenticationService;
use App\Presentation\RestApi\DTO\UserResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class UserController extends Controller
{

    private AuthenticationService $authService;

    public function __construct(private readonly UsersServiceInterface $service)
    {
        $this->authService = new AuthenticationService();
    }

    public function me(): JsonResponse
    {
        // get from auth service (jwt?)
        $admin = $this->authService->getAdmin();

        $user = $this->service->getById($admin, 1);

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

    public function index(): JsonResponse
    {
        // get from auth service (jwt?)
        $admin = $this->authService->getAdmin();

        try {
            $users = $this->service->getAll($admin);

            return new JsonResponse(
                UserResponse::fromEntities($users),
                Response::HTTP_OK
            );
        } catch (UnauthorizedException $e) {
            return new JsonResponse(
                ['error' => 'Unauthorized'],
                Response::HTTP_UNAUTHORIZED
            );
        } catch (Throwable $exception) {
            return new JsonResponse([
                'error' => $exception->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
