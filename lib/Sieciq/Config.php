<?php declare(strict_types=1);

namespace Library\Sieciq;

class Config
{
    protected $url = 'http://127.0.0.1:8000';
    protected $addSitePath = '/rest/add-site';
    protected $updateSitePath = '/rest/update-site';
    protected $deleteSitePath = '/rest/delete-site';

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
