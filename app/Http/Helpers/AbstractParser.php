<?php

namespace App\Http\Helpers;

use App\Http\Helpers\Enums\BaseUrlTypes;
use DiDom\Document;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use function PHPUnit\Framework\throwException;

abstract class AbstractParser
{
    public Document $document;

    protected string $baseUrl;
    protected string $href;

    public function __construct($baseUrl, $href)
    {
        $this->document = new Document();
        $this->baseUrl = $baseUrl;
        $this->href = $href;
//        switch ($baseUrl){
//            case BaseUrlTypes::KERAMIR:
//                break;
//            case BaseUrlTypes::GIPERMARKET_DOM:
//                break;
//            case BaseUrlTypes::MOZAIC:
//                break;
//            default:
//                abort(404, 'Not found.');
//        }
    }

    abstract protected function parse(): string;

    protected function getPrice($price): string
    {
        return (float) preg_replace( '/[^0-9.](?!.м2)/', '', $price );
    }
}
