<?php

namespace App\Traits;

use Illuminate\Http\Response;

trait ApiResponser{
    /**
     * Build success response
     * @param $data
     * @param int $code
     * @return \Illuminate\Http\JsonResponse|Response|\Laravel\Lumen\Http\ResponseFactory
     */
    public function successResponse($data, $code = Response::HTTP_OK){
        //because of the data already in json format and ready we add the header
        return response($data, $code)->header('content-type', 'application/json');
    }

    /**
     * Build error response
     * @param $message
     * @param $code
     * @return \Illuminate\Http\JsonResponse
     */
    public function errorResponse($message, $code){
        return response()->json(['error' => $message, 'code' => $code], $code);
    }
    /**
     * Build error response
     * @param $message
     * @param $code
     * @return \Illuminate\Http\JsonResponse|Response|\Laravel\Lumen\Http\ResponseFactory
     */
    public function errorMessage($message, $code){
        //because of the data already in json format and ready we add the header
        return response($message,$code)->header('content-type', 'application/json');
    }
}
