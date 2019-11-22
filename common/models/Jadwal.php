<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "jadwal".
 *
 * @property int $id
 * @property string $name
 * @property string $location
 * @property string $date
 * @property string $time
 */
class Jadwal extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'jadwal';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id'], 'integer'],
            [['date', 'time'], 'safe'],
            [['name', 'location'], 'string', 'max' => 255],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Nama Acara',
            'location' => 'Lokasi',
            'date' => 'Tanggal',
            'time' => 'Waktu',
        ];
    }
}
