<?php

namespace app\Traits;

use Exception;
use Illuminate\Support\Facades\Storage;
use Str;

trait FileManagement
{
    /**
     * @param mixed      $content
     * @param mixed|null $fileName
     * @param mixed      $baseDir
     * @param mixed|null $storage
     * @param mixed      $overwrite
     *
     * @throws Exception
     */
    protected function createFile($content, $fileName = null, $baseDir = '', $storage = null, $overwrite = false)
    {
        $storage ??= Storage::disk();

        while (true) {
            if (null === $fileName) {
                $fileName = $this->generateFileName($content);
            }
            $isFileExits = $storage->exists($fileName);
            //            $fullPath = $baseDir . $fileName;
            if ($isFileExits && ! $overwrite) {
                //  throw new \Exception("File $fullPath is already exists");
                continue;
            }
            break;
        }

        if (is_file($content)) {
            $content = $content->getContent();
        }

        $storage->put($baseDir . $fileName, $content);

        return $fileName;
    }

    /**
     * @param mixed $data
     *
     * @throws Exception
     */
    protected function generateFileName($data): string
    {
        if (empty($data) || ! is_file($data)) {
            throw new Exception('cannot get name because the file is empty');
        }

        $extension          = $data->guessExtension();
        $clientOriginalName = pathinfo($data->getClientOriginalName(), PATHINFO_FILENAME);

        return $clientOriginalName . '_' . date('YmdHisv') . Str::random(4) . '.' . $extension;
    }

    /**
     * @param mixed $disk
     * @param mixed $key
     *
     * @throws Exception
     */
    protected function getFile($disk, $key = 'image')
    {
        if (request()->has($key)) {
            $file = request()->file($key);

            return $this->createFile($file, null, null, $disk);
        }

        return null;
    }

    /**
     * @param mixed      $disk
     * @param mixed|null $baseDir
     * @param mixed      $key
     *
     * @throws Exception
     */
    protected function getFiles($disk, $baseDir = null, $key = 'images'): ?array
    {
        if (request()->has($key)) {
            $files  = request()->file($key);
            $result = [];

            foreach ($files as $file) {
                $result[] = $this->createFile($file, null, $baseDir, $disk);
            }

            return $result;
        }

        return null;
    }
}
