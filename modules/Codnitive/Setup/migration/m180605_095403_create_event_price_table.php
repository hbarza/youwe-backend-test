<?php

use yii\db\Migration;

/**
 * Handles the creation of table `event_price`.
 *
 * php yii migrate/create create_event_price_table --fields="event_id:integer:notNull:foreignKey(event_general_info),category_name:string(255):notNull,base_price:decimal(15,4):notNull,qty:integer(11):notNull,is_popular:boolean,comment:text"
 *
 * Has foreign keys to the tables:
 *
 * - `event_general_info`
 */
class m180605_095403_create_event_price_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('event_price', [
            'id' => $this->primaryKey(),
            'event_id' => $this->integer()->notNull(),
            'category_name' => $this->string(255)->notNull(),
            'base_price' => $this->decimal(15,4)->notNull(),
            'qty' => $this->integer(11)->notNull(),
            'is_popular' => $this->boolean(),
            'comment' => $this->text(),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        // creates index for column `event_id`
        $this->createIndex(
            'idx-event_price-event_id',
            'event_price',
            'event_id'
        );

        // add foreign key for table `event_general_info`
        $this->addForeignKey(
            'fk-event_price-event_id',
            'event_price',
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
            'fk-event_price-event_id',
            'event_price'
        );

        // drops index for column `event_id`
        $this->dropIndex(
            'idx-event_price-event_id',
            'event_price'
        );

        $this->dropTable('event_price');
    }
}
