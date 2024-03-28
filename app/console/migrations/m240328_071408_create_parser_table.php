<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%parser}}`.
 */
class m240328_071408_create_parser_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%parser}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'url' =>$this->string(610)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%parser}}');
    }
}
