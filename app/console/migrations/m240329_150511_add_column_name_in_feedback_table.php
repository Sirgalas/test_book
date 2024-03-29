<?php

use common\Modules\Feedback\Entities\Feedback;
use yii\db\Migration;

/**
 * Class m240329_150511_add_column_name_in_feedback_table
 */
class m240329_150511_add_column_name_in_feedback_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(Feedback::tableName(),'name',$this->string(255));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(Feedback::tableName(),'name');
    }

}
