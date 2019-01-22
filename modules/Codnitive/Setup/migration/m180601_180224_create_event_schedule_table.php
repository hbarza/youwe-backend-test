<?php

use yii\db\Migration;

/**
 * Handles the creation of table `event_schedule`.
 *
 * php yii migrate/create create_event_schedule_table --fields="event_id:integer:notNull:foreignKey(event_general_info),day:integer(4):notNull,time:time,type:boolean:notNull,title:string(255),speaker:integer:foreignKey(event_speaker),title_heading:string(512),description:text"
 *
 * Has foreign keys to the tables:
 *
 * - `event_general_info`
 * - `event_speaker`
 */
class m180601_180224_create_event_schedule_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('event_schedule', [
            'id' => $this->primaryKey(),
            'event_id' => $this->integer()->notNull(),
            'day' => $this->integer(4)->notNull(),
            'time' => $this->time(),
            'type' => $this->boolean()->notNull(),
            'title' => $this->string(255),
            'speaker' => $this->integer(),
            'title_heading' => $this->string(512),
            'description' => $this->text(),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        // creates index for column `day`
        $this->createIndex(
            'idx-event_schedule-day',
            'event_schedule',
            'day'
        );

        // creates index for column `day`
        $this->createIndex(
            'idx-event_schedule-time',
            'event_schedule',
            'time'
        );

        // creates index for column `event_id`
        $this->createIndex(
            'idx-event_schedule-event_id',
            'event_schedule',
            'event_id'
        );

        // add foreign key for table `event_general_info`
        $this->addForeignKey(
            'fk-event_schedule-event_id',
            'event_schedule',
            'event_id',
            'event_general_info',
            'id',
            'CASCADE'
        );

        // creates index for column `speaker`
        $this->createIndex(
            'idx-event_schedule-speaker',
            'event_schedule',
            'speaker'
        );

        // add foreign key for table `event_speaker`
        $this->addForeignKey(
            'fk-event_schedule-speaker',
            'event_schedule',
            'speaker',
            'event_speaker',
            'id',
            'CASCADE'
        );


        // $this->insert('event_schedule', ['event_id' => 31,
        //     'day' => 2,
        //     'time' => '08:30',
        //     'type' => 1,
        //     'speaker' => 26,
        //     'title_heading' => 'title heading 2 2',
        //     'description' => 'description 2 2'
        // ]);
        // $this->insert('event_schedule', ['event_id' => 31,
        //     'day' => 1,
        //     'time' => '08:00',
        //     'type' => 1,
        //     'speaker' => 26,
        //     'title_heading' => 'title heading',
        //     'description' => 'description'
        // ]);
        // $this->insert('event_schedule', ['event_id' => 31,
        //     'day' => 2,
        //     'time' => '08:00',
        //     'type' => 0,
        //     'title' => 'breakfast',
        //     'title_heading' => 'title heading 2 1',
        //     'description' => 'description 2 1'
        // ]);
        // $this->insert('event_schedule', ['event_id' => 31,
        //     'day' => 1,
        //     'time' => '12:00',
        //     'type' => 1,
        //     'speaker' => 26,
        //     'title_heading' => 'title heading 2',
        //     'description' => 'description 2'
        // ]);
        // $this->insert('event_schedule', ['event_id' => 31,
        //     'day' => 1,
        //     'time' => '16:30',
        //     'type' => 0,
        //     'title' => 'dinner',
        //     'title_heading' => 'title heading',
        //     'description' => 'description'
        // ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `event_general_info`
        $this->dropForeignKey(
            'fk-event_schedule-event_id',
            'event_schedule'
        );

        // drops index for column `event_id`
        $this->dropIndex(
            'idx-event_schedule-event_id',
            'event_schedule'
        );

        // drops foreign key for table `event_speaker`
        $this->dropForeignKey(
            'fk-event_schedule-speaker',
            'event_schedule'
        );

        // drops index for column `speaker`
        $this->dropIndex(
            'idx-event_schedule-speaker',
            'event_schedule'
        );

        $this->dropTable('event_schedule');
    }
}
