<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;
use InfyOm\Generator\Utils\ResponseUtil;

/**
 * @OA\Server(url="/api/v1")
 * @OA\Info(
 *   title="Kisara APIs",
 *   version="1.0.0"
 * )
 * This class should be parent class for other API controllers
 * Class AppBaseController
 */
class AppBaseController extends Controller
{
    /**
     * @param $result
     * @param string $message
     * @param int $code
     * @return JsonResponse
     */
    public function sendResponse($result, string $message, int $code = 200): JsonResponse
    {
        return Response::json(ResponseUtil::makeResponse($message, $result), $code);
    }

    /**
     * @param $error
     * @param int $code
     * @return JsonResponse
     */
    public function sendError($error, int $code = 404): JsonResponse
    {
        return response()->json(ResponseUtil::makeError($error), $code);
    }

    /**
     * @param $message
     * @return JsonResponse
     */
    public function sendSuccess($message): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message
        ], 200);
    }
}
