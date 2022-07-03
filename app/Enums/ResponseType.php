<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class ResponseType extends Enum
{
    /** HTTPステータス */
    const SUCCESS = 200;
    const BADREQUEST = 400;
    const UNAUTH = 401; // 未認証

    /** エラーコードとメッセージ */
    const NO_ERROR = 0;
    const PARAM_ERROR = 1;
    const DB_ERROR = 2;
    const EXISTS_ERROR = 3;
    const AUTH_ERROR = 4;
    const TOKEN_AUTH_ERROR = 5;
    const UNKNOWN_ERROR = 9;

    const ERROR_DITAIL = [
        self::NO_ERROR => '正常終了',
        self::PARAM_ERROR => 'パラメータエラー',
        self::DB_ERROR => 'データベース関連のエラー',
        self::EXISTS_ERROR => '存在しないid',
        self::AUTH_ERROR => '認証エラー',
        self::TOKEN_AUTH_ERROR => 'トークン認証エラー',
        self::UNKNOWN_ERROR => '未定義のエラー'
    ];

    /**
     * エラー取得
     * @param int $code
     * @return string
     *
     */
    public static function getErrorMessage($code)
    {
        return ResponseType::ERROR_DITAIL[$code];
    }
}
