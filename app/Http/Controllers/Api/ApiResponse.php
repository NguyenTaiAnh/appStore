<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator as Paginator;
use Illuminate\Http\JsonResponse;

trait ApiResponse {

    /**
     * @var int
     */
    protected $statusCode = Response::HTTP_OK;

    /**
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @param $statusCode
     *
     * @return $this
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    /**
     * @param string $message
     *
     * @return mixed
     */
    public function respondNotFound($message = 'Not Found')
    {
        return $this->setStatusCode(Response::HTTP_NOT_FOUND)->respondWithError($message, 404);
    }

    /**
     * @param string $message
     *
     * @return mixed
     */
    public function respondBadRequest($message = 'Bad Request')
    {
        return $this->setStatusCode(Response::HTTP_BAD_REQUEST)->respondWithError($message, 400);
    }

    /**
     * @param string $message
     *
     * @return mixed
     */
    public function respondServerError($message = 'Server Error')
    {
        return $this->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR)->respondWithError($message, 500);
    }

    /**
     * @param string $message
     *
     * @return mixed
     */
    public function respondConflict($message = 'Conflict')
    {
        return $this->setStatusCode(Response::HTTP_CONFLICT)->respondWithError($message);
    }

    /**
     * @param string $message
     *
     * @return mixed
     */
    public function respondUnprocessable($message = 'Unprocessable Entity')
    {
        return $this->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY)->respondWithError($message);
    }

    /**
     * @param string $message
     *
     * @return mixed
     */
    public function respondUnauthorized($message = 'Unauthorized')
    {
        return $this->setStatusCode(Response::HTTP_UNAUTHORIZED)->respondWithError($message, 401);
    }

    /**
     * @param string $message
     *
     * @return mixed
     */
    public function respondForbidden($message = 'Forbidden')
    {
        return $this->setStatusCode(Response::HTTP_FORBIDDEN)->respondWithError($message, 403);
    }

    /**
     * @param array $data
     *
     * @return mixed
     */
    public function respondCreated($data = [])
    {
        return $this->setStatusCode(Response::HTTP_CREATED)->respond($data);
    }

    /**
     * @param $data
     * @param array $headers
     *
     * @return mixed
     */
    public function respond($data, $message = '', $headers = [])
    {
        if(isset($data['data']['data'])){
            $data['data']['items'] = $data['data']['data'];
            if(isset($data['data']['paginator'])){
                $data['data']['paginator'] = $data['data']['paginator'];
            }
            unset($data['data']['data']);
        }
        return response()->json($data, $this->getStatusCode(), $headers);
    }

    /**
     * @param $message
     *
     * @return mixed
     */
    public function respondWithSuccess($data, $message = '', $headers = [])
    {
        return $this->respond([
            'status' => true,
            'status_code' => Response::HTTP_OK,
            "message"=> $message,
            "data"=>$data
        ]);
    }

    /**
     * @param $message
     *
     * @return mixed
     */
    public function respondWithMessage($message, $status_code = '', $headers = [])
    {
        $status_code = $status_code ? $status_code : Response::HTTP_OK;
        return $this->respond([
            'status'=> true,
            "status_code"=> $status_code,
            "message"=> $message,
            "data"=>[]
        ]);
        return response()->json([ 'message' => $message], $this->getStatusCode(), $headers);
    }

    /**
     * @param $message
     *
     * @return mixed
     */
    public function respondWithErrorMessage($message, $status_code = '', $headers = [])
    {
        $transformed = [
            'field' => '',
            'message' => $message
        ];

        return response([
            'error' => $transformed,
            'code' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY
        ], Response::HTTP_OK);
    }

    /**
     * @param $message
     *
     * @return mixed
     */
    public function respondWithError($message, $status_code = 500)
    {
        return $this->respond([
            'status'=> false,
            "error_code"=> $status_code,
            "message"=> $message,
            "data"=>[]
        ]);
    }

    /**
     * @param Paginator $paginate
     * @param $data
     * @return mixed
     */
    protected function respondWithPagination($status_code, $paginate, $data, $dataOther = [], $message = ""){
        $message_response = !empty($message) ? $message : ApiMessages::messageSuccessCode($status_code);

        $paginator =  [
            'total_count'  => intval($paginate['total_count']),
            'total_pages' => intval($paginate['total_pages']),
            'current_page' => intval($paginate['current_page']),
            'limit' => intval($paginate['limit']),
        ];

        $response = [
            'status' => true,
            'status_code' => $status_code,
            'message' => $message_response,
            'data' => [
                'items' => $data,
                'paginator' => $paginator,
            ],
        ];

        if($dataOther){
            $response['data'] = array_merge($response['data'], $dataOther);
        }
        return response($response);
    }

    /**
     * @param $message
     *
     * @return mixed
     */
    public function respondWithErrorMessageCode($status_code, $message = '')
    {
        $message_response = !empty($message) ? $message : ApiMessages::messageErrorCode($status_code);
        $object = new \stdClass;
        return response([
            'status'=> false,
            "error_code"=> $status_code,
            "message"=> $message_response,
            "data"=> $object
        ]);
    }

    /**
     * @param $message
     *
     * @return mixed
     */
    public function respondWithErrorMessageData($status_code, $data = [], $message = '')
    {
        $message_response = !empty($message) ? $message : ApiMessages::messageErrorCode($status_code);
        $object = new \stdClass;
        return response([
            'status'=> false,
            "error_code"=> $status_code,
            "message"=> $message_response,
            "data"=> !empty($data) ? $data : $object
        ]);
    }

    /**
     * @param $message
     *
     * @return mixed
     */
    public function respondWithSuccessMessageCode($status_code, $data = [], $message = '')
    {
        $message_response = !empty($message) ? $message : ApiMessages::messageSuccessCode($status_code);
        $object = new \stdClass;
        return response([
            "status"=> true,
            "status_code"=> $status_code,
            "message"=> $message_response,
            "data"=> !empty($data) ? $data : $object
        ]);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondWithToken($token)
    {
        $message = ApiMessages::messageSuccessCode(Response::HTTP_OK);
        return response()->json([
            "status"=> true,
            "status_code"=> Response::HTTP_OK,
            "message"=> $message,
            "data"=>['access_token' => $token,'token_type' => 'Bearer','expires_in' => auth('api')->factory()->getTTL() * 60]
        ]);
    }

    /**
     * response with status code
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function respondWithStatusCode($message, $status_code = 500)
    {
        return response()->json(
        [
            "status"=> false,
            "error_code"=> $status_code,
            "message"=> $message,
            "data"=> []
        ], $status_code);
    }
}
