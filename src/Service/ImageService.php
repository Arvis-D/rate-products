<?php

namespace App\Service;

use Intervention\Image\ImageManager;

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
    private $image = null;
    private $manager;

    public function __construct(ImageManager $manager)
    {
        $this->manager = $manager;
    }

    public function setImage($file)
    {
        $this->image = $this->manager->make($file);
    }

    public function createThumbnail()
    {

    }

    /**
     * Will create 3 images: icon size, thumbnail size and native
     * Image directory example: subject name/month number/userId/productId/md5-size.extension
     */

    public function createSetOfImages()
    {

    }
}
