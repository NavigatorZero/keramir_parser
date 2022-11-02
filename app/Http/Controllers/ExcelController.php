<?php

namespace App\Http\Controllers;

use App\Http\Helpers\Enums\BaseUrlTypes;
use App\Http\Helpers\Imports\ParsingResults;
use App\Http\Parsers\GipermarketDom;
use App\Http\Parsers\KeramirParser;
use App\Http\Parsers\MozaicParser;
use App\Managers\ExcelManager;
use App\Managers\ParserManager;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\App;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use phpDocumentor\Reflection\Types\Self_;

class ExcelController extends BaseController
{

    public static string  $filename = 'keramir_parser_results.xlsx';
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @return string
     */
    public function fileImport(Request $request, ExcelManager $excelManager)
    {
        $this->validate($request, [
            'file' => 'required',
        ]);


        if (Storage::disk('public')->exists(self::$filename)) {
            Storage::disk('public')->delete(self::$filename);
        }
        $excelData = $excelManager->readExcel($request->file('file'));
        $parsedData = new ParserManager($excelData);
        $excelManager->writeToExcel($parsedData->beginParse());

        return response()->download(self::$filename);
    }
}
