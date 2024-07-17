<?php
namespace app\models;

use Yii;
use yii\base\Model;
use app\models\CatEventos;
use app\models\Usuarios;
use yii\helpers\ArrayHelper;

use yii\helpers\Url;
class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;
    public $privilegio;
    public $eventos;
    public $id_evento;

    private $_user = false;

    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            ['rememberMe', 'boolean'],
            ['privilegio', 'integer'],
            ['id_evento', 'required', 'when' => function ($model) {
                return $model->privilegio == 2;
            }, 'whenClient' => "function (attribute, value) {
                return $('#loginform-privilegio').val() == 2;
            }"],
            ['password', 'validatePassword'],
        ];
    }

    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Usuario o contraseña incorrectos.');
            }
        }
    }

    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }
        return false;
    }

    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = Usuarios::findByUsername($this->username);
            if ($this->_user !== null) {
                $this->privilegio = $this->_user->privilegio;
                if ($this->privilegio == 2) {
                    $this->eventos = ArrayHelper::map(CatEventos::find()->all(), 'id_evento', 'evento');
                }
            }
        }
        return $this->_user;
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Usuario',
            'password' => 'Contraseña',
            'id_evento' => 'Evento',
            'rememberMe' => 'Recordarme'
        ];
    }
}


?>