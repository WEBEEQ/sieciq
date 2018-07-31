<?php declare(strict_types=1);

namespace Library\Sieciq;

use Library\Sieciq\{Config, Http};

class Order
{
    public static function addSite(object $auth, object $data): object
    {
        try {
            $response = Http::doPost(
                Config::getAddSitePathUrl(),
                $auth,
                $data
            );
        } catch (SieciqException $e) {
            echo $e->getMessage();
            exit;
        }

        return $response;
    }

    public static function updateSite(object $auth, object $data): object
    {
        try {
            $response = Http::doPut(
                Config::getUpdateSitePathUrl(),
                $auth,
                $data
            );
        } catch (SieciqException $e) {
            echo $e->getMessage();
            exit;
        }

        return $response;
    }

    public static function deleteSite(object $auth, object $data): object
    {
        try {
            $response = Http::doDelete(
                Config::getDeleteSitePathUrl(),
                $auth,
                $data
            );
        } catch (SieciqException $e) {
            echo $e->getMessage();
            exit;
        }

        return $response;
    }
}
