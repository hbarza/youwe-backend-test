<?php

use yii\db\Migration;

/**
 * Handles dropping country_division_city from table `event_general_info`.
 *
 * php yii migrate/create drop_country_division_city_column_from_event_general_info_table --fields="country:string(2):notNull,division:string(200):notNull,city:string(200):notNull"
 */
class m180622_062834_drop_country_division_city_column_from_event_general_info_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('event_general_info', 'country');
        $this->dropColumn('event_general_info', 'division');
        $this->dropColumn('event_general_info', 'city');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('event_general_info', 'country', $this->string(2)->notNull());
        $this->addColumn('event_general_info', 'division', $this->string(200)->notNull());
        $this->addColumn('event_general_info', 'city', $this->string(200)->notNull());
    }
}
