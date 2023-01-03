<?php

namespace App\Http\Controllers\Registry;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\RegistryService;

class RegistryController extends Controller
{
    private $registry_service;

    public function __construct(RegistryService $registry_service) {
        $this->registry_service = $registry_service;
    }

    public function lookup(Request $request)
    {
        return $this->registry_service->query($request->all());
    }
}
