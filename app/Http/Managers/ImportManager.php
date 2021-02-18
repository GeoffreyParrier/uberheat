<?php


namespace App\Http\Managers;


use App\Http\Helpers\CSVParser;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImportManager
{
    /**
     * @param UploadedFile[] $files
     * @return array|string
     */
    public function parse(array $files)
    {
        foreach ($files as $file) {
            $extension = $file->getClientOriginalExtension();
            switch ($extension) {
                case 'csv':
                    $datas = CSVParser::parse($file);
                    break;
                default:
                    return $extension . ' not implemented.';
            }
            return $datas;
        }
    }
}
