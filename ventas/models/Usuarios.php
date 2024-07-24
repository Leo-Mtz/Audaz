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
 * @property string|null $pass_actualizado
 * @property int|null $privilegio
 */
class Usuarios extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
	public $_passAnterior;
	public $_passNuevo;
	public $_passConfirmarNuevo;
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
            [['username', 'password', 'authKey', '_passAnterior', '_passNuevo', '_passConfirmarNuevo'], 'string', 'max' => 200],
			[['pass_actualizado'], 'string', 'max' => 1],
            [['username'], 'required','message' => 'Ingresar un usuario'],
            [['password'], 'required','message' => 'Ingresar una constraseña'],
            [['privilegio'], 'required','message' => 'Seleccionar un privilegio'],
            [['privilegio'], 'integer'],
            [['username'], 'unique','message' => 'El usuario ya esta registrado'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Usuario',
            'password' => 'Contraseña',
            'authKey' => 'Auth Key',
			'privilegio' => 'Privilegio',
			'_passAnterior' => 'Contraseña Anterior',
			'_passNuevo' => 'Contraseña Nueva',
			'_passConfirmarNuevo' => 'Confirmar Contraseña Nueva',
        ];
    }
	
	public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * Finds an identity by the given token.
     *
     * @param string $token the token to be looked for
     * @return IdentityInterface|null the identity object that matches the given token.
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // return static::findOne(['access_token' => $token]);
    }

    /**
     * @return int|string current user ID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string current user auth key
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @param string $authKey
     * @return bool if auth key is valid for current user
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }
	
	public static function findByUsername($username)
    {
        return self::findOne(['username'=>$username]);
    }

   
	
	public function validatePassword($password)
    {
		return Yii::$app->getSecurity()->validatePassword($password, $this->password);
        // return $this->password === $password;
    }
	
	public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
				$this->password = Yii::$app->getSecurity()->generatePasswordHash($this->password);
                $this->authKey = \Yii::$app->security->generateRandomString();
            }
            return true;
        }
        return false;
    }
}
