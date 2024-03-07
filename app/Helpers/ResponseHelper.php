<?php

namespace App\Helpers;

use Illuminate\Http\Response;

class ResponseHelper
{
    public static function success($data = [], $message = 'Success', $code = Response::HTTP_OK)
    {
        return response()->json([
            'code' => $code,
            'success' => true,
            'messages' => $message,
            'data' => $data,
        ]);
    }

    public static function error($message = 'Error', $code = Response::HTTP_BAD_REQUEST)
    {
        return response()->json([
            'code' => $code,
            'success' => false,
            'messages' => $message,
        ]);
    }

    public static function currency($total)
    {
        return 'Rp.' . number_format($total, 0, '', '.');
    }
}
