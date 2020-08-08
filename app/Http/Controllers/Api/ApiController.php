<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    /**
     * @var int
     */
    protected $statusCode = 200;

    /**
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param mixed $statusCode
     *
     * @return ApiController
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * @param $data
     * @param array $headers
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function respond($data, $headers = [])
    {
        return response()->json($data, $this->getStatusCode(), $headers);
    }

    /**
     * @param $title
     * @param $detail
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondWithError($title, $detail)
    {
        return $this->respond([
            'error'      => [
                'code' => $this->getStatusCode(),
                'title'  => $title,
                'detail' => $detail,
            ],
        ]);
    }

    /**
     * @param string $title
     * @param string $detail
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondNotFound($detail = 'The requested resource does not exist.', $title = 'Not Found')
    {
        return $this->setStatusCode(404)->respondWithError($title, $detail);
    }

    /**
     * @param string $title
     * @param string $detail
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondUnprocessed(
        $detail = 'The request was not processed due to semantic errors.',
        $title = 'Unprocessable Entity'
    ) {
        return $this->setStatusCode(422)->respondWithError($title, $detail);
    }

    /**
     * @param $title
     * @param $detail
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondOk($detail, $title = 'Success')
    {
        return $this->respond([
            'data' => [
                'code' => $this->getStatusCode(),
                'title'  => $title,
                'detail' => $detail,
            ],
        ]);
    }

    /**
     * @param $data
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondCreated($data)
    {
        return $this->setStatusCode(201)->respond(['data' => $data]);
    }

    /**
     * @param $data
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondTokenError($data)
    {
        return $this->setStatusCode(401)
            ->respondWithError(ucfirst(str_replace('_', ' ', $data['error'])), $data['message']);
    }


    public function sendResponse($result, $message){
        $response = [
            'success'=>true,
            'data' => $result,
            'message'=> $message,
        ];

        return response()->json($response, 200);
    }
    
    public function sendError($error, $errorMessages= [], $code = 404){
        $response = [
            'success'=>false,
            'message'=>$error,
        ];
        if(!empty($errorMessages)){
            $response['data']=$errorMessages;
        }
        return response()->json($response, $code);
    }
}
