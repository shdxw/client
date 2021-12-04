<?php

declare(strict_types=1);

namespace Client;

use Models\Post;

class Client
{
    public string $url;

    
    public function __construct()
    {
        $details = include 'config.php';
        $this->url = $details['host'];
    }

    public function addUser(string $name, string $email)
    {
        $option = curl_init($this->url . '/user');

        $data = [
            'name' => $name,
            'email' => $email,
        ];

        $data_json = json_encode($data);

        curl_setopt(
            $option,
            CURLOPT_HTTPHEADER,
            ['Content-Type: application/json', 'Content-Length: ' . strlen($data_json)]
        );
        curl_setopt($option, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($option, CURLOPT_POST, true);
        curl_setopt($option, CURLOPT_POSTFIELDS, $data_json);
        curl_exec($option);
        $httpcode = curl_getinfo($option, CURLINFO_HTTP_CODE);
        curl_close($option);
        return $httpcode;
    }

    /**
     * @return Post[]
     */
    public function getPostsByUser(int $userId)
    {
        $option = curl_init($this->url . '/todo/' . $userId);
        curl_setopt($option, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($option, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($option, CURLOPT_HEADER, false);
        $response = curl_exec($option);
        $httpcode = curl_getinfo($option, CURLINFO_HTTP_CODE);
        curl_close($option);
        print $response;
        if ($httpcode !== 200) {
            return null;
        }
        $response = json_decode($response, true);
        $rsl = [];
        foreach ($response as $res) {
            $rsl[] = new Post($res['id'], $res['name']);
        }
        return $rsl;
    }

    public function addPost(int $userId, string $name)
    {
        $option = curl_init($this->url . '/todo/' . $userId);

        $data = [
            'name' => $name,
        ];

        $data_json = json_encode($data);
        curl_setopt(
            $option,
            CURLOPT_HTTPHEADER,
            ['Content-Type: application/json', 'Content-Length: ' . strlen($data_json)]
        );
        curl_setopt($option, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($option, CURLOPT_POST, true);
        curl_setopt($option, CURLOPT_POSTFIELDS, $data_json);
        curl_exec($option);
        $httpcode = curl_getinfo($option, CURLINFO_HTTP_CODE);
        curl_close($option);

        return $httpcode;
    }

    public function deletePost(int $post_id, int $userId)
    {
        $option = curl_init($this->url . '/todo/' . $userId);

        $data = [
            'id' => $post_id,
        ];

        $data_json = json_encode($data);
        curl_setopt(
            $option,
            CURLOPT_HTTPHEADER,
            ['Content-Type: application/json', 'Content-Length: ' . strlen($data_json)]
        );
        curl_setopt($option, CURLOPT_CUSTOMREQUEST, 'DELETE');
        curl_setopt($option, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($option, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($option, CURLOPT_HEADER, false);
        $response = curl_exec($option);
        $httpcode = curl_getinfo($option, CURLINFO_HTTP_CODE);
        curl_close($option);
        if ($httpcode !== 200) {
            return null;
        }
        return json_decode($response);
    }

    public function updatePost(Post $post, int $userId)
    {
        $option = curl_init($this->url . '/todo/' . $userId);

        $data = [
            'id' => $post->id,
            'name' => $post->name,
        ];

        $data_json = json_encode($data);
        curl_setopt(
            $option,
            CURLOPT_HTTPHEADER,
            ['Content-Type: application/json', 'Content-Length: ' . strlen($data_json)]
        );
        curl_setopt($option, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($option, CURLOPT_POSTFIELDS, $data_json);
        curl_setopt($option, CURLOPT_RETURNTRANSFER, true);
        curl_exec($option);
        $httpcode = curl_getinfo($option, CURLINFO_HTTP_CODE);
        curl_close($option);
        print $httpcode;
        if ($httpcode !== 200) {
            return null;
        }
        return $httpcode;
    }
}

// echo Client::addUser('nigga', 'nigga@mail.ru');
// echo Client::getPostsByUser(1);
// echo Client::addPost(1, 'ubei strelka');
// echo Client::deletePost(2, 1);
// echo Client::updatePost(4, 'opyat rabotat', 1);
