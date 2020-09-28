<?php

namespace App\Service\Picture;

use App\Helper\Time;
use App\Repository\MySql\PictureRepository;
use App\Repository\PictureRepositoryInterface;
use App\Service\Auth\AuthServiceInterface;
use App\Service\ImageService;
use App\Service\Like\LikeableTrait;
use App\Service\Product\ProductValidationService;
use App\Service\Validate\ValidationResourceInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class PictureService
{
    use LikeableTrait;

    private $validation;
    public $repository;
    private $user;
    private $img;
    private $subjectName;
    private $uploadedPath = null;

    public function __construct(
        PictureRepositoryInterface $repository,
        PictureValidationService $validation,
        AuthServiceInterface $user,
        ImageService $img
    ) {
        $this->user = $user;
        $this->repository = $repository;
        $this->validation = $validation;
        $this->img = $img;
    }

    public function setSubject(string $subject)
    {
        $this->subjectName = $subject;
        $this->repository->setSubject($subject);
    }

    public function uploadPicture(int $subjectId, ?UploadedFile $file, string $pictureName = 'image'): ?int
    {
        if (!$this->validation->validatePicture($pictureName)) {
            return null;
        }

        $userId = $this->user->authParams('id');
        $this->uploadedPath = $this->img->createSetOfImages($file, $this->subjectName, $userId);

        return $this->repository->addPicture($subjectId, $this->uploadedPath, $userId);
    }

    public function removePicture(int $pictureId, string $pictureUrl)
    {
        $this->repository->removePicture('id', $pictureId);
        $this->img->delete($pictureUrl);
    }

    public function like(int $pictureId, bool $like)
    {
        $this->toggleLike(
            $this->repository->getLikeRepository(),
            $like, 
            $pictureId, 
            $this->user->authParams('id')
        );
    }

    public function getUploadedPath(): string
    {
        return $this->uploadedPath;
    }

    public function getPicture(int $id)
    {
        $picture = $this->repository->getPicture($id, $this->user->authParams('id'));
        $picture['elapsed'] = Time::getElapsedTime($picture['time_created']);

        return $picture;
    }
}
