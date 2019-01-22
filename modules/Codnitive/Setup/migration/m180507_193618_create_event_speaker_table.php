<?php

use yii\db\Migration;

/**
 * Handles the creation of table `event_speaker`.
 * Has foreign keys to the tables:
 *
 * php yii migrate/create create_event_speaker_table --fields="user_id:integer:notNull:foreignKey(user),event_id:integer:notNull:foreignKey(event_general_info),name:string(255):notNull,images:blob,about:text,facebook:string(512),instagram:string(512),linkedin:string(512),twitter:string(512)"
 *
 * - `user`
 * - `event_general_info`
 */
class m180507_193618_create_event_speaker_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('event_speaker', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'event_id' => $this->integer()->notNull(),
            'name' => $this->string(255)->notNull(),
            // 'images' => $this->blob(),
            'images' => 'BLOB',
            'about' => $this->text(),
            'facebook' => $this->string(512),
            'instagram' => $this->string(512),
            'linkedin' => $this->string(512),
            'twitter' => $this->string(512),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        // creates index for column `user_id`
        $this->createIndex(
            'idx-event_speaker-user_id',
            'event_speaker',
            'user_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-event_speaker-user_id',
            'event_speaker',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        // creates index for column `event_id`
        $this->createIndex(
            'idx-event_speaker-event_id',
            'event_speaker',
            'event_id'
        );

        // add foreign key for table `event_general_info`
        $this->addForeignKey(
            'fk-event_speaker-event_id',
            'event_speaker',
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
        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-event_speaker-user_id',
            'event_speaker'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            'idx-event_speaker-user_id',
            'event_speaker'
        );

        // drops foreign key for table `event_general_info`
        $this->dropForeignKey(
            'fk-event_speaker-event_id',
            'event_speaker'
        );

        // drops index for column `event_id`
        $this->dropIndex(
            'idx-event_speaker-event_id',
            'event_speaker'
        );

        $this->dropTable('event_speaker');
    }
}
