<?php


namespace App\Http\Helpers;


use Illuminate\Http\UploadedFile;

class CSVParser
{

    public static function parse(UploadedFile $file): array
    {
        $response = [];
        $var = explode("\n", $file->getContent());
        $columns_name = explode(";", $var[0]);
        array_shift($var);
        foreach ($var as $row) {
            $column_array = [];
            foreach (explode(";", $row) as $index => $column) {
                $column_array[$columns_name[$index]] = $column;
            }
            array_push($response, $column_array);
        }
        return $response;
    }
}
