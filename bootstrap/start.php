<?php
/**
 * Created by PhpStorm.
 * User: jifei
 * Date: 14/12/23
 * Time: 22:04
 */
$env = $app->detectEnvironment(function () {
    //    return gethostname() == 'prod.production.com' ? 'production' : 'local';
    return getenv('APP_ENV') ?: 'local';
});
