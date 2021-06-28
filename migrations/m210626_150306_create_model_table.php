<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%model}}`.
 */
class m210626_150306_create_model_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%model}}', [
            'id' => $this->primaryKey(),
            'brand_id' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
            'slug' => $this->string()->notNull(),
            'created_at' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11)->notNull(),
        ]);

        $this->createIndex(
            'idx-model-brand_id',
            'model',
            'brand_id'
        );

        $this->addForeignKey(
            'fk-model-brand_id',
            'model',
            'brand_id',
            'brand',
            'id',
            'RESTRICT'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%model}}');
    }
}
