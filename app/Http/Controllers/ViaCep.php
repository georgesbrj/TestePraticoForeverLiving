<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Http\Requests\ImportRequest;
use Illuminate\Http\Request;
use Exception;


class ViaCep extends Controller
{


    public static function consultarCep($cep)
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://viacep.com.br/ws/'.$cep.'/json/',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ]);

        $response = curl_exec($curl);
        curl_close($curl);
        $array = json_decode($response,true);

        return isset($array['cep']) ? $array : null;
    }
}
