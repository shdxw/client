<?php

namespace Tests;

use Client\Client;
use Models\Post;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{

    public function testAddUser()
    {
        $client = new Client();
        $rsl = $client->addUser("koroko", "jj@mail.ru");
        print $rsl;
        $this->assertSame($rsl, 200, "user added");
    }

    public function testGetPosts()
    {
        $client = new Client();
        $rsl = $client->getPostsByUser(1);
        $this->assertTrue(is_array($rsl) || is_object($rsl));
    }

    public function testAddPost()
    {
        $client = new Client();
        $rsl = $client->addPost(1, "okey");
        $this->assertSame($rsl, 200, "post added");
    }

    /**
     * @depends testAddPost
     */
    public function testPutPost()
    {
        $client = new Client();
        $rsl = $client->updatePost(new Post(10, "okey"), 1);
        $this->assertSame($rsl, 200, "");
    }

    /**
     * @depends testPutPost
     */
    public function testDeletePost()
    {
        $client = new Client();
        $rsl = $client->deletePost(1, 1);
        $this->assertSame($rsl, 200, "");
    }
}
