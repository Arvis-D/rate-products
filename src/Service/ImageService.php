<?php

namespace App\Service;

use Intervention\Image\Image;
use Intervention\Image\ImageManager;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * requires:
 * 
 * sudo apt-get install jpegoptim
 * sudo apt-get install optipng
 * sudo apt-get install pngquant
 * sudo npm install -g svgo
 * sudo apt-get install gifsicle
 * sudo apt-get install webp
 */

class ImageService
{
    private $manager;
    private $public = __DIR__ . '/../../public';

    public function __construct(ImageManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Will create 3 images: icon size, thumbnail size and native
     * Image directory example: subject name/year/month number/day/userId/md5-size.extension
     * 
     * @return string the created path
     */

    public function createSetOfImages(UploadedFile $file, string $subjectName, int $userId): string
    {
        $image = $this->manager->make($file);

        $urlPath = $this->getPath($subjectName, $userId);
        $path = $this->createDirectory($urlPath);

        $ext = explode('/', $image->mime)[1];
        $filename = md5($file->getClientOriginalName()) . "--size.{$ext}";
        $fullPath = $path . $filename;

        $image->save($fullPath, 50);
        $this->createThumbnail($image, $fullPath);
        $this->createIcon($image, $fullPath);

        return $urlPath . $filename;
    }

    private function createThumbnail(Image $img, string $fullPath)
    {
        $path = $this->addSizePostfixToPath($fullPath, 'thumb');
        $this->downsize($img, 200 * 200)->save($path, 50);
    }

    private function createIcon(Image $img, string $fullPath)
    {
        $path = $this->addSizePostfixToPath($fullPath, 'icon');
        $this->downsize($img, 100 * 100)->save($path, 50);
    }


    private function addSizePostfixToPath(string $fullPath, string $size): string
    {
        return str_replace('--size', "--{$size}", $fullPath);
    }

    private function downsize(Image $img, int $pixels): Image
    {
        $relSize = sqrt($pixels / ($img->getWidth() * $img->getHeight()) );

        return $img->resize($img->getWidth() * $relSize, $img->getHeight() * $relSize);
    }

    private function createDirectory(string $path): string
    {
        $publicPath = $this->public . $path;
        
        if (!file_exists($publicPath)) {
            mkdir($publicPath, 0770, true);
        }

        return $publicPath;
    }

    private function getPath(string $subjectName, int $userId): string
    {
        $year = date('y');
        $month = date('m');
        $day = date('d');

        return "/img/{$subjectName}/{$year}/{$month}/{$day}/{$userId}/";
    }

    public function delete(string $pictureUrl)
    {
        $path = $this->public . $pictureUrl;
        unlink($path);
        unlink(str_replace('--size', '--thumb', $path));
        unlink(str_replace('--size', '--icon', $path));
    }
}
