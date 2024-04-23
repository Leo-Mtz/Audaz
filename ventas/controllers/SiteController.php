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
		// if (!Yii::$app->user->isGuest) {
			// return $this->goHome();
		// }
		
		
		$this->layout = 'main-login';
		$model = new LoginForm();
			
		if ($model->load(Yii::$app->request->post())){
			$user = Usuarios::find()->where(['username'=>trim($model->username)])->one();
			$model->login();
			if( is_object($user) && !empty($user) ){			
				if( $user->pass_actualizado == '0' ){
					return $this->redirect(['usuarios/pass','id'=>$user->id]);
				}else{
					Yii::$app->utilFunctions->log(Yii::$app->user->identity->id,"INICIAR SESIÓN","USUARIO ".Yii::$app->user->identity->id." INICIÓ SESIÓN");
					return $this->redirect(['usuarios/blank']);				
				}
			}
		}

		return $this->render('log', [
			'model' => $model,
		]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
       // if (!Yii::$app->user->isGuest) {
			// return $this->goHome();
		// }

		// $model = new LoginForm();
		// if ($model->load(Yii::$app->request->post()) && $model->login()) {
			// return $this->goBack();
		// }

		// return $this->render('log', [
			// 'model' => $model,
		// ]);
		return $this->render('index');
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
