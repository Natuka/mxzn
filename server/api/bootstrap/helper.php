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
