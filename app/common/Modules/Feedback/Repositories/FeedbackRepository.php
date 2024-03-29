<?php

declare(strict_types=1);

namespace common\Modules\Feedback\Repositories;

use common\Helpers\ErrorHelper;
use common\Modules\Feedback\Entities\Feedback;

class FeedbackRepository
{
    public function save(Feedback $feedback): Feedback
    {
        if(!$feedback->save()) {
            throw new \RuntimeException(ErrorHelper::errorsToStr($feedback->errors));
        }
        return $feedback;
    }
}