<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "kelashasilheat2_use".
 *
 * @property int $POSISI
 * @property int $NO_START
 * @property string $NAMA
 * @property string $TEAM
 * @property int $KELAS
 * @property string $KENDARAAN
 * @property string $KOTA
 * @property int $RT
 * @property int $ET60
 * @property int $ET
 * @property int $SPEED
 * @property int $TIME
 */
class HeatTwo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kelashasilheat2_use';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['NO_START', 'KELAS', 'RT', 'ET60', 'ET', 'SPEED', 'TIME'], 'integer'],
            [['NAMA', 'TEAM', 'KENDARAAN', 'KOTA'], 'string', 'max' => 255],
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
            'RT' => 'Rt',
            'ET60' => 'Et60',
            'ET' => 'Et',
            'SPEED' => 'Speed',
            'TIME' => 'Time',
        ];
    }
}
