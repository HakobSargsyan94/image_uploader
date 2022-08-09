<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "upload_images".
 *
 * @property int $id
 * @property int|null $upload_id
 * @property string|null $image
 */
class UploadImages extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'upload_images';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['upload_id'], 'integer'],
            [['image'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'upload_id' => 'Upload ID',
            'image' => 'Image',
        ];
    }
}
