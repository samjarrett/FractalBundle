<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Tests\Fixtures\App;

class FractalBundleTest extends TestCase
{
    /** @var  App */
    private $app;

    public function setUp()
    {
        $this->app = new App('test', true);
        $this->app->boot();
    }

    public function test_authors_list()
    {
        $json = $this->request('/authors');

        $this->assertCount(2, $json['data']);
        $this->assertArrayNotHasKey('books', $json['data'][0]);
    }

    public function test_authors_list_with_limited_amount_of_books()
    {
        $json = $this->request('/authors?include=books:limit(3)');

        $this->assertCount(2, $json['data']);
        foreach ($json['data'] as $author) {
            $this->assertCount(3, $author['books']['data']);
        }
    }

    public function test_books_list()
    {
        $json = $this->request('/books');

        $this->assertCount(14, $json['data']);
    }

    public function test_books_list_with_authors()
    {
        $json = $this->request('/books?include=author');

        $this->assertCount(14, $json['data']);
        $this->arrayHasKey('author', $json['data'][0]['author']);
    }

    /**
     * @param string $uri
     * @return array
     */
    private function request($uri)
    {
        $response = $this->app->handle(Request::create($uri, 'GET'));
        $json = json_decode($response->getContent(), true);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(JSON_ERROR_NONE, json_last_error());

        return $json;
    }
}
