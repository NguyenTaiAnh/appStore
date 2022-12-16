<?php

namespace App\Http\Controllers\Api;
class ApiMessages
{
    private static $statusErrorText = [
        '1000'=>'ERR_BAD_REQUEST',
        '1001'=>'ERR_NOT_FOUND',
        '1002'=>'ERR_KYC_INVALID',
        '1003'=>'ERR_BAD_REQUEST_KYC',
        '1004'=>'ERR_LOGIN_INVALID_CRENDENTIALS',
        '1005'=>'ERR_LOGIN_EMAIL_NOT_EXISTED',
        '1006'=>'ERR_LOGIN_EMAIL_NOT_VERIFIED',
        '1007' => 'ERR_REFRESH_TOKEN_IS_EXPIRED',
        '1008' => 'ERR_RECOVERY_CODE_INVALID',
        '1009'=>'ERR_REQUIRE_VERIFY_2FA',
        '1010' => 'ERR_2FA_CODE_INVALID',
        '1011' => 'ERR_USER_WAS_BANNED',
        '1012' => 'ERR_ADS_INVALID_AUTHENTICATE',
        '1013' => 'ERR_ADS_ALREADY_SEEN',
        '1014' => 'ERR_UPDATE_FAILED',
        '1015' => 'ERR_CREATE_ACCOUNT',
        '1016' => 'ERR_VNDC_REACH_LIMIT_CHANGE_PHONE_NUMBER',
        '1017' => 'ERR_MOBILE_REQUIRE_UPDATE_VERSION',
        '1018' => 'ERR_ICO_RATE_CHANGED',
        '1019' => 'ERR_ICO_CREATE_ORDER_FAILED',
        '1020' => 'ERR_ICO_REACH_LIMIT_REQUEST_PENDING_CHECKOUT',
        '1021' => 'ERR_ADS_OUT_OF_BUDGET',
        '1022' => 'ERR_SERVER_UNDER_MAINTENANCE',
        '1023' => 'ERR_OLA_NOT_ENOUGH',
        '404'=>'ERR_ITEM_NOT_FOUND',
        '403'=>'ERR_FORBIDDEN',
        '400'=>'ERR_CLIENT_BAD_REQUEST',
        '2001' => 'ERR_AUTH_SOCIAL_BACK_LOGIN',
        '2002' => 'ERR_ACCOUNT_WAS_BIND',
        '2003' => 'ERR_AUTH_SOCIAL_BACK_SIGNUP',
        '2004' => 'ERR_UNBINDING_ACCOUNT',
        '2005' => 'ERR_UNBINDING_ACCOUNT',
        '2006' => 'ERR_UPDATE_EMAIL',
        '2007' => 'ERR_ACCOUNT_WAS_BOUND_WITH_A_DIFFERENT_OLA_ACCOUNT',
        '2008' => 'ERR_SEND_EMAIL_VERIFY_MAX_ATTEMPT',
        '2009' => 'ERR_SEND_EMAIL_TIME_WAITING_SECONDS',
        '2010' => 'ERR_VERIFIED_EMAIL',
    ];

    private static $statusSuccessText = [
        '200'=>'SUCCESS'
    ];

    public static function messageErrorCode($code){
        return self::$statusErrorText[$code];
    }

    public static function messageSuccessCode($code){
        return self::$statusSuccessText[$code];
    }
}
