<?php

use yii\db\Migration;

/**
 * Class m180321_191316_start_fin_tables
 */
class m180321_191316_start_fin_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null; 
            if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }
		
        // Финансовые доски
        $this->createTable('{{%FIN_boards}}', [
            'id'   => $this->bigPrimaryKey(),
            'name' => $this->string(255)->notNull(),
            'dsc'  => $this->text(),
        ]);
         
        // Лист транзакций
        $this->createTable('{{%FIN_transaction_list}}', [
            'id'          => $this->bigPrimaryKey(),
            'board_id'    => $this->bigInteger()->notNull()->defaultValue(0),
            'user_id'     => $this->bigInteger()->notNull()->defaultValue(0),
            'dsc'         => $this->string(255)->notNull(),
            'val'         => $this->money(11, 2)->defaultValue(0),
            'date_add'    => $this->datetime()->notNull(),
            'date_update' => $this->datetime(),
        ]);
         
        // Состанвой индекс для листа транзакций
        $this->createIndex('transaction_list_key', '{{%FIN_transaction_list}}', ['board_id', 'user_id']);
         
        // связь досок и пользователей
        $this->createTable('{{%FIN_board_rel}}', [
            'board_id' => $this->bigInteger()->notNull()->defaultValue(0),
            'user_id'  => $this->bigInteger()->notNull()->defaultValue(0),
            'PRIMARY KEY(board_id, user_id)',
        ]);
         
        // Индекс для таблицы связей 'FIN_board_rel`
        $this->createIndex('idx_board_user_rel', '{{%FIN_board_rel}}', 'user_id');
         
        // категории транзакций
        $this->createTable('{{%FIN_transaction_cats}}', [
            'id'   => $this->bigPrimaryKey(),
            'name' => $this->string(255)->notNull(),
        ]);
         
        // связь транзакций и категорий
        $this->createTable('{{%FIN_cats_rel}}', [
            'transaction_id' => $this->bigInteger()->notNull()->defaultValue(0),
            'cat_id'         => $this->bigInteger()->notNull()->defaultValue(0),
            'PRIMARY KEY(transaction_id, cat_id)',
        ]);
         
        // Индекс для таблицы связей 'cats_rel`
        $this->createIndex('idx_transaction_cat_rel', '{{%FIN_cats_rel}}', 'transaction_id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        
        $this->dropTable('{{%FIN_boards}}');
        $this->dropTable('{{%FIN_transaction_list}}');
        $this->dropTable('{{%FIN_board_rel}}');
        $this->dropTable('{{%FIN_transaction_cats}}');
        $this->dropTable('{{%FIN_cats_rel}}');
		//echo "m180321_191316_start_fin_tables cannot be reverted.\n";
        //return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180321_191316_start_fin_tables cannot be reverted.\n";

        return false;
    }
    */
}
