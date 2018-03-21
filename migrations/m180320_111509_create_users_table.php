<?php



use yii\db\Migration;

/**
 * Handles the creation of table `users`.
 *
 * 	php yii migrate --migrationPath=@yii/rbac/migrations
 */
class m180320_111509_create_users_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
 
        if ($this->db->driverName === 'mysql') {
			 // Тип БД, далее тип таблицы и стандартная кодировка для этой таблицы.
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
		
        $this->createTable('users', [
            'id' => $this->primaryKey(),
			'title' => $this->string(12)->notNull()->unique(),
            'body' => $this->text(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
		
		
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('users');
		//$this->dropTable('PBX_CDR');
    }
}
