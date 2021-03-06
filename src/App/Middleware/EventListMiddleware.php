<?php declare(strict_types=1);

namespace App\Middleware;

use App\Service\EventService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class EventListMiddleware implements MiddlewareInterface
{
    public function __construct(
        private EventService $eventService
    ) {
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $params = $request->getQueryParams();

        if (!array_key_exists('order', $params)) {
            $events = $this->eventService->findAll();
        } else {
            $sort = match (strtoupper($params['sort'] ?? '')) {
                'DESC' => 'DESC',
                default => 'ASC',
            };

            $events = $this->eventService->findAll($params['order'], $sort);
        }

        return $handler->handle($request->withAttribute('events', $events));
    }
}
