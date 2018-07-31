<?php declare(strict_types=1);

namespace Library\Sieciq;

class Config
{
    protected static $url = 'http://127.0.0.1:8000';
    protected static $addSitePath = '/rest/add-site';
    protected static $updateSitePath = '/rest/update-site';
    protected static $deleteSitePath = '/rest/delete-site';

    public static function getAddSitePathUrl(): string
    {
        return self::$url . self::$addSitePath;
    }

    public static function getUpdateSitePathUrl(): string
    {
        return self::$url . self::$updateSitePath;
    }

    public static function getDeleteSitePathUrl(): string
    {
        return self::$url . self::$deleteSitePath;
    }
}
