<?php

use yii\db\Migration;

/**
 * Handles the creation of table `PBX`.
 */
class m180321_145240_create_PBX_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
		
        /**
		 * ----------------------------------------------------------------------------------------------------
		 * |		Поле		|	
		 * |--------------------|------------------------------------------------------------------------------
		 * |   accountcode		| Какой учетный код используется: 
		 * |                    | account, (строка, 20 символов)
		 * |--------------------|------------------------------------------------------------------------------
		 * |   src				| Номер Caller*ID (строка, 80 символов)
		 * |--------------------|------------------------------------------------------------------------------
		 * |   dst				| Направление (строка, 80 символов)
		 * |--------------------|------------------------------------------------------------------------------
		 * |   dcontext			| Контекст направления (строка, 80 символов)
		 * |--------------------|------------------------------------------------------------------------------
		 * |   clid				| Caller*ID с текстом (80 символов)
		 * |--------------------|------------------------------------------------------------------------------
		 * |   channel			| Используемый канал (80 символов)
		 * |--------------------|------------------------------------------------------------------------------
		 * |   dstchannel		| Канал направления, если подходит (80 символов)
		 * |--------------------|------------------------------------------------------------------------------
		 * |   lastapp			| Последнее приложение, если подходит (80 символов)
		 * |--------------------|------------------------------------------------------------------------------
		 * |   lastdata			| Дата последнего приложения (аргументы) (80 символов)
		 * |--------------------|------------------------------------------------------------------------------
		 * |   start			| Начало вызова (дата/время)
		 * |--------------------|------------------------------------------------------------------------------
		 * |   answer			| Ответ вызова (дата/время)
		 * |--------------------|------------------------------------------------------------------------------
		 * |   end				| Конец вызова (дата/время)
		 * |--------------------|------------------------------------------------------------------------------
		 * |   duration			| Полное время в системе, в секундах (целое), от набора номера до отключения
		 * |--------------------|------------------------------------------------------------------------------
		 * |   billsec			| Полное время вызова, в секундах (целое), от ответа до отключения
		 * |--------------------|------------------------------------------------------------------------------
		 * |   disposition		| Что случилось с вызовом: ANSWERED, NO ANSWER, BUSY, FAILED (на некоторых CDR 
		 * |                    | выходных драйверах, например ODBC, они могут быть числовыми; заметьте, что 
		 * |                    | более детальная инфа может быть найдена в переменной диалплана $HANGUPCAUSE)
		 * |--------------------|------------------------------------------------------------------------------
		 * |   amaflags			| Какой флаг используется: смотри amaflags: DOCUMENTATION, BILLING, IGNORE 
		 * |                    | и т.д., указанного для каждого канала подобно accountcode.
		 * |--------------------|------------------------------------------------------------------------------
		 * |   user field		| Пользовательское поле, максимум 255 символов
		 * ----------------------------------------------------------------------------------------------------
         */
		 
		/*
		 * 	сalls – таблица с обработанными звонками. 
		 */
		$this->createTable('PBX_сalls', [
			'id' => 'pk',
			'server' => $this->integer(10)->notNull()->defaultValue(077),
			'calldate' => $this->dateTime()->unique()->defaultValue('1975-01-01 00:00:00'),
			'clid' => $this->string(80)->notNull()->unique(),
			'src' => $this->string(80)->notNull()->unique(),
			'src_arg' => $this->string(80)->notNull(),
			'dst' => $this->string(80)->notNull()->unique(),
			'dst_arg' => $this->string(80)->notNull(),
			'realdst' => $this->string(80)->notNull(),
			'dcontext' => $this->string(80)->notNull()->unique(),
			'channel' => $this->string(80)->notNull(),
			'dstchannel' => $this->string(80)->notNull(),
			'lastapp' => $this->string(80)->notNull(),
			'lastdata' => $this->string(80)->notNull(),
			'duration' => $this->integer(11)->defaultValue(0),
			'billsec' => $this->integer(11)->defaultValue(0),
			'disposition' => $this->string(45)->notNull(),	
			'amaflags' => $this->integer(11)->defaultValue(0),
			'remoteip' => $this->string(60)->notNull(),
			'accountcode' => $this->string(20)->notNull()->unique(),
			'peeraccount' => $this->string(20)->notNull(),
			'uniqueid' => 	$this->string(32)->notNull()->unique(),
			'userfield' => 	$this->string(255)->notNull(),
			'did' => 		$this->string(50)->notNull()->unique(),
			'linkedid' => 	$this->string(32)->notNull(),
			'sequence' => 	$this->integer(11)->defaultValue(0),
			'filename' => 	$this->string(255)->defaultValue('none'),
			'dirname' => 	$this->string(255)->defaultValue('none'),
        ], $tableOptions);

		/*
		 * 	Триггеры PBX_сalls
		 */
        if ($this->db->driverName === 'mysql') {
            $this->execute("DROP TRIGGER IF EXISTS `t_PBX_сalls`;
							DELIMITER //
							CREATE TRIGGER `t_PBX_сalls` BEFORE INSERT ON `PBX_сalls`
								FOR EACH ROW BEGIN
									IF ((NEW.dst = 's' OR NEW.dst = '~~s~~') AND NEW.realdst != '') THEN 
										SET NEW.dst = NEW.realdst;
									END IF;
								END
							//
			DELIMITER;");
        }
		
		/*
		 * 	price_russia – таблица с кодами регионов россии и ценами.
		 */
		$this->createTable('PBX_price_russia', [
			'id' => 'pk',
			'code' => $this->integer(10)->notNull()->unique()->comment('Код области'),
			'cost' => $this->string(10)->notNull()->comment('Цена'),
			'region' => $this->string(100)->notNull()->comment('Регион'),
        ], $tableOptions);
		
		$this->addCommentOnTable('PBX_price_russia', 'таблица с кодами регионов россии и ценами');
		
		/*
		 * 	price_international – таблица с кодами стран и ценами. 
		 */
		$this->createTable('PBX_price_international', [
			'id' => 'pk',
			'code' => $this->integer(10)->notNull()->unique()->comment('Код страны'),
			'price' => $this->string(10)->notNull()->comment('Цена'),
			'country' => $this->string(100)->notNull()->comment('Страна'),
        ], $tableOptions);
		
		$this->addCommentOnTable('PBX_price_international', 'таблица с кодами стран и ценами');
		
		/*
		 * 	clients — таблица с клиентами.
		 */
		$this->createTable('PBX_clients', [
			'id' => 'pk',
			'login' => $this->string(32)->notNull()->unique()->comment('Логин'),
			'password' => $this->string(32)->notNull()->comment('Пароль'),
			'email' => $this->string(40)->notNull()->comment('Email'),
			'rate' => $this->smallInteger(4)->notNull()->comment('Множитель'),
        ], $tableOptions);
		
		$this->addCommentOnTable('PBX_clients', 'таблица с клиентами');
		
		/*
		 * 	clients_ext – сопоставление клиентов и экстеншенов.
		 */
		$this->createTable('PBX_clients_ext', [
			'id' => 'pk',
			'login' => $this->string(32)->notNull(),
			'ext' => $this->integer(10)->notNull()->unique(),			
        ], $tableOptions);
		
		$this->addCommentOnTable('PBX_clients_ext', 'таблица сопоставления клиентов и экстеншенов');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('PBX_сalls');
		$this->dropTable('PBX_price_russia');
		$this->dropTable('PBX_price_international');
		$this->dropTable('PBX_clients');
		$this->dropTable('PBX_clients_ext');
		
    }
}
