<?php

use common\Modules\Image\Entities\Image;
use yii\db\Migration;

/**
 * Class m240319_063358_add_column_url_in_image_table
 */
class m240319_063358_add_column_url_in_image_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(Image::tableName(),'url',$this->string(610)->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240319_063358_add_column_url_in_image_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240319_063358_add_column_url_in_image_table cannot be reverted.\n";

        return false;
    }
    */
}
