<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "kelassemua".
 *
 * @property string $POSISI
 * @property int $NO_START
 * @property string $NAMA
 * @property string $TEAM
 * @property string $KELAS
 * @property string $KENDARAAN
 * @property string $KOTA
 */
class DaftarPeserta extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kelassemua';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['NO_START'], 'integer'],
            [['POSISI', 'NAMA', 'TEAM', 'KELAS', 'KENDARAAN', 'KOTA'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'POSISI' => 'Posisi',
            'NO_START' => 'No Start',
            'NAMA' => 'Nama',
            'TEAM' => 'Team',
            'KELAS' => 'Kelas',
            'KENDARAAN' => 'Kendaraan',
            'KOTA' => 'Kota',
        ];
    }
}
