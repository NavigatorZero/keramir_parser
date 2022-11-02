<?php


namespace App\Http\Parsers;

use App\Http\Helpers\AbstractParser;
use App\Http\Helpers\Enums\BaseUrlTypes;
use DiDom\Document;
use DiDom\Exceptions\InvalidSelectorException;

class MegaKafel extends AbstractParser
{

    private string $baseItemSelector = ".start-price";

    public function __construct($baseUrl, $href)
    {
        parent::__construct($baseUrl, $href);
    }

    /**
     * @throws InvalidSelectorException
     */
    public function parse(): string
    {
        $page = $this->document->loadHtmlFile($this->href);
        $price = $page->first($this->baseItemSelector);
        if ($price) {
            return self::getPrice($price->text());
        } else {
            return 0;
        }

    }

}