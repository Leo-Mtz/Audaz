<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cat_patentes".
 *
 * @property int $id
 * @property string|null $patente
 * @property string|null $agente_aduanal
 */
class CatPatentes extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cat_patentes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['agente_aduanal'], 'string'],
            [['patente'], 'string', 'max' => 4],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'patente' => 'Patente',
            'agente_aduanal' => 'Agente Aduanal',
        ];
    }
}
