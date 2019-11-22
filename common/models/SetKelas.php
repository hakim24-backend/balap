<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "kelas_set".
 *
 * @property int $NOMORKELAS
 * @property string $NAMAKELAS
 */
class SetKelas extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kelas_set';
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
