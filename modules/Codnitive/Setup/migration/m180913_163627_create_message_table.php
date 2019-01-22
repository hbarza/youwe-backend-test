<?php

use yii\db\Migration;

/**
 * Handles the creation of table `message`.
 * 
 * php yii migrate/create create_message_table --fields="merchant_id:integer:notNull:foreignKey(user),message:text:notNull"
 * 
 */
class m180913_163627_create_message_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('message', [
            'id' => $this->primaryKey(),
            'merchant_id' => $this->integer()->notNull(),
            'message' => $this->text()->notNull(),
        ], 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB');

        // creates index for column `merchant_id`
        $this->createIndex(
            'idx-message-merchant_id',
            'message',
            'merchant_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-message-merchant_id',
            'message',
            'merchant_id',
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
            'fk-message-merchant_id',
            'message'
        );

        // drops index for column `merchant_id`
        $this->dropIndex(
            'idx-message-merchant_id',
            'message'
        );

        $this->dropTable('message');
    }
}
