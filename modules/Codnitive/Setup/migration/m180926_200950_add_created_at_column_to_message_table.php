<?php

use yii\db\Migration;

/**
 * Handles adding created_at to table `message`.
 * 
 * php yii migrate/create add_created_at_column_to_message_table --fields="created_at:timestamp:notNull"
 * 
 */
class m180926_200950_add_created_at_column_to_message_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('message', 'created_at', $this->timestamp()->notNull() . ' DEFAULT CURRENT_TIMESTAMP');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('message', 'created_at');
    }
}
