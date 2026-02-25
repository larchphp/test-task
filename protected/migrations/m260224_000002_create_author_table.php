<?php

class m260224_000002_create_author_table extends CDbMigration
{
	public function safeUp()
	{
		$this->createTable('author', array(
			'id' => 'pk',
			'full_name' => 'VARCHAR(255) NOT NULL',
		), 'ENGINE=InnoDB DEFAULT CHARSET=utf8mb4');
	}

	public function safeDown()
	{
		$this->dropTable('author');
	}
}
