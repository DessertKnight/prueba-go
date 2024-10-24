<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ApiExternaController extends Controller
{
    public function getPokemon()
    {
        $client = new Client();
        $response = $client->get('https://pokeapi.co/api/v2/pokemon/ditto');
        $body = $response->getBody();
        $pokemon = json_decode($body);

        return response()->json($pokemon);
    }
}

