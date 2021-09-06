<?php

declare(strict_types=1);

use App\Application\Services\CurrentUserService;
use DI\Container;

return function (Container $container)
{
    $container->set('currentUserService', function() {
        return new CurrentUserService();
    });
};