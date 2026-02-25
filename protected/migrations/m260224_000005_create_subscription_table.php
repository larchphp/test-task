<?php

class m260224_000005_create_subscription_table extends CDbMigration
{
	public function safeUp()
	{
		$this->createTable('subscription', array(
			'id' => 'pk',
			'author_id' => 'INT NOT NULL',
			'phone' => 'VARCHAR(20) NOT NULL',
			'created_at' => 'DATETIME NOT NULL',
		), 'ENGINE=InnoDB DEFAULT CHARSET=utf8mb4');

		$this->addForeignKey(
			'fk_subscription_author', 'subscription', 'author_id',
			'author', 'id', 'CASCADE', 'CASCADE'
		);
		$this->createIndex(
			'idx_subscription_author_phone', 'subscription',
			'author_id, phone', true
		);
	}

	public function safeDown()
	{
		$this->dropForeignKey('fk_subscription_author', 'subscription');
		$this->dropTable('subscription');
	}
}
