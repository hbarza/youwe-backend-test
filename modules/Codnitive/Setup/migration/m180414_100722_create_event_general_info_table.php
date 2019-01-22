<?php

use yii\db\Migration;

/**
 * command
 *
 * php yii migrate/create create_event_general_info_table --fields="user_id:integer:notNull:foreignKey(user),name:string(255):notNull,category:boolean:notNull,method:boolean:notNull,images:text,website:string(255),genre:integer(4),type:integer(4),start_date:date,end_date:date,description:text,country:string(2):notNull,division:string(200):notNull,city:string(200):notNull,address:string(512):notNull,primary_phone:string(14):notNull,secondary_phone:string(14),third_phone:string(14),seats:integer(8),email:string(255)"
 */
/**
 * Handles the creation of table `event_general_info`.
 * Has foreign keys to the tables:
 *
 * - `user`
 */
class m180414_100722_create_event_general_info_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('event_general_info', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'name' => $this->string(255)->notNull(),
            'category' => $this->integer(3), // for radio button options use 3
            'method' => $this->integer(3),
            // 'images' => $this->text(),
            'images' => 'BLOB',
            'genre' => 'BLOB', // as we save serilized array it must be binary field which is BOLB
            'type' => 'BLOB', // also we can use $this->binary(429496729) or somting like which is same as BOLB
            'start_date' => $this->date()->notNull(),
            'end_date' => $this->date()->notNull(),
            'description' => $this->text(),
            'country' => $this->string(2)->notNull(),
            'division' => $this->string(200)->notNull(),
            'city' => $this->string(200)->notNull(),
            'address' => $this->string(512)->notNull(),
            'primary_phone' => $this->string(14)->notNull(),
            'secondary_phone' => $this->string(14),
            'third_phone' => $this->string(14),
            'seats' => $this->integer(6),
            'email' => $this->string(255),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        // creates index for column `user_id`
        $this->createIndex(
            'idx-event_general_info-user_id',
            'event_general_info',
            'user_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-event_general_info-user_id',
            'event_general_info',
            'user_id',
            'user',
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
            'fk-event_general_info-user_id',
            'event_general_info'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            'idx-event_general_info-user_id',
            'event_general_info'
        );

        $this->dropTable('event_general_info');
    }
}
