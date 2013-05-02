<?php

class m130502_161617_modify_project_table extends CDbMigration
{
	public function up()
	{
        $this->addColumn(
                'tbl_project',
                'update_time',
                'datetime DEFAULT NULL AFTER `create_user_id`'
                );
	}

	public function down()
	{
		$this->dropColumn('tbl_project', 'update_time');
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}