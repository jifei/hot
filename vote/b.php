<?php

/**
 * Created by PhpStorm.
 * User: jifei
 * Date: 15/4/16
 * Time: 20:20
 */
class curl
{
    public $requestUrl = 'http://hs.dazigui.com/app/index.php?i=3&c=entry&id=370&do=home&m=wenzi_kepianshare&wxref=mp.weixin.qq.com';
    //public $requestUrl = 'http://api2.shangyt.cn/chat';
    public $ch = null;
    public $timeout = 10;

    public function __construct()
    {
        $this->ch  = curl_init();
        $header    = array();
        $header [] = 'Host:hs.dazigui.com';
        $header [] = 'Origin:http://hs.dazigui.com';
        $header [] = 'Connection: keep-alive';
        $header [] = 'User-Agent: Mozilla/5.0 (X11; Linux i686) AppleWebKit/535.1 (KHTML, like Gecko) Chrome/14.0.835.186 Safari/535.1';
        $header [] = 'Accept:*/*';
        $header [] = 'Accept-Language: zh-CN,zh;q=0.8';
        $header [] = 'Content-Length:397';
        $header [] = 'Accept-Charset: GBK,utf-8;q=0.7,*;q=0.3';
        $header [] = 'Cache-Control:max-age=0';
        $header [] = 'Cookie:01fb_PHPSESSID=3-pP3SY6z033907gsZp0s0; PHPSESSID=3-pP3SY6z033907gsZp0s0';
        $header [] = 'Content-Type:application/x-www-form-urlencoded';
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($this->ch, CURLOPT_URL, $this->requestUrl);
        curl_setopt($this->ch, CURLOPT_REFERER, $this->requestUrl);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->ch, CURLOPT_CONNECTTIMEOUT, $this->timeout);
        // curl_setopt($this->ch, CURLOPT_PROXYAUTH, CURLAUTH_BASIC); //代理认证模式
        //curl_setopt($this->ch, CURLOPT_PROXYTYPE, CURLPROXY_HTTP); //使用http代理模式
        curl_setopt($this->ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.118 Safari/537.36'); //使用http代理模式
        //curl_setopt($this->ch, CURLOPT_CON, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_3) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/41.0.2272.118 Safari/537.36'); //使用http代理模式

    }

    public function get($ip, $port)
    {
        curl_setopt($this->ch, CURLOPT_PROXY, '183.203.8.148'); //代理服务器地址
        curl_setopt($this->ch, CURLOPT_PROXYPORT, 8080); //代理服务器端口
        echo $file_contents = curl_exec($this->ch);
        echo $code = curl_getinfo($this->ch, CURLINFO_HTTP_CODE); //我知道HTT
    }

    public function post($ip, $port)
    {
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, ['vote_con'=>'A.才子佳人，欧巴女神~~','activeid'=>'370']);
        curl_setopt($this->ch, CURLOPT_POST, true);
       // curl_setopt($this->ch, CURLOPT_PROXY, '58.22.0.53'); //代理服务器地址
       // curl_setopt($this->ch, CURLOPT_COOKIE, '01fb_PHPSESSID=3-pP3SY6z033907gsZp0s0; PHPSESSID=3-pP3SY6z033907gsZp0s0'); //代理服务器地址
       // curl_setopt($this->ch, CURLOPT_PROXYPORT, 80); //代理服务器端口
        echo $file_contents = curl_exec($this->ch);
        echo $code = curl_getinfo($this->ch, CURLINFO_HTTP_CODE); //我知道HTTPSTAT码哦～
echo $this->requestUrl;
        //if($code==200){
        //}
        exit;

        return $file_contents;
        //curl_close($this->ch);
    }

//curl_setopt($ch, CURLOPT_PROXYUSERPWD, ":"); //http代理认证帐号，username:password的格式

}

require('phpQuery/phpQuery.php');
phpQuery::newDocumentFile('http://www.xici.net.co/nn/4');
$trs  = pq("#ip_list tr");
$curl = new curl();
foreach ($trs as $k => $tr) {
    $ip   = pq($tr)->find("td:eq(2)")->text();
    $port = pq($tr)->find("td:eq(3)")->text();
    if ($ip && $port) {
        echo $curl->post($ip, $port);
        exit;
        sleep(5);
    }
}
