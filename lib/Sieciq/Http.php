<?php declare(strict_types=1);

namespace Library\Sieciq;

use Library\Sieciq\HttpCurl;

class Http
{
    public static function doGet(
        string $pathUrl,
        object $auth
    ): object {
        $response = HttpCurl::doRequest('GET', $pathUrl, $auth);

        return $response;
    }

    public static function doPost(
        string $pathUrl,
        object $auth,
        object $data
    ): object {
        $response = HttpCurl::doRequest('POST', $pathUrl, $auth, $data);

        return $response;
    }

    public static function doPut(
        string $pathUrl,
        object $auth,
        object $data
    ): object {
        $response = HttpCurl::doRequest('PUT', $pathUrl, $auth, $data);

        return $response;
    }

    public static function doDelete(
        string $pathUrl,
        object $auth,
        object $data
    ): object {
        $response = HttpCurl::doRequest('DELETE', $pathUrl, $auth, $data);

        return $response;
    }
}
