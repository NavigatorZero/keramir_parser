<?php

namespace App\Http\Helpers;

use App\Http\Helpers\Enums\BaseUrlTypes;
use DiDom\Document;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use function PHPUnit\Framework\throwException;

class ExcelReader implements \PhpOffice\PhpSpreadsheet\Reader\IReadFilter
{
    public function readCell($column, $row, $worksheetName = '') {
            if (in_array($column,range('B','l'))) {
                return true;
            }
        return false;
    }
}
