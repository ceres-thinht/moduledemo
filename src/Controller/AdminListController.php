<?php

namespace ModuleDemo\Controller;

use PrestaShopBundle\Controller\Admin\FrameworkBundleAdminController;
use Symfony\Component\HttpFoundation\Response;

class AdminListController extends FrameworkBundleAdminController
{
    public function list(): Response
    {
        return new Response('This is list page!');
    }

    public function example(): Response
    {
        return new Response('This is other page!');
    }
}
