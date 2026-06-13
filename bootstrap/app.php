<?php

use App\Http\Middleware\CheckCourseOwnership;
use App\Http\Middleware\CheckCoursePermission;
use App\Http\Middleware\CheckExamOwnership;
use App\Http\Middleware\CheckRole;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Symfony\Component\HttpKernel\Exception\HttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware){ 
        $middleware->alias([
       'check.role'=>CheckRole::class,
       'check.course.ownership'=>CheckCourseOwnership::class,
       'check.course.permission' =>CheckCoursePermission::class,
       'check.exam.ownership' => CheckExamOwnership::class,
       'role' => \Spatie\Permission\Middleware\RoleMiddleware::class,
       'permission' => \Spatie\Permission\Middleware\PermissionMiddleware::class,
       'role_or_permission' => \Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class,
    ]);
})
    ->withExceptions(function (Exceptions $exceptions): void {

    $exceptions->render(function (
        UnauthorizedException $e,
        $request
    ) {

        return response()->json([
            'message' => 'ليس لديك صلاحية لتنفيذ هذا الإجراء ❌'
        ], 403);

    });

})->create();
