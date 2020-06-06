<?php

namespace App\Entity\Security;

use FOS\OAuthServerBundle\Entity\RefreshToken as BaseRefreshToken;

class RefreshToken extends BaseRefreshToken
{
    protected $id;
    protected $client;
    protected $user;
}
