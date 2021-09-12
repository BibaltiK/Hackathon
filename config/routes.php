<?php declare(strict_types=1);

return static function (Mezzio\Application $app): void {
    $app->get(
        '/',
        [
            App\Handler\IndexHandler::class,
        ],
        App\Handler\IndexHandler::class
    );
    $app->get(
        '/login',
        [
            Mezzio\Flash\FlashMessageMiddleware::class,
            Authentication\Handler\LoginHandler::class,
        ],
        Authentication\Handler\LoginHandler::class
    );
    $app->post(
        '/login',
        [
            Mezzio\Flash\FlashMessageMiddleware::class,
            Authentication\Middleware\LoginAuthenticationMiddleware::class,
            Authentication\Handler\LoginHandler::class,
        ],
        Authentication\Middleware\LoginAuthenticationMiddleware::class
    );

    $app->get(
        '/logout',
        [
            Mezzio\Flash\FlashMessageMiddleware::class,
            Authentication\Handler\LogoutHandler::class,
        ],
        Authentication\Handler\LogoutHandler::class
    );

    $app->get(
        '/api/ping',
        [
            App\Handler\PingHandler::class,
        ],
        App\Handler\PingHandler::class
    );
};