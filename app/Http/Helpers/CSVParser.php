<?php


namespace App\Http\Helpers;


use Illuminate\Http\UploadedFile;

class CSVParser
{

    public static function parse(UploadedFile $file): array
    {
        $response = [];
        $csvContent = explode("\n", $file->getContent());

        $columns_name = explode(";", $csvContent[0]);
        for ($i = 0; $i < count($columns_name); $i++) {
            $columns_name[$i] = trim($columns_name[$i]);
        }


        array_shift($csvContent);
        array_pop($csvContent);

        foreach ($csvContent as $row) {
            $column_array = [];
            foreach (explode(";", $row) as $index => $column) {
                $column_array[$columns_name[$index]] = trim($column);
            }
            array_push($response, $column_array);
        }
        return $response;
    }

    private static function validateCSV() {
        // TODO
        // - Bon nombre de colonne
        // - Détection du séparateur etc...
    }
}
