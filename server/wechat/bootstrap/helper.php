<?php

function base_json($data = [], $message = '', $code = 0)
{
    return response()->json([
        'data' => $data,
        'message' => $message,
        'code' => $code
    ]);
}

function success_json($data = [], $message = '')
{
    if (is_string($data)) {
        $message = $data;
        $data = [];
    }
    return base_json($data, $message);
}

function error_json($message = '', $code = 1)
{
    return base_json([], $message, $code);
}

/**
 * 获取默认密码
 * @return string
 */
function default_password()
{
    return md5(config('password.value'));
}

function like($value) {
    return '%' . $value . '%';
}

function like_left($value) {
    return '%' . $value;
}

function like_right($value) {
    return $value . '%';
}

/**
 * 加载路由文件
 * @param $path
 */
function load_routes($path)
{
    foreach (glob($path . '/*') as $file) {
        if (is_dir($file)) {
            load_routes($file);
        } else if (strpos($file, '.php')) {
            require($file);
        }
    }
}

function form_date($date, $format='Y-m-d') {
    return date($format, strtotime($date));
}

function format_date($date, $format='Y-m-d') {
    return date($format, strtotime($date));
}


if (!function_exists('crypt_check')) {
    /**
     * 密码验证
     *
     * @param [type] $value     [description]
     * @param [type] $hashValue [description]
     *
     * @return [type] [description]
     */
    function crypt_check($value, $hashValue)
    {
        return \Hash::check($value, $hashValue);
    }
}


if (!function_exists('sys_log')) {
    /**
     * 记录日志.
     *
     * @param array  $params
     * @param string $action
     */
    function sys_log($params = [], $action = 'sys')
    {
        if (!isset($params['action'])) {
            $params['action'] = $action;
        }
        \App\Models\SysLog::log($params);
    }
}


if (!function_exists('is_mobile')) {
    /**
     * 查询是否手机号.
     *
     * @param [type] $mobile
     *
     * @return bool
     */
    function is_mobile($mobile)
    {
        // 大陆地区手机号
        if(preg_match('/^(0|86|17951)?1[0-9]{10}$/', $mobile)) {
            return true;
        }
        // 澳门手机号
        if (preg_match('/^\+?(853)?6[0-9]{7}$/', $mobile)) {
            return true;
        }
        // 台湾手机号
        if (preg_match('/^(886)?0[1-9][0-9]{8}$/', $mobile)) {
            return true;
        }
        // 香港手机号
        if (preg_match('/^\+?(852)?(6|9)[0-9]{7}$/', $mobile)) {
            return true;
        }
    }
}
