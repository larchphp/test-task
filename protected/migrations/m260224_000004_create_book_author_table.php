<?php

class m260224_000004_create_book_author_table extends CDbMigration
{
	public function safeUp()
	{
		$this->createTable('book_author', array(
			'book_id' => 'INT NOT NULL',
			'author_id' => 'INT NOT NULL',
			'PRIMARY KEY (book_id, author_id)',
		), 'ENGINE=InnoDB DEFAULT CHARSET=utf8mb4');

		$this->addForeignKey(
			'fk_book_author_book', 'book_author', 'book_id',
			'book', 'id', 'CASCADE', 'CASCADE'
		);
		$this->addForeignKey(
			'fk_book_author_author', 'book_author', 'author_id',
			'author', 'id', 'CASCADE', 'CASCADE'
		);
	}

	public function safeDown()
	{
		$this->dropForeignKey('fk_book_author_author', 'book_author');
		$this->dropForeignKey('fk_book_author_book', 'book_author');
		$this->dropTable('book_author');
	}
}
