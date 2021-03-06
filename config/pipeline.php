<?php

declare(strict_types=1);

use Administration\Middleware\FrontLoaderMiddleware;
use Administration\Middleware\UpdateLastUserActionTimeMiddleware;
use Authentication\Middleware\JwtAuthenticationMiddleware;
use Laminas\Stratigility\Middleware\ErrorHandler;
use Mezzio\Application;
use Mezzio\Handler\NotFoundHandler;
use Mezzio\Helper\BodyParams\BodyParamsMiddleware;
use Mezzio\Helper\ServerUrlMiddleware;
use Mezzio\Helper\UrlHelperMiddleware;
use Mezzio\Router\Middleware\DispatchMiddleware;
use Mezzio\Router\Middleware\ImplicitHeadMiddleware;
use Mezzio\Router\Middleware\ImplicitOptionsMiddleware;
use Mezzio\Router\Middleware\MethodNotAllowedMiddleware;
use Mezzio\Router\Middleware\RouteMiddleware;

return function (Application $app): void {
    $app->pipe(ErrorHandler::class);
    $app->pipe(ServerUrlMiddleware::class);
    $app->pipe(BodyParamsMiddleware::class);

    $app->pipe(JwtAuthenticationMiddleware::class);
    $app->pipe(UpdateLastUserActionTimeMiddleware::class);
    $app->pipe(RouteMiddleware::class);

    $app->pipe(ImplicitHeadMiddleware::class);
    $app->pipe(ImplicitOptionsMiddleware::class);
    $app->pipe(MethodNotAllowedMiddleware::class);

    $app->pipe(UrlHelperMiddleware::class);

    $app->pipe(FrontLoaderMiddleware::class);

    $app->pipe(DispatchMiddleware::class);

    $app->pipe(NotFoundHandler::class);
};
