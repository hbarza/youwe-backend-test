<?php

use yii\db\Migration;

/**
 * Handles adding sub_title to table `event_general_info`.
 *
 * php yii migrate/create add_sub_title_column_to_event_general_info_table --fields="sub_title:string(512)"
 */
class m180629_145059_add_sub_title_column_to_event_general_info_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('event_general_info', 'sub_title', $this->string(512));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('event_general_info', 'sub_title');
    }
}
