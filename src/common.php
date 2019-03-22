<?php

function success($text)
{
    header('Content-type: application/json; charset=UTF-8');
    $result = [
        'status' => 'success',
        'text' => $text,
    ];
    exit(json_encode($result));
}

function error($msg)
{
    header('Content-type: application/json; charset=UTF-8');
    $result = [
        'status' => 'error',
        'msg' => $msg,
    ];
    exit(json_encode($result));
}
