<?php

namespace App\Helpers;

use Illuminate\Http\Response;

class GeneralHelper
{
    public static function currency($total)
    {
        return 'Rp.' . number_format($total, 0, '', '.');
    }

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
