<?php

namespace App\Http\Controllers\Api;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Controllers\Api\ApiResponse;
use App\User;
use Illuminate\Http\Request;

/**
 * @SWG\Swagger(
 *   schemes={"https", "http"},
 *   basePath="",
 *   @SWG\Info(
 *      title="CORE API UI",
 *      version="0.1",
 *      description="<div><p>Error Code</p><ul><li>1004 : ERR_LOGIN_INVALID_CRENDENTIALS</li><li>1005 : ERR_LOGIN_EMAIL_NOT_EXISTED</li><li>1006 : ERR_LOGIN_EMAIL_NOT_VERIFIED</li><li>1007 : ERR_REFRESH_TOKEN_IS_EXPIRED</li><li>1008 : ERR_RECOVERY_CODE_INVALID</li><li>1009 : ERR_REQUIRE_VERIFY_2FA</li><li>1010 : ERR_2FA_CODE_INVALID</li><li>1011 : ERR_USER_WAS_BANNED</li><li>1012 : ERR_ADS_INVALID_AUTHENTICATE</li><li>1013 : ERR_ADS_ALREADY_SEEN</li><li>1014 : ERR_UPDATE_FAILED</li><li>1015 : ERR_CREATE_ACCOUNT</li><li>1016 : ERR_VNDC_REACH_LIMIT_CHANGE_PHONE_NUMBER</li><li>1017 : ERR_MOBILE_REQUIRE_UPDATE_VERSION</li><li>1018 : ERR_ICO_RATE_CHANGED</li><li>1019 : ERR_ICO_CREATE_ORDER_FAILED</li><li>1020 : ERR_ICO_REACH_LIMIT_REQUEST_PENDING_CHECKOUT</li><li>1021 : ERR_ADS_OUT_OF_BUDGET</li><li>404 : ERR_ITEM_NOT_FOUND',</li><li>403 : ERR_FORBIDDEN',</li></ul></div>"
 *   ),
 *   @SWG\SecurityScheme(
 *   securityDefinition="api_key",
 *   type="apiKey",
 *   in="header",
 *   name="Authorization"
 *  )
 * )
 */
class ApiBaseController extends BaseController
{
    const ERR_NOT_FOUND = 1001;
	const ERR_KYC_INVALID = 1002;
	const ERR_BAD_REQUEST_KYC = 1003;
	const ERR_BAD_REQUEST = 1000;
	const ERR_LOGIN_INVALID_CRENDENTIALS = 1004;
	const ERR_LOGIN_EMAIL_NOT_EXISTED = 1005;
	const ERR_LOGIN_EMAIL_NOT_VERIFIED = 1006;
	const ERR_REFRESH_TOKEN_IS_EXPIRED = 1007;
    const ERR_RECOVERY_CODE_INVALID = 1008;
    const ERR_REQUIRE_VERIFY_2FA = 1009;
    const ERR_2FA_CODE_INVALID = 1010;
    const ERR_USER_WAS_BANNED = 1011;
    const ERR_ADS_INVALID_AUTHENTICATE = 1012;
    const ERR_ADS_ALREADY_SEEN = 1013;
    const ERR_UPDATE_FAILED = 1014;
	const ERR_ITEM_NOT_FOUND = 404;
	const ERR_FORBIDDEN = 403;
	const ERR_CLIENT_BAD_REQUEST = 400;
	const ERR_CREATE_ACCOUNT = 1015;
	const ERR_VNDC_REACH_LIMIT_CHANGE_PHONE_NUMBER = 1016;
	const ERR_MOBILE_REQUIRE_UPDATE_VERSION = 1017;
	const ERR_ICO_RATE_CHANGED = 1018;
    const ERR_ICO_CREATE_ORDER_FAILED = 1019;
	const ERR_ICO_REACH_LIMIT_REQUEST_PENDING_CHECKOUT = 1020;
    const ERR_ADS_OUT_OF_BUDGET = 1021;
    const ERR_SERVER_UNDER_MAINTENANCE = 1022;
    const ERR_OLA_NOT_ENOUGH = 1023;
    const ERR_AUTH_SOCIAL_BACK_LOGIN = 2001;
    const ERR_ACCOUNT_WAS_BIND = 2002;
    const ERR_AUTH_SOCIAL_BACK_SIGNUP = 2003;
    const ERR_UNBINDING_ACCOUNT = 2004;
    const ERR_EMAIL = 2005;
    const ERR_UPDATE_EMAIL =2006;
    const ERR_ACCOUNT_WAS_BOUND_WITH_A_DIFFERENT_OLA_ACCOUNT = 2007;
    const ERR_SEND_EMAIL_VERIFY_MAX_ATTEMPT = 2008;
    const ERR_SEND_EMAIL_TIME_WAITING_SECONDS = 2009;
    const ERR_VERIFIED_EMAIL = 2010;
    
    const SUCCESS_CODE = 200;
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, ApiResponse;

    protected $locale;
    protected $currency;

    public function getUser($request){
    	$found = User::where(['access_token' => $request->header('Authorization')])->first();
    	if($found){
    		return $found;
    	}
    	return null;
    }
    public function __construct(Request $request){
        // set locale and currency when call api
        $locale = $request->header('Lang-Code');
        $this->locale = $locale ?? 'en';
        $this->currency = $request->header('Currency') ?? env('DEFAULT_CURRENCY', 'USD');

        // Set locale and currency if exist user
        if($user = auth('api')->user()){
            $this->locale = $locale ?? $user->lang_code;
            if($user->lang_code != $this->locale){
                $user->lang_code = $this->locale;
                $user->save();
            }
            $this->currency = $user->currency ?? $this->currency;
        }
        \App::setLocale($this->locale);

        $this->middleware('mobile.update');
    }
}
