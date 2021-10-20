<?php


class Post
{
    public int $id;
    public string $name;

    /**
     * Post constructor.
     * @param int $id
     * @param string $name
     */
    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

}