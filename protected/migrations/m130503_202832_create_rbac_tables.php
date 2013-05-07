<?php

class m130503_202832_create_rbac_tables extends CDbMigration
{
	public function up()
	{
        // Create AuthItem table
        $this->createTable('tbl_auth_item', array(
            'name'=>'varchar(64) NOT NULL',
            'type'=>'integer NOT NULL',
            'description'=>'text',
            'bizrule'=>'text',
            'data'=>'text',
            'PRIMARY KEY (`name`)',
        ), 'ENGINE=InnoDB');
        
        // Create AuthItemChild table
        $this->createTable('tbl_auth_item_child', array(
            'parent'=>'varchar(64) NOT NULL',
            'child'=>'varchar(64) NOT NULL',
            'PRIMARY KEY (`parent`, `child`)',
        ), 'ENGINE=InnoDB');
        
        // Create AuthAssignment table
        $this->createTable('tbl_auth_assignment', array(
            'itemname'=>'varchar(64) NOT NULL',
            'userid'=>'int(11) NOT NULL',
            'bizrule'=>'text',
            'data'=>'text',
            'PRIMARY KEY (`itemname`, `userid`)',
        ), 'ENGINE=InnoDB');
        
        // tbl_auth_item_child.parent references tbl_auth_item.name
        $this->addForeignKey('fk_auth_item_child_parent', 'tbl_auth_item_child',
                'parent', 'tbl_auth_item', 'name', 'CASCADE', 'CASCADE');
        
        // tbl_auth_item_child.child references tbl_auth_item.name
        $this->addForeignKey('fk_auth_item_child_child', 'tbl_auth_item_child',
                'child', 'tbl_auth_item', 'name', 'CASCADE', 'CASCADE');
        
        // tbl_auth_assignment.itemname references tbl_auth_item.name
        $this->addForeignKey('fk_auth_assignment_itemname', 'tbl_auth_assignment',
                'itemname', 'tbl_auth_item', 'name', 'CASCADE', 'CASCADE');
        
        // tbl_auth_assignment.userid references tbl_user.id
        $this->addForeignKey('fk_auth_assignment_userid', 'tbl_auth_assignment',
                'userid', 'tbl_user', 'id', 'CASCADE', 'CASCADE');
	}

	public function down()
	{
		$this->truncateTable('tbl_auth_assignment');
        $this->truncateTable('tbl_auth_item_child');
        $this->truncateTable('tbl_auth_item');
        $this->dropTable('tbl_auth_assignment');
        $this->dropTable('tbl_auth_item_child');
        $this->dropTable('tbl_auth_item');
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