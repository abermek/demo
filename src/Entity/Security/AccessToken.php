<?php

namespace App\Entity\Security;

use FOS\OAuthServerBundle\Entity\AccessToken as BaseAccessToken;

class AccessToken extends BaseAccessToken
{
    protected $id;
    protected $client;
    protected $user;
}
