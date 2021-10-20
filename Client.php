<?php
require __DIR__ . '/vendor/autoload.php';

class Client
{
    public string $url;

    /**
     * Client constructor.
     */
    public function __construct()
    {
        $details = include('config.php');
        $this->url = $details['host'];
    }

    public function addUser(string $name, string $email)
    {
        $ch = curl_init($this->url . '/user');

        $data = [
            "name" => $name,
            "email" => $email
        ];

        $data_json = json_encode($data);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen($data_json)));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return $httpcode;
    }

    /**
     * @return Post[]
     */
    public function getPostsByUser(int $userId)
    {
        $ch = curl_init($this->url . '/todo/' . $userId);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        print $response;
        if($httpcode != 200) {
            return null;
        }
        $response = json_decode($response, true);
        $rsl = array();
        foreach ($response as $res) {
            $rsl[] = new Post($res['id'], $res['name']);
        }
        return $rsl;
    }

    public function addPost(int $userId, string $name)
    {
        $ch = curl_init($this->url . '/todo/' . $userId);

        $data = [
            "name" => $name,
        ];

        $data_json = json_encode($data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen($data_json)));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return $httpcode;
    }

    public function deletePost(int $id, int $userId)
    {
        $ch = curl_init($this->url . '/todo/' . $userId);

        $data = [
            "id" => $id,
        ];

        $data_json = json_encode($data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen($data_json)));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        if($httpcode != 200) {
            return null;
        }
        return json_decode($response);
    }

    public function updatePost(Post $post, int $userId)
    {
        $ch = curl_init($this->url . '/todo/' . $userId);

        $data = [
            "id" => $post->id,
            "name" => $post->name,
        ];

        $data_json = json_encode($data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen($data_json)));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        print $httpcode;
        if($httpcode != 200) {
            return null;
        }
        return $httpcode;
    }


}

#echo Client::addUser('nigga', 'nigga@mail.ru');
#echo Client::getPostsByUser(1);
#echo Client::addPost(1, 'ubei strelka');
#echo Client::deletePost(2, 1);
#echo Client::updatePost(4, 'opyat rabotat', 1);

