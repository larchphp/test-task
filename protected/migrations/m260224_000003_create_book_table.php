<?php

class m260224_000003_create_book_table extends CDbMigration
{
	public function safeUp()
	{
		$this->createTable('book', array(
			'id' => 'pk',
			'title' => 'VARCHAR(255) NOT NULL',
			'year' => 'INT NULL',
			'description' => 'TEXT NULL',
			'isbn' => 'VARCHAR(20) NULL',
			'cover_image' => 'VARCHAR(255) NULL',
			'created_at' => 'DATETIME NOT NULL',
		), 'ENGINE=InnoDB DEFAULT CHARSET=utf8mb4');
	}

	public function safeDown()
	{
		$this->dropTable('book');
	}
}
