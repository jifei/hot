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

/**
 * 生成一个数字对应的字符
 *
 * @param string $num
 *
 * @return mixed
 */
function generate_char($num = '')
{
    if (!is_numeric($num) || $num < 0 || $num > 61) {
        $num = mt_rand(0, 61);
    }
    $num        = intval($num);
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    return $characters[$num];
}

/**
 * 生成指定长度的字符串
 *
 * @param int $length
 *
 * @return string
 */
function random_string($length = 10)
{
    $string = '';
    for ($i = 0; $i < $length; $i++) {
        $string .= generate_char();
    }

    return $string;
}

/**
 * 生成feed key
 * @return mixed
 */
function generate_feed_key()
{

    $key   = '';
    $times = explode(',', date('y,m,d,h,i,s'));
    foreach ($times as $v) {
        $key .= generate_char($v);
    }
    $rand_str = random_string(6);

    return substr_replace($rand_str, $key, 2, 0);
}