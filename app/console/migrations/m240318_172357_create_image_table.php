<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%image}}`.
 */
class m240318_172357_create_image_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%image}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'extension' => $this->string(10)->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%image}}');
    }
}
