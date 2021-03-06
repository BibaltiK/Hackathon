<?php declare(strict_types=1);

namespace App\Handler;

use App\Model\Event;
use App\Service\UserService;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Fig\Http\Message\StatusCodeInterface as HTTP;

class EventListHandler implements RequestHandlerInterface
{
    public function __construct(
        private UserService $userService,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        /** @var array<Event> $events */
        $events = $request->getAttribute('events') ?? [];

        $data = [];

        foreach ($events as $event) {
            $entry = [
                'id' => $event->getId(),
                'owner' => $this->userService->findById($event->getUserId())->getName(),
                'name' => $event->getName(),
                'description' => $event->getDescription(),
                'duration' => $event->getDuration(),
                'startTime' => $event->getStartTime()->format('Y-m-d H:i'),
                'status' => $event->getStatus(),
            ];

            $data[] = $entry;
        }

        return new JsonResponse($data, HTTP::STATUS_OK);
    }
}
