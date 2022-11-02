<?php

namespace App\Http\Helpers\DTO;

use App\Http\Helpers\ExcelReader;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\IReader;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\RowCellIterator;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class DTOSheetRow
{
    public ?string $positionName;

    /** @var DTOParseData[] */
    public ?array $urls = [];

    public string $column;
    public string $href;
    public  $price;
    public int $row;
    public string $info;
    public bool $isLower = false;

    public function __construct($positionName=null)
    {
        $this->positionName = $positionName;
    }

}
