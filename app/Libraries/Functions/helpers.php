<?php
/**
 * Created by PhpStorm.
 * User: jifei
 * Date: 14/12/28
 * Time: 16:38
 */

/***
 *
 * 检查手机号是否非法
 *
 * @param $mobile
 * @return int
 */
function checkMobile($mobile)
{
    return preg_match('/^1[3-8]\d{9}$/', trim($mobile));
}

function getIp()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}

function getFullURL()
{
    $pageURL = 'http';
    if (isset($_SERVER["HTTPS"]))
        if ($_SERVER["HTTPS"] == "on") {
            $pageURL .= "s";
        }
    $pageURL .= "://";
    if ($_SERVER["SERVER_PORT"] != "80") {
        $pageURL .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"];
    } else {
        $pageURL .= $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
    }
    return $pageURL;
}

function addTextColor($text, $color = 'black')
{
    return "<span style=\"color:{$color}\">$text</span>";
}
