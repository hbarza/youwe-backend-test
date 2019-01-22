<?php

use yii\db\Migration;

/**
 * Handles adding tickets_qty to table `event_general_info`.
 *
 * php yii migrate/create add_tickets_qty_column_to_event_general_info_table --fields="tickets_qty:integer(11)"
 */
class m180701_153129_add_tickets_qty_column_to_event_general_info_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('event_general_info', 'tickets_qty', $this->integer(11));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('event_general_info', 'tickets_qty');
    }
}
