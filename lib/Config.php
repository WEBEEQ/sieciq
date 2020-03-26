<?php

declare(strict_types=1);

namespace Webeeq\Sieciq;

class Config
{
    protected string $url = 'http://127.0.0.1:8000';
    protected string $addSitePath = '/api/add-site';
    protected string $updateSitePath = '/api/update-site';
    protected string $deleteSitePath = '/api/delete-site';

    public function getAddSitePathUrl(): string
    {
        return $this->url . $this->addSitePath;
    }

    public function getUpdateSitePathUrl(): string
    {
        return $this->url . $this->updateSitePath;
    }

    public function getDeleteSitePathUrl(): string
    {
        return $this->url . $this->deleteSitePath;
    }
}
