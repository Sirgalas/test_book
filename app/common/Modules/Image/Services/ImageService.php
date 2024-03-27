<?php

declare(strict_types=1);

namespace common\Modules\Image\Services;

use common\Modules\Image\Entities\Image;
use common\Modules\Image\Forms\ImageForm;
use common\Modules\Image\Repositories\ImageRepository;

class ImageService
{
    public function __construct(public readonly ImageRepository $imageRepository)
    {}

    public function create(ImageForm $form): Image
    {
        $image = Image::create($form);
        return $this->imageRepository->save($image);
    }

    public function edit(Image $image, ImageForm $form): Image
    {
        $image->edit($form);
        return $this->imageRepository->save($image);
    }
}