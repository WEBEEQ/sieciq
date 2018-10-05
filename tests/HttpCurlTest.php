<?php declare(strict_types=1);

use Library\Sieciq\{AddSite, Auth, HttpCurl};
use PHPUnit\Framework\TestCase;

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
    }

    /**
     * @expectedException Library\Sieciq\SieciqException
     */
    public function testThrowExceptionOnInvalidUrl(): void
    {
        $this->httpCurl->doRequest('POST', '', $this->auth, $this->addSite);
    }

    /**
     * @expectedException Library\Sieciq\SieciqException
     */
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
