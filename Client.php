<?php


class Client
{

    private static string $URL = "http://127.0.0.1:8091";

    public static function addUser($name, $email)
    {
        $ch = curl_init(self::$URL . '/user');

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
        curl_close($ch);
        return $response;
    }

    public static function getPostsByUser($userId)
    {
        $ch = curl_init(self::$URL . '/todo/' . $userId);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }

    public static function addPost($userId, $name)
    {
        $ch = curl_init(self::$URL . '/todo/' . $userId);

        $data = [
            "name" => $name,
        ];

        $data_json = json_encode($data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen($data_json)));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }

    public static function deletePost($id, $userId)
    {
        $ch = curl_init(self::$URL . '/todo/' . $userId);

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
        curl_close($ch);
        return $response;
    }

    public static function updatePost($postId, $name, $userId)
    {
        $ch = curl_init(self::$URL . '/todo/' . $userId);

        $data = [
            "id" => $postId,
            "name" => $name,
        ];

        $data_json = json_encode($data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen($data_json)));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);


        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }


}

#echo Client::addUser('nigga', 'nigga@mail.ru');
#echo Client::getPostsByUser(1);
#echo Client::addPost(1, 'ubei strelka');
#echo Client::deletePost(2, 1);
echo Client::updatePost(4, 'opyat rabotat', 1);

