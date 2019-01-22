<?php

use yii\db\Migration;

/**
 * Handles dropping seats from table `event_general_info`.
 *
 * php yii migrate/create drop_seats_column_from_event_general_info_table --fields="seats:integer(8)"
 */
class m180709_160601_drop_seats_column_from_event_general_info_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('event_general_info', 'seats');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('event_general_info', 'seats', $this->integer(8));
    }
}
