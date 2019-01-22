<?php

use yii\db\Migration;

/**
 * Class m180531_053249_add_seat_seattings_seat_map_column_to_event_general_info
 */
class m180531_053249_add_seat_seattings_seat_map_column_to_event_general_info_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('event_general_info', 'seat_settings', $this->integer(3));
        $this->addColumn('event_general_info', 'seat_map', 'BLOB');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('event_general_info', 'seat_settings');
        $this->dropColumn('event_general_info', 'seat_map');
    }
}
