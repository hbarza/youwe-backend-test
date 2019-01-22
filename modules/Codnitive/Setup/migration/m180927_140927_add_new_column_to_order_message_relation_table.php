<?php

use yii\db\Migration;

/**
 * Handles adding new to table `order_message_relation`.
 * 
 * php yii migrate/create add_new_column_to_order_message_relation_table --fields="new:boolean"
 */
class m180927_140927_add_new_column_to_order_message_relation_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('order_message_relation', 'new', $this->boolean() . ' DEFAULT 1');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('order_message_relation', 'new');
    }
}
