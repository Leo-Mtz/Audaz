<?php
namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\Usuarios;
use app\models\CatEventos;
use yii\helpers\ArrayHelper;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'main-login';
        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $user = Usuarios::findOne(['username' => trim($model->username)]);
            if ($user->privilegio == '1') {
                return $this->redirect(['usuarios/blank']);
            } else {
                if ($user->privilegio == '2') {
<<<<<<< HEAD
                    return $this->redirect(['site/log2']);
                }
                return $this->redirect(['ventas/index']);
=======
                    return $this->redirect(['ventas/index']);
                }
                
>>>>>>> main
            }
        }

        return $this->render('log', [
            'model' => $model,
        ]);
    }

    public function actionLog2()
    {
        $this->layout = 'main-login';
        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post())) {
            // Handle the form submission for selecting the event
            if ($model->validate() && $model->id_evento) {
                // Redirect or perform any action needed after selecting the event
<<<<<<< HEAD
                return $this->redirect(['ventas/index']);
=======
                return $this->redirect(['site/some-action']);
>>>>>>> main
            }
        }

        // Populate eventos list
        $model->eventos = ArrayHelper::map(CatEventos::find()->all(), 'id_evento', 'evento');

        return $this->render('log2', [
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->utilFunctions->log(Yii::$app->user->identity->id, "CERRAR SESIÓN", "USUARIO " . Yii::$app->user->identity->id . " CERRÓ SESIÓN");
        Yii::$app->user->logout();
        return $this->redirect(['index']);
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');
            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionAbout()
    {
        return $this->render('about');
    }
}


?>