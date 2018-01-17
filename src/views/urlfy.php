<?php
/**
 * Created by PhpStorm.
 * User: njerucyrus
 * Date: 1/16/18
 * Time: 12:30 PM
 */
function createUrlParams($data)
{
    $params = '';
    if (is_array($data)) {

        foreach ($data as $key => $value) {
            $params .= "{$key}={$value}&";
        }


        $params = rtrim($params, '&');
    }
    return $params;
}
