<?php
/**
 * Created by PhpStorm.
 * User: jifei
 * Date: 14/12/23
 * Time: 22:04
 */
$env = $app->detectEnvironment(function()
{
    return getenv('APP_ENV') ?: 'local';
});