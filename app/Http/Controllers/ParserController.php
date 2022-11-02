<?php

namespace App\Http\Controllers;

use App\Http\Helpers\Enums\BaseUrlTypes;
use App\Http\Parsers\GipermarketDom;
use App\Http\Parsers\KeramirParser;
use App\Http\Parsers\MozaicParser;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class ParserController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function renderForm() {
        return view("mainView");
    }


    public function resolveParse(Request $request)
    {

//        switch ($request->query("base_url")) {
//            case BaseUrlTypes::KERAMIR:
//                new KeramirParser();
//                break;
//            case BaseUrlTypes::GIPERMARKET_DOM:
//                new GipermarketDom();
//                break;
//            case BaseUrlTypes::MOZAIC:
//                new MozaicParser();
//                break;
//            default:
//                abort(404, 'Not found.');
//        }
    }
}
