<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%car}}`.
 */
class m210626_152403_create_car_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%car}}', [
            'id' => $this->primaryKey(),

            'brand_id' => $this->integer()->notNull(),
            'model_id' => $this->integer()->notNull(),
            'engine_id' => $this->integer()->notNull(),
            'drive_id' => $this->integer()->notNull(),

            'created_at' => $this->integer(11)->notNull(),
            'updated_at' => $this->integer(11)->notNull(),
        ]);

        /**
         * Brand key
         */
        $this->createIndex(
            'idx-car-brand_id',
            'car',
            'brand_id'
        );

        $this->addForeignKey(
            'fk-car-brand_id',
            'car',
            'brand_id',
            'brand',
            'id',
            'RESTRICT'
        );

        /**
         * Model key
         */
        $this->createIndex(
            'idx-car-model_id',
            'car',
            'model_id'
        );

        $this->addForeignKey(
            'fk-car-model_id',
            'car',
            'model_id',
            'model',
            'id',
            'RESTRICT'
        );

        /**
         * Engine key
         */
        $this->createIndex(
            'idx-car-engine_id',
            'car',
            'engine_id'
        );

        $this->addForeignKey(
            'fk-car-engine_id',
            'car',
            'engine_id',
            'engine',
            'id',
            'RESTRICT'
        );

        /**
         * Drive key
         */
        $this->createIndex(
            'idx-car-drive_id',
            'car',
            'drive_id'
        );

        $this->addForeignKey(
            'fk-car-drive_id',
            'car',
            'drive_id',
            'drive',
            'id',
            'RESTRICT'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%car}}');
    }
}
