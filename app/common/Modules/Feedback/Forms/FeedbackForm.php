<?php

declare(strict_types=1);

namespace common\Modules\Feedback\Forms;

use common\Modules\Feedback\Entities\Feedback;
use yii\base\Model;

class FeedbackForm extends Model
{

    public ?int $id = null;
    public ?string $email = null;
    public ?string $message = null;
    public ?string $phone = null;
    public ?string $name = null;

    public function __construct(Feedback $feedback = null,$config = [])
    {
        parent::__construct($config);
        if($feedback) {
            $this->email = $feedback->email;
            $this->message = $feedback->message;
            $this->phone = $feedback->phone;
            $this->name = $feedback->name;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['email','message'],'required'],
            [['message'], 'string'],
            [['email'], 'email'],
            [['phone'], 'string', 'max' => 20],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'message' => 'Message',
            'phone' => 'Phone',
        ];
    }
}