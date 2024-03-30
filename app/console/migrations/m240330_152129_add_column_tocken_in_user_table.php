<?php

use common\Modules\User\Entities\User;
use yii\db\Migration;

/**
 * Handles adding columns to table `{{%cken_in_user}}`.
 */
class m240330_152129_add_column_tocken_in_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(User::tableName(),'rest_access_token', $this->string(255));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn(User::tableName(),'rest_access_token');
    }
}
