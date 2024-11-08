<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * Convert a resource response into an array.
     *
     * @param mixed $resource The resource to be converted.
     * @return array The resource data as an associative array.
     */
    function ResourceCollection($resource): array
    {
        return json_decode($resource->response()->getContent(), true) ?? [];
    }

    /**
     * Send a successful response with the given data and HTTP code.
     *
     * @param array $data The data to be sent.
     * @param string $message The message to be sent.
     * @param int $code The HTTP code to be sent.
     * @return \Illuminate\Http\Response
     */
    public static function sendResponse($data = [], $message = 'Success', $code = Response::HTTP_OK)
    {
        $response = [
            'code' => $code,
            'success' => true,
            'messages' => $message,
            'data' => $data,
        ];

        return response()->json($response, $code);
    }


    /**
     * Send an error response with the given message and HTTP code.
     *
     * @param string|array $message The error message to be sent.
     * @param int $code The HTTP code to be sent.
     * @return \Illuminate\Http\Response
     */
    public static function sendError($message, $code = Response::HTTP_BAD_REQUEST)
    {
        if (is_array($message)) {
            $message = implode(', ', $message);
        }

        $response = [
            'code' => $code,
            'success' => false,
            'message' => $message,
        ];

        return response()->json($response, $code);
    }
}
