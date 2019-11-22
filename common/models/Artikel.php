<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "artikel".
 *
 * @property int $id
 * @property string $judul
 * @property string $konten
 * @property string $datetime_created
 * @property string $gambar
 *
 * @property ArtikelFile[] $artikelFiles
 */
class Artikel extends \yii\db\ActiveRecord
{
    public $file;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'artikel';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['konten'], 'string'],
            [['file'], 'file', 'extensions' => ['pdf'], 'maxFiles' => 10, 'tooBig' => 'Batas File 1MB'],
            [['gambar'], 'file', 'extensions' => ['jpg', 'jpeg', 'png'], 'maxFiles' => 1, 'tooBig' => 'Batas File 1MB'],
            [['datetime_created'], 'safe'],
            [['judul'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'judul' => 'Judul',
            'konten' => 'Konten',
            'datetime_created' => 'Dibuat pada',
            'gambar' => 'Gambar',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArtikelFiles()
    {
        return $this->hasMany(ArtikelFile::className(), ['id_artikel' => 'id']);
    }
}
