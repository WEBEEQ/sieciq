<?php declare(strict_types=1);

use Library\Sieciq\{AddSite, Auth, Config, DeleteSite, Order, UpdateSite};
use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase
{
    private $auth;
    private $addSite;
    private $updateSite;
    private $deleteSite;
    private $config;
    private $order;

    public function setUp(): void
    {
        $this->auth = new Auth();
        $this->auth->user = 'user';
        $this->auth->password = '!@#$%^&*()';

        $this->addSite = new AddSite();
        $this->addSite->name = 'Nasz Fach';
        $this->addSite->url = 'http://www.naszfach.pl';

        $this->updateSite = new UpdateSite();
        $this->updateSite->id = 7;
        $this->updateSite->name = 'Fachowcy';
        $this->updateSite->visible = true;

        $this->deleteSite = new DeleteSite();
        $this->deleteSite->id = 7;

        $this->config = new Config();
        $this->order = new Order($this->config);
    }

    public function testAddSiteAndGetResponse(): void
    {
        $expectedCode = 200;
        $expectedType = 'string';
        $response = $this->order->addSite($this->auth, $this->addSite);

        $this->assertEquals($expectedCode, $response->code);
        $this->assertTrue($response->response->success);
        $this->assertInternalType($expectedType, $response->response->message);
    }

    public function testUpdateSiteAndGetResponse(): void
    {
        $expectedCode = 200;
        $expectedSuccess = [true, false];
        $expectedType = 'string';
        $response = $this->order->updateSite($this->auth, $this->updateSite);

        $this->assertEquals($expectedCode, $response->code);
        $this->assertContains($response->response->success, $expectedSuccess);
        $this->assertInternalType($expectedType, $response->response->message);
    }

    public function testDeleteSiteAndGetResponse(): void
    {
        $expectedCode = 200;
        $expectedSuccess = [true, false];
        $expectedType = 'string';
        $response = $this->order->deleteSite($this->auth, $this->deleteSite);

        $this->assertEquals($expectedCode, $response->code);
        $this->assertContains($response->response->success, $expectedSuccess);
        $this->assertInternalType($expectedType, $response->response->message);
    }
}