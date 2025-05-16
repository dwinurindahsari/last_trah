<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Foundation\Configuration\Exceptions;
use Spatie\Permission\Middlewares\RoleMiddleware;
use Spatie\Permission\Middlewares\PermissionMiddleware;
use Spatie\Permission\Middlewares\RoleOrPermissionMiddleware;

return Application::configure(basePath: dirname(__DIR__))
  ->withRouting(
    web: __DIR__.'/../routes/web.php',
    commands: __DIR__.'/../routes/console.php',
    health: '/up',
  )
  ->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
      'role' => 'Spatie\Permission\Middleware\RoleMiddleware',
      'permission' => 'Spatie\Permission\Middleware\PermissionMiddleware',
      'role_or_permission' => 'Spatie\Permission\Middleware\RoleOrPermissionMiddleware',
    ]);
  })
  ->withExceptions(function (Exceptions $exceptions) {
    //
  })->create();
 
