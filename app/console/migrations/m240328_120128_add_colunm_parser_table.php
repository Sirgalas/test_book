<?php

use common\Modules\Parser\Entities\Parser;
use yii\db\Migration;

/**
 * Class m240328_120128_add_colunm_parser_table
 */
class m240328_120128_add_colunm_parser_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn(Parser::tableName(),'type', $this->string(25)->notNull()->defaultValue('default'));
        $this->addColumn(Parser::tableName(),'encode', $this->string(25)->notNull()->defaultValue('json'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m240328_120128_add_colunm_parser_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240328_120128_add_colunm_parser_table cannot be reverted.\n";

        return false;
    }
    */
}
