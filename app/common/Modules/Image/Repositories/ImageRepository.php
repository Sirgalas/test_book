<?php

declare(strict_types=1);

namespace common\Modules\Image\Repositories;

use common\Helpers\ErrorHelper;
use common\Modules\Category\Entities\Category;
use common\Modules\Image\Entities\Image;
use yii\web\NotFoundHttpException;

class ImageRepository
{
    public function get(int $id): Image
    {
        if(!$image = Image::findOne($id)) {
            throw new NotFoundHttpException(sprintf('Image id %d not found', $id));
        }
        return $image;
    }
    public function find(int $id): ?Image
    {
        if(!$image = Image::findOne($id)) {
            return null;
        }
        return $image;
    }

    public function save(Image $image): Image
    {
        if(!$image->save()) {
            throw new \RuntimeException(ErrorHelper::errorsToStr($image->errors));
        }
        return $image;
    }

    public function delete(int $id): void
    {
        $image = $this->get($id);
        $image->delete();
    }
}