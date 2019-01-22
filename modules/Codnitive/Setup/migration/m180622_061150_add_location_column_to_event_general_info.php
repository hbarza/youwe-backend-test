<?php

use yii\db\Migration;

/**
 * Class m180622_061150_add_location_column_to_event_general_info
 *
 * php yii migrate/create add_location_column_to_event_general_info_table --fields="location:text"
 */
class m180622_061150_add_location_column_to_event_general_info extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('event_general_info', 'location', $this->text()->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('event_general_info', 'location');
    }
}
