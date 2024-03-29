<?php

declare(strict_types=1);

namespace common\Modules\Feedback\Services;

use common\Modules\Feedback\Entities\Feedback;
use common\Modules\Feedback\Forms\FeedbackForm;
use common\Modules\Feedback\Repositories\FeedbackRepository;

class FeedbackService
{
    public function __construct(readonly public FeedbackRepository $feedbackRepository)
    {}

    public function create(FeedbackForm $form)
    {
        $feedback = Feedback::create($form);
        $this->feedbackRepository->save($feedback);

        \Yii::$app->mailer->compose([
            'html' => 'feedback-html',
            'text' => 'feedback-text'
        ])->setFrom('from@domain.com')
            ->setTo($feedback->email)
            ->setSubject('Вы оставили обпащение')
            ->send();

    }
}