<?php

namespace App\Managers;

use App\Http\Controllers\ExcelController;
use App\Http\Helpers\DTO\DTOSheetRow;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Reader\IReader;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Row;
use PhpOffice\PhpSpreadsheet\Worksheet\RowCellIterator;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExcelManager
{
    public IReader $reader;
    public $writer;
    public Spreadsheet $localSheet;

    public function __construct()
    {
        $this->reader = IOFactory::createReader("Xlsx");
    }


    public function readExcel($fileName)
    {
        $parsedData = [];
        $this->localSheet = $this->reader->load($fileName);

        /** @var Row $row */
        foreach ($this->localSheet->getActiveSheet()->getRowIterator() as $row) {
            $rowIndex = $row->getRowIndex();
            $parsedData[] = self::getParsingData($row, $rowIndex);
        }

        return $parsedData;
    }


    public function getParsingData($row, $rowIndex)
    {
        /** @var RowCellIterator $cellIterator */
        $cellIterator = $row->getCellIterator();
        $cellIterator->setIterateOnlyExistingCells(FALSE); // This loops through all cells,
        //$result->domain = $cellIterator[0];
        $result = [];
        foreach ($cellIterator as $cell => $value) {
            if ($value->getValue()) {
                $dto = new DTOSheetRow();
                $dto->row = $rowIndex;
                $dto->column = $value->getParent()->getCurrentCoordinate();
                $dto->href = $value->getValue();
                $result[] = $dto;
            }
        }
        return $result;
    }

    public function getHeaders($column): array
    {
        $result = [];
        foreach ($column as $cell) {
            $result[] = new DTOSheetRow($cell->getValue());
        }
        return $result;

    }

    /** @param DTOSheetRow[] $data */
    public function writeToExcel(array $data)
    {
        $activeSheet = $this->localSheet->getActiveSheet();
        foreach ($data as $rowIndex => $row) {
            foreach ($row as $colIndex => $col) {
                if (str_starts_with($col->column, "A") || str_starts_with($col->column, "B")) {
                    continue;
                }
                $activeSheet->setCellValue($col->column, $col->price ?? $col->info ?? 'internal error');
                $activeSheet->getCell($col->column)->getHyperlink()->setUrl($col->href);
                if($col->isLower){
                    $activeSheet->getStyle($col->column)
                        ->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_RED);
                }
            }
        }
        $writer = new Xlsx($this->localSheet);
        $writer->save(public_path() . '/' . ExcelController::$filename);
    }
}
