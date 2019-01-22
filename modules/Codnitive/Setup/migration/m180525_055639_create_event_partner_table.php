<?php

use yii\db\Migration;

/**
 * php yii migrate/create create_event_partner_table --fields="event_id:integer:notNull:foreignKey(event_general_info),name:string(255):notNull,images:blob"
 *
 * Handles the creation of table `event_partner`.
 * Has foreign keys to the tables:
 *
 * - `event_general_info`
 */
class m180525_055639_create_event_partner_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('event_partner', [
            'id' => $this->primaryKey(),
            'event_id' => $this->integer()->notNull(),
            'name' => $this->string(255)->notNull(),
            'images' => 'BLOB',
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        // creates index for column `event_id`
        $this->createIndex(
            'idx-event_partner-event_id',
            'event_partner',
            'event_id'
        );

        // add foreign key for table `event_general_info`
        $this->addForeignKey(
            'fk-event_partner-event_id',
            'event_partner',
            'event_id',
            'event_general_info',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `event_general_info`
        $this->dropForeignKey(
            'fk-event_partner-event_id',
            'event_partner'
        );

        // drops index for column `event_id`
        $this->dropIndex(
            'idx-event_partner-event_id',
            'event_partner'
        );

        $this->dropTable('event_partner');
    }
}
