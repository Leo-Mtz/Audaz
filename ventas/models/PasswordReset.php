<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "usuarios".
 *
 * @property int $id
 * @property string|null $username
 * @property string|null $password
 * @property string|null $authKey
 * @property int|null $privilegio
 * @property string|null $pass_actualizado
 */
class PasswordReset extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'usuarios';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['privilegio'], 'integer'],
            [['username', 'authKey'], 'string', 'max' => 45],
            [['password'], 'string', 'max' => 250],
            [['pass_actualizado'], 'string', 'max' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'authKey' => 'Auth Key',
            'privilegio' => 'Privilegio',
            'pass_actualizado' => 'Pass Actualizado',
        ];
    }
}
