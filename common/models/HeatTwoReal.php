<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "kelashasilheat2".
 *
 * @property int $POSISI
 * @property int $NO_START
 * @property string $NAMA
 * @property string $TEAM
 * @property int $KELAS
 * @property string $KENDARAAN
 * @property string $KOTA
 * @property double $RT
 * @property double $ET60
 * @property double $ET
 * @property double $SPEED
 * @property double $TIME
 */
class HeatTwoReal extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'kelashasilheat2';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['NO_START', 'KELAS'], 'integer'],
            [['RT', 'ET60', 'ET', 'SPEED', 'TIME'], 'number'],
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
