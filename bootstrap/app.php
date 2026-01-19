<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Forçar JSON només si la petició és explícitament a l'API
        $exceptions->shouldRenderJsonWhen(fn (Request $request) => $request->is('api/*'));

        $exceptions->render(function (\Illuminate\Validation\ValidationException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'message' => 'Dades no vàlides.',
                    'errors' => $e->errors(),
                ], 422);
            }
        });

        // AQUI ESTAVA EL PROBLEMA:
        $exceptions->render(function (\Illuminate\Auth\AuthenticationException $e, Request $request) {
            // Afegim el condicional: Només tornar JSON si estem a l'API
            if ($request->is('api/*')) {
                return response()->json(['message' => 'No autenticat.'], 401);
            }
            // Si no és API, no retornem res aquí i Laravel farà la redirecció automàtica al Login
        });

        $exceptions->render(function (\Illuminate\Database\Eloquent\ModelNotFoundException|\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json(['message' => 'Recurs o ruta no trobada.'], 404);
            }
        });

        $exceptions->render(function (\Throwable $e, Request $request) {
            if ($request->is('api/*')) {
                return response()->json(['message' => 'Error del servidor.'], 500);
            }
        });
    })->create();