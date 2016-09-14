<?php

return [
    'dependencies' => [
        'invokables' => [
            Zend\Expressive\Router\RouterInterface::class => Zend\Expressive\Router\FastRouteRouter::class,
            App\Action\PingAction::class => App\Action\PingAction::class,
        ],
        'factories' => [
            App\Action\HomePageAction::class => App\Action\HomePageFactory::class,
            App\Action\PageAction::class => App\Action\PageFactory::class,
            App\Action\UserListAction::class => App\Action\UserListFactory::class,
            App\Action\UserDbalListAction::class => App\Action\UserDbalListFactory::class,
        ],
    ],
];
