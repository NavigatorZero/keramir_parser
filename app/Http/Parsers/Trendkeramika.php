<?php


namespace App\Http\Parsers;

use App\Http\Helpers\AbstractParser;
use App\Http\Helpers\Enums\BaseUrlTypes;
use DiDom\Document;
use DiDom\Exceptions\InvalidSelectorException;

class Trendkeramika extends AbstractParser
{

    private string $baseItemSelector = ".price";
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
            return self::getPrice($price->firstChild()->text());
        } else {
            return 0;
        }
    }

}
