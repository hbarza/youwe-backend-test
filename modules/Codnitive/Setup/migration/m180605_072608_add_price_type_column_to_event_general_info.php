<?php

use yii\db\Migration;

/**
 * Class m180605_072608_add_price_type_column_to_event_general_info
 *
 * php yii migrate/create add_price_type_column_to_event_general_info_table --fields="price_type:boolean"
 */
class m180605_072608_add_price_type_column_to_event_general_info_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('event_general_info', 'price_type', $this->boolean());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('event_general_info', 'price_type');
    }
}
