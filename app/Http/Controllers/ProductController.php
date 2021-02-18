<?php

namespace App\Http\Controllers;

use App\Http\Managers\ImportManager;
use App\Models\CircProductConfiguration;
use App\Models\Product;
use App\Models\RectProductConfiguration;
use Exception;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    function import()
    {
        return view('import');
    }

    function sendImport(Request $request)
    {
//        return $request->file('file')->getMimeType();
        $msg = [];
        try {
            $request->validate([
                'file' => 'required|mimetypes:text/csv,text/plain,application/csv,text/comma-separated-values,text/anytext,application/octet-stream,application/txt',
            ]);
            $importManager = new ImportManager();
            $datas = $importManager->parse([$request->file('file')]);

            foreach ($datas as $index => $row) {
                if (!array_key_exists('Article', $row)) {
                    var_dump('(' . $index . ') :');
                    var_dump($row);
                }


                $newProduct = Product::firstOrCreate([
                    'name' => $row['Article'],
                ]);

                if ($row['Type'] === 'Rectangulaire') {
                    RectProductConfiguration::create([
                        'product_id' => $newProduct->id,
                        'depth' => floatval($row['Profondeur']),
                        'db_1' => floatval($row['1m']),
                        'db_2' => floatval($row['2m']),
                        'db_5' => floatval($row['5m']),
                        'db_10' => floatval($row['10m']),
                        'width' => floatval($row['Largeur']),
                        'height' => floatval($row['Hauteur']),
                        'thickness' => floatval($row['Epaisseur']),
                    ]);

                } elseif ($row['Type'] === 'Circulaire') {

                    CircProductConfiguration::create([
                        'product_id' => $newProduct->id,
                        'depth' => floatval($row['Profondeur']),
                        'db_1' => floatval($row['1m']),
                        'db_2' => floatval($row['2m']),
                        'db_5' => floatval($row['5m']),
                        'db_10' => floatval($row['10m']),
                        'diameter' => floatval($row['Diametre']),
                    ]);
                } else {
                    throw new Exception('Row type does not match !');
                }
            }

            array_push($msg, "Importation réussie !");
        } catch (Exception $e) {
            array_push($msg, $e->getMessage());
        }
        return view('import', ['msgs' => $msg]);
    }
}
