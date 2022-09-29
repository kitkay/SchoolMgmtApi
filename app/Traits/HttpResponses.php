<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

trait HttpResponses
{
    /**
     * Success HTTP Response
     *
     * @param array $data
     * @param string $messsage
     * @param int $code
     *
     * @return JsonResponse
     */
    public static function success(
        $data,
        $messsage = null,
        $code = 200
    ): JsonResponse {
        return response()->json(
            [
                'status' => 'Request was successful.',
                'statusCode' => $code,
                'message' => $messsage,
                'data' => $data
            ],
            $code
        );
    }

    /**
     * General Error HTTP Response
     *
     * @param array $data
     * @param string $messsage
     * @param int $code
     *
     * @return void
     */
    protected static function error(
        $data,
        $messsage = null,
        $code
    ) {
        return response()->json(
            [
                'status' => 'Error has occurred.',
                'message' => $messsage,
                'data' => $data
            ],
            $code
        );
    }

    /**
     * Not found exception
     *
     * @param array $data
     * @param string $status
     * @param string $messsage
     * @param int $code
     *
     * @return void
     */
    protected static function modelNotFound(
        $data,
        $status,
        $messsage = null,
        $code = 404
    ) {
        return response()->json(
            [
                'status' => $status,
                'message' => $messsage,
                'data' => $data
            ],
            $code
        );
    }

    /**
     * Server Failed Response
     *
     * @param array $data
     * @param string $status
     * @param string $messsage
     * @param int $code
     *
     * @return JsonResponse
     */
    protected static function serverFailed(
        $data,
        $status,
        $messsage = null,
        $code = 500
    ): JsonResponse {
        return response()->json(
            [
                'status' => $status,
                'message' => $messsage,
                'data' => $data
            ],
            $code
        );
    }
}
