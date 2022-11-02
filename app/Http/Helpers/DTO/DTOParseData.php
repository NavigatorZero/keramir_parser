<?php

namespace App\Http\Helpers\DTO;

use App\Http\Helpers\ExcelReader;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\IReader;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\RowCellIterator;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class DTOParseData
{
    public ?string $url;
    public int $rowIndex;

    public function __construct($rowIndex, $url)
    {
        $this->rowIndex = $rowIndex;
        $this->url = $url;
    }
}
