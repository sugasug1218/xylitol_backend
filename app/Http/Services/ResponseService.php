<?php

namespace App\Http\Services;

use RuntimeException;
use App\Enums\ResponseType;

class ResponseService
{
    /**
     * エラーメッセージの取得
     *
     * @param int $code
     * @return string
     */
    public function getErrorMessage($code)
    {
        return ResponseType::ERROR_DITAIL[$code];
    }

    /**
     * 成功時のレスポンス(データ無し)
     * @return json
     *
     */
    public function successResponse()
    {
        return response()->json([
            'result' => ResponseType::NO_ERROR,
            'message' => $this->getErrorMessage(ResponseType::NO_ERROR),
        ], ResponseType::SUCCESS);
    }

    /**
     * 成功時のレスポンス(データあり)
     * @param array $data
     * @return json
     *
     */
    public function successResponseData($data)
    {
        return response()->json([
            'result' => ResponseType::NO_ERROR,
            'message' => $this->getErrorMessage(ResponseType::NO_ERROR),
            'data' => [
                $data
            ]
        ], ResponseType::SUCCESS);
    }
    
    /**
     * 認証エラーレスポンス
     *
     */
    public function AuthenticationExceptionResponse()
    {
        return response()->json([
            'status' => ResponseType::AUTH_ERROR,
            'message' => $this->getErrorMessage(ResponseType::AUTH_ERROR)
        ], ResponseType::UNAUTH);
    }

    /**
     * トークン認証エラー
     * @return json
     *
     */
    public function tokenAuthExceptionResponse()
    {
        return response()->json([
            'status' => ResponseType::TOKEN_AUTH_ERROR,
            'message' => $this->getErrorMessage(ResponseType::TOKEN_AUTH_ERROR)
        ], ResponseType::UNAUTH);
    }

    /**
     * エラーレスポンス
     *
     * @param RuntimeException $e
     * @return void
     */
    public function runtimeExceptionResponse(RuntimeException $e)
    {
        return response()->json([
            'result' => $e->getCode(),
            'message' => $e->getMessage()
        ], ResponseType::BADREQUEST);
    }

    /**
     * DB関連のエラーレスポンス
     * @return void
     */
    public function pdoExceptionResponse()
    {
        return response()->json([
            'status' => ResponseType::DB_ERROR,
            'message' => $this->getErrorMessage(ResponseType::DB_ERROR),
        ], ResponseType::BADREQUEST);
    }

    /**
     * 未定義のエラーレスポンス
     * @return void
     */
    public function unknownExceptionResponse()
    {
        return response()->json([
            'status' => ResponseType::UNKNOWN_ERROR,
            'message' => $this->getErrorMessage(ResponseType::UNKNOWN_ERROR),
        ], ResponseType::BADREQUEST);
    }
}
