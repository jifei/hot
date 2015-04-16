<?php
/**
 * Created by PhpStorm.
 * User: jifei
 * Date: 15/4/16
 * Time: 20:00
 */
require('phpQuery/phpQuery.php');
phpQuery::newDocumentFile('http://www.xici.net.co/nn/1');
echo 1112313;exit;
echo $trs =pq("#ip_list")->find("tr");exit;

foreach($trs as $tr){
   echo $tr->find("td:eq(2)")->text();
}