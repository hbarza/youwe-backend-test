<?php

use yii\db\Migration;

/**
 * Handles the creation of table `order_message_relation`.
 * Has foreign keys to the tables:
 *
 * - `user`
 * - `message`
 * 
 * php yii migrate/create create_order_message_relation_table --fields="order_id:integer:notNull:foreignKey(sales_order),entity_id:integer:notNull,entity_type:integer(3):notNull,customer_id:integer:notNull:foreignKey(user),message_id:text:null"
 * 
 */
class m180913_165530_create_order_message_relation_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('order_message_relation', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer()->notNull(),
            'entity_id' => $this->integer()->notNull(),
            'entity_type' => $this->integer(3)->notNull(),
            'customer_id' => $this->integer()->notNull(),
            'message_id' => $this->text()->null(),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        // creates index for column `order_id`
        $this->createIndex(
            'idx-order_message_relation-order_id',
            'order_message_relation',
            'order_id'
        );

        // add foreign key for table `sales_order`
        $this->addForeignKey(
            'fk-order_message_relation-order_id',
            'order_message_relation',
            'order_id',
            'sales_order',
            'id',
            'CASCADE'
        );

        // creates index for column `entity_id`
        $this->createIndex(
            'idx-order_message_relation-entity_id',
            'order_message_relation',
            'entity_id'
        );

        // creates index for column `entity_type`
        $this->createIndex(
            'idx-order_message_relation-entity_type',
            'order_message_relation',
            'entity_type'
        );

        // creates index for column `customer_id`
        $this->createIndex(
            'idx-order_message_relation-customer_id',
            'order_message_relation',
            'customer_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-order_message_relation-customer_id',
            'order_message_relation',
            'customer_id',
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
            'fk-order_message_relation-customer_id',
            'order_message_relation'
        );

        // drops index for column `customer_id`
        $this->dropIndex(
            'idx-order_message_relation-customer_id',
            'order_message_relation'
        );

        // drops index for column `entity_id`
        $this->dropIndex(
            'idx-order_message_relation-entity_id',
            'order_message_relation'
        );

        // drops index for column `entity_type`
        $this->dropIndex(
            'idx-order_message_relation-entity_type',
            'order_message_relation'
        );

        // drops foreign key for table `sales_order`
        $this->dropForeignKey(
            'fk-order_message_relation-order_id',
            'order_message_relation'
        );

        // drops index for column `order_id`
        $this->dropIndex(
            'idx-order_message_relation-order_id',
            'order_message_relation'
        );

        $this->dropTable('order_message_relation');
    }
}
