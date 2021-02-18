<?php

namespace App\Http\Controllers;

use App\Http\Managers\ImportManager;
use App\Models\CircProductConfiguration;
use App\Models\RectProductConfiguration;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    function import() {
        return view('import');
    }
    function sendImport(Request $request) {
//        return $request->file('file')->getMimeType();
        $errors = [];
        try {
            $request->validate([
                'file' => 'required|mimetypes:text/csv,text/plain,application/csv,text/comma-separated-values,text/anytext,application/octet-stream,application/txt',
            ]);
            $importManager = new ImportManager();
            $datas = $importManager->parse([$request->file('file')]);
            array_push($errors,"Import en cours...");
            foreach ($datas as $row) {
                if ($row['Type'] === 'Rectangulaire') {
//                    $recProductConf = new RectProductConfiguration();
//                    $recProductConf->fill($row);
                    $recProductConf = RectProductConfiguration::firstOrCreate($row);
                } elseif ($row['Type'] === 'Circulaire') {
                    $circProductConf = new CircProductConfiguration();
//                    $circProductConf->fill($row);
                } else {
                    array_push($errors, "Row type does not match.");
                }
            }
        } catch (ValidationException $e) {
            array_push($errors, $e->getMessage());
        }
        return view('import', ['errors' => $errors]);
    }
}
