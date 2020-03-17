<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Webeeq\Sieciq\{AddSite, Auth, HttpCurl, SieciqException};

class HttpCurlTest extends TestCase
{
    private $auth;
    private $addSite;
    private $httpCurl;

    public function setUp(): void
    {
        $this->auth = new Auth();
        $this->addSite = new AddSite();
        $this->httpCurl = new HttpCurl();

        $this->expectException(SieciqException::class);
    }

    public function testThrowExceptionOnInvalidUrl(): void
    {
        $this->httpCurl->doRequest('POST', '', $this->auth, $this->addSite);
    }

    public function testThrowExceptionOnInvalidResponse(): void
    {
        $this->httpCurl->doRequest(
            'POST',
            'https://sieciq.eeq/rest/add-site',
            $this->auth,
            $this->addSite
        );
    }
}
