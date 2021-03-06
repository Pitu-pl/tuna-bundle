<?php

namespace TheCodeine\FileBundle\Manager;

use Symfony\Component\Filesystem\Exception\FileNotFoundException;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\File as HttpFile;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use TheCodeine\FileBundle\Entity\AbstractFile;
use TheCodeine\FileBundle\Entity\File as TunaFile;
use TheCodeine\FileBundle\Entity\Image as TunaImage;

class FileManager
{
    /**
     * @var Filesystem
     */
    private $fs;

    /**
     * @var array
     */
    private $config;

    /**
     * FileManager constructor.
     *
     * @param Filesystem $fs
     * @param array $config
     */
    public function __construct(Filesystem $fs, array $config)
    {
        $this->fs = $fs;
        $this->config = $config;
    }

    /**
     * @param $file
     */
    public function removeFile($file)
    {
        if ($file == null) {
            return;
        }
        $path = $this->getFullFilePath($file);
        $this->fs->remove($path);
    }

    /**
     * @param AbstractFile $file
     *
     * @return bool
     */
    public function fileExists(AbstractFile $file)
    {
        $fullPath = $this->getFullPath($file->isUploaded() ? 'tmp' : 'upload_files', $file->getPath());

        return $this->fs->exists($fullPath);
    }

    /**
     * @param AbstractFile $file
     */
    public function moveTmpFile(AbstractFile $file)
    {
        $filename = basename($file->getPath());
        $from = $this->getFullTmpPath($filename);
        $to = $this->getFullFilePath($filename);

        try {
            $this->fs->copy($from, $to);
        } catch (FileNotFoundException $e) {
            throw $e;
        }
        $this->fs->remove($from);
    }

    /**
     * @param AbstractFile $file
     */
    private function removeTmpFile(AbstractFile $file)
    {
        $path = $this->getFullTmpPath($file->getPath());
        $this->fs->remove($path);
    }

    /**
     * @param HttpFile $file
     * @return string
     */
    public function generateTmpFilename(HttpFile $file)
    {
        return sprintf('%s.%s', md5(uniqid()), $file->guessExtension());
    }

    /**
     * @param HttpFile $file
     *
     * @return AbstractFile
     */
    public function generateFile(HttpFile $file)
    {
        return $this->generateAbstractFile($file, new TunaFile());
    }

    /**
     * @param HttpFile $file
     *
     * @return AbstractFile
     */
    public function generateImage(HttpFile $file)
    {
        return $this->generateAbstractFile($file, new TunaImage());
    }

    /**
     * @param HttpFile $file
     * @param AbstractFile $tunaFile
     *
     * @return AbstractFile
     */
    private function generateAbstractFile(HttpFile $file, AbstractFile $tunaFile)
    {
        $filename = $this->generateTmpFilename($file);
        $this->fs->copy($file->getRealPath(), $this->getFullTmpPath($filename));

        return $tunaFile->setPath($filename);
    }

    /**
     * @param UploadedFile $file
     * @param $filename
     */
    public function moveUploadedFile(UploadedFile $file, $filename)
    {
        $file->move(
            sprintf('%s/%s', $this->config['web_root_dir'], $this->config['tmp_path']),
            $filename
        );
    }

    /**
     * @param $file
     *
     * @return string
     */
    private function getFullTmpPath($file)
    {
        return $this->getFullPath('tmp', $file);
    }

    /**
     * @param $file
     *
     * @return string
     */
    private function getFullFilePath($file)
    {
        return $this->getFullPath('upload_files', $file);
    }

    /**
     * @param $type
     * @param $file
     *
     * @return string
     */
    private function getFullPath($type, $file)
    {
        return sprintf('%s/%s/%s', $this->config['web_root_dir'], $this->config[$type . '_path'], $file);
    }
}
