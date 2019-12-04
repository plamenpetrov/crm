<?php

namespace App\Services\Response;

class ResponseApi {

    public function respond($data, $statusCode, $message = null, $headers = []) {
        return \Response::json([
                    'data' => $data,
                    'status_code' => $statusCode,
//                    'translations' => $translations,
                    'message' => $message,
                        ], 200, $headers);
    }

}
