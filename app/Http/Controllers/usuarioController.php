<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\StoreUsuarioRequest;


class UsuarioController extends Controller
{
    public function store(StoreUsuarioRequest $request) : JsonResponse 
    {   
        return new JsonResponse(['data' => $request->all()], 200);
    }

}
