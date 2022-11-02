<?php

namespace App\Managers;

use App\Http\Helpers\AbstractParser;
use App\Http\Helpers\DTO\DTOParseData;
use App\Http\Helpers\DTO\DTOSheetRow;
use App\Http\Helpers\Enums\BaseUrlTypes;
use App\Http\Helpers\ExcelReader;
use App\Http\Parsers\AKeramika;
use App\Http\Parsers\Akropol;
use App\Http\Parsers\GipermarketDom;
use App\Http\Parsers\KeramirParser;
use App\Http\Parsers\Keramodecor;
use App\Http\Parsers\Maxidom;
use App\Http\Parsers\MegaKafel;
use App\Http\Parsers\MozaicParser;
use App\Http\Parsers\Stroyshab66;
use App\Http\Parsers\Trendkeramika;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\IReader;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Column;
use PhpOffice\PhpSpreadsheet\Worksheet\Row;
use PhpOffice\PhpSpreadsheet\Worksheet\RowCellIterator;
use PhpOffice\PhpSpreadsheet\Worksheet\RowIterator;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ParserManager
{
    public array $domains = [
        'kafel-online.ru',
        'www.maxidom.ru',
        'keramodecor.ru',
        'trendkeramika.ru',
        //  'gipermarketdom.ru',
        'stroysnab66.ru',
        'a-keramika96.ru',
        'mega-kafel.ru',
        'www.akro-pol.ru',
        'mozaic96.ru'
    ];

    public array $data;

    public array $headers;

    public function __construct(array $data)
    {
        $this->headers = $data[0];
        unset($data[0]);
        $this->data = $data;
    }

    public function beginParse(): array
    {
        /** @var DTOSheetRow[] $row */
        foreach ($this->data as $index => $row) {
            $compareTo = null;
            foreach ($row as $rowIndex => $item) {
                if (str_starts_with($item->column, "A") || str_starts_with($item->column, "B")) {
                    continue;
                }
                if (filter_var($item->href, FILTER_VALIDATE_URL)) {
                    $test = parse_url($item->href);
                    if ($domain = self::substr_in_array($test["host"], $this->domains)) {
                        $parser = self::getParser($domain, $item->href);
                        try {
                            $item->price = $parser->parse();
                            if ($parser instanceof KeramirParser) {
                                $compareTo = $item->price;
                            }
                            if ($compareTo && $item->price && $compareTo > $item->price && !$parser instanceof KeramirParser) {
                                $item->isLower = true;
                            }
                        } catch (\Exception $exception) {
                            $item->info = "exception: " . $exception->getMessage();
                        }
                        if ($item->price === 0) {
                            $item->info = 'price not found';
                        }
                    } else {
                        $item->info = 'url ok, but not found';
                    }
                } else {
                    $item->info = 'bad url address';
                }
            }
        }
        return $this->data;
    }


    /** @return AbstractParser */
    public function getParser(string $domain, $href)
    {
        switch ($domain) {
            case BaseUrlTypes::KERAMIR:
                return new KeramirParser($domain, $href);
            case BaseUrlTypes::GIPERMARKET_DOM:
                return new GipermarketDom($domain, $href);
            case BaseUrlTypes::MOZAIC:
                return new MozaicParser($domain, $href);
            case BaseUrlTypes::A_KERAMIKA:
                return new AKeramika($domain, $href);
            case BaseUrlTypes::AKRO_POL:
                return new Akropol($domain, $href);
            case BaseUrlTypes::MAXIDM:
                return new Maxidom($domain, $href);
            case BaseUrlTypes::TRENDKERAMIKA:
                return new Trendkeramika($domain, $href);
            case BaseUrlTypes:: STROYSNAB66:
                return new Stroyshab66($domain, $href);
            case BaseUrlTypes::KERAMODEKOR:
                return new Keramodecor($domain, $href);
            case BaseUrlTypes::MEGA_KAFEL:
                return new MegaKafel($domain, $href);
            default:
                abort(404, 'Not found.');
        }
    }

    /**
     * A version of in_array() that does a sub string match on $needle
     *
     * @param mixed $needle The searched value
     * @param array $haystack The array to search in
     * @return string
     */
    function substr_in_array($needle, array $haystack)
    {
        $res = array_filter($haystack, function ($item) use ($needle) {
            return false !== strpos($item, $needle);
        });

        if ($res) {
            return reset($res);
        }
    }
}
