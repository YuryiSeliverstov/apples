<?php

    use yii\db\Migration;

    class m190124_110201_create_apples extends Migration
    {
		private $tableName='{{%apples}}';
        public function up()
        {
            $tableOptions = null;
            if ($this->db->driverName === 'mysql') 
			{
                // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
                $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
            }

            $this->createTable($this->tableName, [
                'id'                   => 	$this->primaryKey(),
                'color'		           => 	$this->string(255)->notNull()->comment('Цвет'),
				'weight_left'		   =>	$this->smallInteger(),
                'created_at' 		   => 	$this->bigInteger()->notNull()->comment('Дата создания'),
                'updated_at'           => 	$this->bigInteger(),
				'fall_at'			   =>	$this->bigInteger(),
            ], $tableOptions);
        }

        public function down()
        {
            $this->dropTable($this->tableName);
        }
    }
