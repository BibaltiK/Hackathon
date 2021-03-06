<?php declare(strict_types=1);

namespace App\Service;

use App\Hydrator\ReflectionHydrator;
use App\Table\UserTable;
use Laminas\Hydrator\Strategy\NullableStrategy;
use Psr\Container\ContainerInterface;

class UserServiceFactoryTest extends AbstractServiceTest
{
    public function testCanCreateUserService(): void
    {
        $userTable = $this->createMock(UserTable::class);
        $strategy = $this->createMock(NullableStrategy::class);
        $container = $this->createMock(ContainerInterface::class);

        $container->expects($this->exactly(3))
            ->method('get')->will(
                $this->returnValueMap(
                    [
                        [UserTable::class, $userTable],
                        [ReflectionHydrator::class, $this->hydrator],
                        [NullableStrategy::class, $strategy],
                    ],
                )
            );

        $userServiceFactory = new UserServiceFactory();
        $userService = $userServiceFactory($container);

        $this->assertInstanceOf(UserService::class, $userService);
    }
}
