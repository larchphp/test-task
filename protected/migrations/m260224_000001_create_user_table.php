<?php

class m260224_000001_create_user_table extends CDbMigration
{
	public function safeUp()
	{
		$this->createTable('user', array(
			'id' => 'pk',
			'username' => 'VARCHAR(255) NOT NULL',
			'password' => 'VARCHAR(255) NOT NULL',
			'email' => 'VARCHAR(255) NOT NULL',
			'created_at' => 'DATETIME NOT NULL',
		), 'ENGINE=InnoDB DEFAULT CHARSET=utf8mb4');

		$this->createIndex('idx_user_username', 'user', 'username', true);
		$this->createIndex('idx_user_email', 'user', 'email', true);
	}

	public function safeDown()
	{
		$this->dropTable('user');
	}
}
