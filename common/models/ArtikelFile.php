<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "artikel_file".
 *
 * @property int $id
 * @property string $filename
 * @property int $id_artikel
 *
 * @property Artikel $artikel
 */
class ArtikelFile extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'artikel_file';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_artikel'], 'integer'],
            [['filename'], 'file', 'extensions' => ['pdf'], 'maxFiles' => 10, 'tooBig' => 'Batas File 1MB'],
            [['id_artikel'], 'exist', 'skipOnError' => true, 'targetClass' => Artikel::className(), 'targetAttribute' => ['id_artikel' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'filename' => 'Filename',
            'id_artikel' => 'Id Artikel',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArtikel()
    {
        return $this->hasOne(Artikel::className(), ['id' => 'id_artikel']);
    }
}
