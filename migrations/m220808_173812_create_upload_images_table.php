<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%upload_images}}`.
 */
class m220808_173812_create_upload_images_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%upload_images}}', [
            'id' => $this->primaryKey(),
            'upload_id' => $this->integer(),
            'image' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%upload_images}}');
    }
}
