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
    foreach (glob($path . '/*.php') as $file) {
        if (is_dir($file)) {
            loadRouter($file);
        } else {
            require($file);
        }
    }
}
