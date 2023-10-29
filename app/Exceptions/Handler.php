<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        // $this->renderable(function (Throwable $e) {
        //     return $this->handleException($e);
        // });
    }

    public function handleException( Throwable $e){
        if ($e instanceof HttpException) {
            $code = $e->getStatusCode();
            $defaultMessage = \Symfony\Component\HttpFoundation\Response::$statusTexts[$code];
            $message = $e->getMessage() == "" ? $defaultMessage : $e->getMessage();
            return $this->errorResponse($message, $code);
        } else if ($e instanceof ModelNotFoundException) {
            $model = strtolower(class_basename($e->getModel()));
            return $this->errorResponse("No existe ninguna instancia de {$model} con el ID proporcionado", Response::HTTP_NOT_FOUND);
        } else if ($e instanceof AuthorizationException) {
            return $this->errorResponse($e->getMessage(), Response::HTTP_FORBIDDEN);
        } else if ($e instanceof TokenBlacklistedException) {
            return $this->errorResponse($e->getMessage(), Response::HTTP_UNAUTHORIZED);
        } else if ($e instanceof AuthenticationException) {
            return $this->errorResponse($e->getMessage(), Response::HTTP_UNAUTHORIZED);
        } else if ($e instanceof ValidationException) {
            $errors = $e->validator->errors()->getMessages();
            return $this->errorResponse($errors, Response::HTTP_UNPROCESSABLE_ENTITY);
        } else {
            if (config('app.debug'))
                return $this->dataResponse($e->getMessage());
            else {
                return $this->errorResponse('Intenta más tarde', Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }

    /**
 * Data Response
 * @param $data
 * @return JsonResponse
 */
public function dataResponse($data): JsonResponse
{
    return response()->json(['content' => $data], Response::HTTP_OK);
}

/**
 * Success Response
 * @param string $message
 * @param int $code
 * @return JsonResponse
 */
public function successResponse(string $message, $code = Response::HTTP_OK): JsonResponse
{
    return response()->json(['success' => $message, 'code' => $code], $code);
}

/**
 * Error Response
 * @param $message
 * @param int $code
 * @return JsonResponse
 *
 */
public function errorResponse($message, $code = Response::HTTP_BAD_REQUEST): JsonResponse
{
    return response()->json(['error' => $message, 'code' => $code], $code);
}
}
