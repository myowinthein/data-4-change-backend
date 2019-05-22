<?php

namespace App\Helpers;

use Carbon\Carbon;
use Hash;
use Storage;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\File;
use Illuminate\Support\Str;

class Seed
{
    protected static function generateCreatedDate () {
        return Carbon::now()->subDays(rand(5, 9));
    }

    protected static function generateUpdatedDate () {
        return Carbon::now()->subDays(rand(1, 5));
    }

    public static function generateRememberToken () {
        return Str::random(10);
    }

    public static function generateCurrentDate () {
        return Carbon::now();
    }

    public static function getSeedLimit () {
        return 10;
    }

    public static function getDefaultPassword () {
        return Hash::make('password');
    }

    public static function insertData ($model, $rows, $timeStamps = TRUE) {
        $model::truncate();

        $ids = [];
        foreach ($rows as $row) {
            if ($timeStamps) {
                $row['created_at'] = Self::generateCreatedDate();
                $row['updated_at'] = Self::generateUpdatedDate();
            }

            $newRow = $model::create($row);
            $ids[] = $newRow->id;
        }

        return $ids;
    }

    public static function insertImage ($id, $seedPath, $destPath = false, $photoIndex = false) {
        $fileSystem = new Filesystem();
        $destPath = $destPath ?: $seedPath;
        $sourcePath = storage_path("seed/$seedPath");
        $sourceFiles = glob($sourcePath .'/*.*');
        $sourceFilesCount = count($sourceFiles);

        foreach ($sourceFiles as $key => $sourceFile) {
            $sourceFileObj = new File($sourceFile);

            if ($sourceFilesCount > 1) {
                if ($photoIndex !== false) { // specific photo for each row
                    if ($key === $photoIndex) {
                        $extension = $fileSystem->extension($sourceFile);
                        $baseName = $id .'.'. $extension;
                        Storage::putFileAs($destPath, $sourceFileObj, $baseName);
                        break;
                    } else {
                        continue;
                    }
                } else { // multiple photo for each row
                    Storage::putFile($destPath .'/'. $id, $sourceFileObj);
                }
            } else { // single photo for all rows
                $extension = $fileSystem->extension($sourceFile);
                $baseName = $id .'.'. $extension;
                Storage::putFileAs($destPath, $sourceFileObj, $baseName);
            }
        }
    }
}