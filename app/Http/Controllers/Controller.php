<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected function ddl($data, $exit = null) 
    {
        if($exit == "v") {
            echo "<pre>";
            var_dump($data);
            echo "</pre>";
            return;
        } elseif($exit == "ve") {
            echo "<pre>";
            var_dump($data);
            exit;
        } elseif($exit == "pe") {
            echo "<pre>";
            print_r($data);
            exit;
        }
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    }
}
