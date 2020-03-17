<?php

declare(strict_types=1);

namespace Webeeq\Sieciq;

use Webeeq\Sieciq\Http;

class Order extends Http
{
    protected $config;

    public function __construct(object $config)
    {
        $this->config = $config;
    }

    public function addSite(object $auth, object $data): object
    {
        try {
            $response = $this->doPost(
                $this->config->getAddSitePathUrl(),
                $auth,
                $data
            );
        } catch (SieciqException $e) {
            echo $e->getMessage();
            exit;
        }

        return $response;
    }

    public function updateSite(object $auth, object $data): object
    {
        try {
            $response = $this->doPut(
                $this->config->getUpdateSitePathUrl(),
                $auth,
                $data
            );
        } catch (SieciqException $e) {
            echo $e->getMessage();
            exit;
        }

        return $response;
    }

    public function deleteSite(object $auth, object $data): object
    {
        try {
            $response = $this->doDelete(
                $this->config->getDeleteSitePathUrl(),
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
