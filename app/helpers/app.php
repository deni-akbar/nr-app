<?php

if (!function_exists('uppercase')) {
    function uppercase($text) {
        return strtoupper($text);
    }
}

if (!function_exists('jsonResponse')) {
    function jsonResponse($code,$msg='',$data) {

        if($code==200){
            $msg='Success';
        }elseif($code==500){
            $msg='Internal Server Errors';
        }
        
        return response()->json(['messages' => $msg,'status'=>$code,'data'=>$data], $code);
    }
}