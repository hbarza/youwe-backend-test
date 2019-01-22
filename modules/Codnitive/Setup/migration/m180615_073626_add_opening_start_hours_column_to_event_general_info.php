<?php

use yii\db\Migration;

/**
 * Class m180615_073626_add_opening_start_hours_column_to_event_general_info
 *
 * php yii migrate/create add_opening_start_hours_column_to_event_general_info_table --fields="opening_hour:time,start_hour:time"
 */
class m180615_073626_add_opening_start_hours_column_to_event_general_info_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('event_general_info', 'opening_hour', $this->time());
        $this->addColumn('event_general_info', 'start_hour', $this->time());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('event_general_info', 'opening_hour');
        $this->dropColumn('event_general_info', 'start_hour');
    }
}
