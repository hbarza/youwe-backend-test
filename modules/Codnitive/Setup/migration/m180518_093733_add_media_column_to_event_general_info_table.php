<?php

use yii\db\Migration;

/**
 * Handles adding media to table `event_general_info`.
 *
 * php yii migrate/create add_media_column_to_event_general_info_table --fields="media:blob"
 */
class m180518_093733_add_media_column_to_event_general_info_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('event_general_info', 'media', 'BLOB');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('event_general_info', 'mdeia');
    }
}
