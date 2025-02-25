<?php

namespace App\Presentation\RestApi\Controllers;

use App\Application\Exceptions\UnauthorizedException;
use App\Application\Interfaces\EventLogsServiceInterface;
use App\Infrastructure\Database\UsersRepository;
use App\Presentation\RestApi\DTO\EventsLogPaginatedResponse;
use App\Presentation\RestApi\Mappers\EventLogFilterMapper;
use App\Presentation\RestApi\Requests\GetEventLogsRequest;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class EventLogController
{
    private EventLogsServiceInterface $service;

    public function __construct(EventLogsServiceInterface $service)
    {
        $this->service = $service;
    }

    public function index(GetEventLogsRequest $request): JsonResponse
    {
        // TODO: get from auth
        $user = (new UsersRepository())->getById(1);

        try {
            $paginatedEventLog = $this->service->getPaginatedEventLog(
                $user,
                $request->integer('page_size', 20),
                $request->integer('page', 1),
                EventLogFilterMapper::filterFromRequest($request)
            );

            return new JsonResponse(
                EventsLogPaginatedResponse::fromDTO($paginatedEventLog)
            );
        } catch (UnauthorizedException $e) {
            return new JsonResponse([
                'error' => 'Unauthorized',
            ], Response::HTTP_UNAUTHORIZED);
        } catch (\Throwable $e) {
            return new JsonResponse([
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
