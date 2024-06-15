<?php 


namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\Usuarios;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
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

    /**
     * {@inheritdoc}
     */
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

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {


        
    if (!Yii::$app->user->isGuest) {
        return $this->goHome();
    }

    $this->layout = 'main-login';
    $model = new LoginForm();

    $model = new LoginForm();
    
    if ($model->load(Yii::$app->request->post()) && $model->login()) {
        // If the user's password has not been updated, redirect them to the password reset page
        $user = Usuarios::findOne(['username' => trim($model->username)]);
        if ($user->privilegio == '1') {
            return $this->redirect(['usuarios/blank']);
        } else {
            return $this->redirect(['ventas/blank']);
        }
    }

    return $this->render('log', [
        'model' => $model,
    ]);

        // If the user is already logged in, redirect them to the homepage
        
        /*
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        */

        /*
        $this->layout = 'main-login';
        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            // If the user's password has not been updated, redirect them to the password reset page
            $user = Usuarios::findOne(['username' => trim($model->username)]);
            if ($user->pass_actualizado == '0') {
                return $this->redirect(['ventas/index', 'id' => $user->id]);
            } else {
                // Log the user's login and redirect them to the homepage
                // Yii::$app->utilFunctions->log(Yii::$app->user->identity->id, "INICIAR SESIÓN", "USUARIO " . Yii::$app->user->identity->id . " INICIÓ SESIÓN");
                return $this->redirect(['usuarios/blank']);
            }
        }

        return $this->render('log', [
            'model' => $model,
        ]);
        */
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
   
     public function actionLogin()
{
    if (!Yii::$app->user->isGuest) {
        return $this->goHome();
    }

    $this->layout = 'main-login';
    $model = new LoginForm();

    $model = new LoginForm();
    
    if ($model->load(Yii::$app->request->post()) && $model->login()) {
        // If the user's password has not been updated, redirect them to the password reset page
        $user = Usuarios::findOne(['username' => trim($model->username)]);
        if ($user->privilegio == '1') {
            return $this->redirect(['usuarios/blank']);
        } else {
            return $this->redirect(['ventas/index']);
        }
    }

    return $this->render('log', [
        'model' => $model,
    ]);
}
    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
		Yii::$app->utilFunctions->log(Yii::$app->user->identity->id,"CERRAR SESIÓN","USUARIO ".Yii::$app->user->identity->id." CERRÓ SESIÓN");
		
        Yii::$app->user->logout();

        $this->redirect(['index']);
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
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

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
