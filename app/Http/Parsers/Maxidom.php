<?php


namespace App\Http\Parsers;

use App\Http\Helpers\AbstractParser;
use App\Http\Helpers\Enums\BaseUrlTypes;
use DiDom\Document;
use DiDom\Exceptions\InvalidSelectorException;

class Maxidom extends AbstractParser
{

    private string $baseItemSelector = "#mnogo_prd_price";
    private string $square = "#overview";

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
        $square = $page->first($this->square);

        if($square){
            preg_match_all('/(?<=В упаковке:)(.*)(?=кв.м)/m', $square, $matches, PREG_SET_ORDER, 0);
            $meter =(float)str_replace(',', '.', $matches[0][0]);
        }

        if ($price && isset($meter)) {
            return round(
                (float) preg_replace('/[^0-9.](?!.м2)/', '', $page->first($this->baseItemSelector)->getAttribute("data-repid_price")) / $meter, 2);
        } else {
            return 0;
        }

    }

}
