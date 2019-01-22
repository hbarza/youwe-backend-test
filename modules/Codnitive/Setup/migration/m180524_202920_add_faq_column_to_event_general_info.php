<?php

use yii\db\Migration;

/**
 * Class m180524_202920_add_faq_column_to_event_general_info
 *
 * php yii migrate/create add_faq_column_to_event_general_info_table --fields="faq:blob"
 */
class m180524_202920_add_faq_column_to_event_general_info_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('event_general_info', 'faq', 'BLOB');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('event_general_info', 'faq');
    }
}
