<?php

namespace Support\Http\Concerns;

use Phalcon\Http\Request\File;
use Support\Filesystem\Contracts\Filesystem;

trait InteractsWithFile
{
    /**
     * @var Filesystem
     */
    protected $disk;

    /**
     * @var array
     */
    protected $files = [];

    /**
     * @var array
     */
    protected $mimeTypes = [
        'image/jpeg' => 'jpeg',
        'image/jpg' => 'jpg',
        'image/png' => 'png',
        'image/gif' => 'gif',
        'image/bmp' => 'bmp',
        'image/svg+xml' => 'svg',
    ];

    /**
     * Set the disk which the file will be uploaded to
     *
     * @param Filesystem $disk
     * @return void
     */
    public function setDisk(Filesystem $disk)
    {
        $this->disk = $disk;
    }

    /**
     * Get the disk which the file will be uploaded to
     *
     * @return Filesystem $disk
     */
    public function getDisk()
    {
        return $this->disk;
    }

    /**
     * Get the list of request's files
     *
     * @return array
     */
    public function files()
    {
        if ($this->hasFiles()) {
            $files = $this->getUploadedFiles();

            foreach ($files as $file) {
                $error = $file->getError();
                if ($error && $error != UPLOAD_ERR_NO_FILE) {
                    throw new \Support\Exceptions\ImageUploadException($error);
                }

                if (!$file->isUploadedFile()) {
                    continue;
                }

                $this->files[$file->getKey()] = $file;
            }

            return $this->files;
        }

        return [];
    }

    /**
     * Upload file to temporary folder
     *
     * @param File $file
     * @return string $uploadedPath
     */
    public function uploadTemporarily(File $file)
    {
        if (!$this->getDisk()) {
            return '';
        }

        try {
            $fileName = $this->temporaryFilename($file);
            $result = $this->getDisk()->put($fileName, file_get_contents($file->getTempName()));
            return $fileName;
        } catch (\Exception $e) {
            return '';
        }
    }

    /**
     * Generate temporary path base on filename
     *
     * @param File $file
     * @return string
     */
    public function temporaryFilename(File $file)
    {
        $ext = $this->mimeTypes[$file->getRealType()] ?? 'jpg';
        return sprintf('tmp/%s/%s.%s', date('Y_m_d'), str_random(32), $ext);
    }

    /**
     * Get the basename of temporary path
     *
     * @param string $temporaryPath
     * @return string
     */
    public function temporaryBasename(string $temporaryPath)
    {
        // The path is sprintf('tmp/%s/%s.%s', date('Y_m_d'), str_random(32), $ext);
        // so the basename will be substr($path, 15);
        return $temporaryPath ? substr($temporaryPath, 15) : '';
    }
}
