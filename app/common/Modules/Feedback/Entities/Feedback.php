<?php

namespace common\Modules\Feedback\Entities;

use common\Modules\Feedback\Forms\FeedbackForm;
use Yii;

/**
 * This is the model class for table "feedback".
 *
 * @property int $id
 * @property string|null $email
 * @property string|null $message
 * @property string|null $phone
 * @property string $name
 */
class Feedback extends \yii\db\ActiveRecord
{
    public static function create(FeedbackForm $form): self
    {
        $feedback = new self();
        $feedback->email = $form->email;
        $feedback->message = $form->message;
        $feedback->phone = $form->phone;
        $feedback->name = $form->name;
        return $feedback;
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'feedback';
    }

}
