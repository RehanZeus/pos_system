<?php

namespace App\Controllers;

class Test extends BaseController
{
    public function index()
    {
        return "Sistem POS Siap. Environment: " . env('CI_ENVIRONMENT');
    }
}