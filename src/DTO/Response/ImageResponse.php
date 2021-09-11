<?php

namespace App\DTO\Response;

class ImageResponse
{
    public int $id;
    public string $name;
    public string $url;

    public function __construct(int $id, string $name, string $url)
    {
        $this->id = $id;
        $this->name = $name;
        $this->url = $url;
    }
}
