<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "kelasnya".
 *
 * @property int $NOMORKELAS
 * @property string $NAMAKELAS
 */
class Kelas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kelasnya';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['NAMAKELAS'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'NOMORKELAS' => 'Nomorkelas',
            'NAMAKELAS' => 'Namakelas',
        ];
    }
}
