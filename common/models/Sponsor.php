<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "sponsor".
 *
 * @property int $id
 * @property string $filename
 * @property int $type 1 = web , 2 = mobile
 */
class Sponsor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sponsor';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type'], 'integer'],
            [['filename'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'No',
            'filename' => 'Gambar',
            'type' => 'Tipe',
        ];
    }
}
