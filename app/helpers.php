<?php


function returnJSON($msg = "", $data = [], $code = 200, $headers = [])
{
    $response = response()->json(["code" => $code, "data" => $data, "msg" => $msg], 200);
    return $response->withHeaders([]);
}
