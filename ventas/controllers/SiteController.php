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
use yii\helpers\Html;
use yii\helpers\ActiveForm;
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
    // Ensure the layout is set for the index page
    $this->layout = 'main-login';

    // Check if the user is authenticated
    if (Yii::$app->user->isGuest) {
        return $this->redirect(['site/login']);
    }

    // Retrieve the identity of the logged-in user
    $user = Yii::$app->user->identity;

    // Check if user identity is null (should ideally not happen if user is authenticated)
    if ($user === null) {
        throw new \yii\web\ServerErrorHttpException('User identity not found.');
    }

    // Get user details assuming 'privilegio' and 'username' attributes exist in identity
    $privilegio = $user->privilegio;
    $username = $user->username;

    // Prepare data based on user's privilege level
    $data = [];
    if ($privilegio == 1) {
        // Logic for privilegio 1
        // Example: $data = Model::findAll(['user_id' => $user->id]);
        $data = []; // Replace with actual data retrieval logic
    } elseif ($privilegio == 2) {
        // Logic for privilegio 2
        // Example: $data = EventModel::findAll();
        $data = []; // Replace with actual data retrieval logic
    } else {
        // Default or other privilege levels logic
        $data = []; // Replace with actual data retrieval logic
    }

    // Render the index view and pass the retrieved data
    return $this->render('index', [
        'username' => $username,
        'data' => $data,
    ]);
}


    public function actionLogin()
    {
        $this->layout = 'main-login';
        $model = new LoginForm();
    
        // Set the page title to the application name
        $this->view->title = Yii::$app->name;
        // Handle AJAX validation requests
        if (Yii::$app->request->isAjax && Yii::$app->request->post('ajax') === 'login-form') {
            echo ActiveForm::validate($model);
            Yii::$app->end();
        }
    
        // Collect user input data
        if ($model->load(Yii::$app->request->post())) {
            // Validate user input and attempt to login
            if ($model->validate() && $model->login()) {
                // Obtener el privilegio del usuario
                $user = Yii::$app->user->identity;
                $privilegio = $user->privilegio;
    
                // Check the user's privilegio
                if ($privilegio == 2) {
                    // Ensure evento is provided
                    if (!empty($model->evento)) {
                        // Store evento in session
                        Yii::$app->session->set('evento', $model->evento);
    
                        // Redirect users with privilegio 2 to the specific page after evento validation
                        return $this->redirect(['ventas/index']); // Change to your desired redirection page
                    } else {
                        // Handle case where evento is required but not provided
                        $model->addError('evento', 'Evento is required.');
                    }
                } elseif ($privilegio == 1) {
                    // Redirect users with privilegio 1 to usuarios/index
                    return $this->redirect(['usuarios/index']);
                } else {
                    // Handle other privilegio levels or default redirect
                    return $this->redirect(['site/index']); // Change to your default redirect action
                }
    
                // Initialize dynamic connection string (specific to your application)
                Yii::$app->dynamicConnString->init();
            }
        }
    
        // Render the login form with the LoginForm model
        return $this->render('log', ['model' => $model]);
    }
    
    public function actionGetEventos()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        
        // Retrieve privilegio from usuarios.audaz using the entered user
        $username = Yii::$app->request->post('username');
        $model = Yii::$app->db->createCommand("
            SELECT privilegio
            FROM usuarios
            WHERE username = :username
        ")->bindValue(':username', $username)->queryOne();
    
        // Check if the query returned a result
        if ($model) {
            // Extract privilegio from the result
            $privilegio = $model['privilegio'];
    
            // Check if privilegio is 2
            if ($privilegio == 2) {
                // Retrieve eventos from cat_eventos
                $eventos = Yii::$app->db->createCommand("
                    SELECT id_evento, evento
                    FROM cat_eventos
                ")->queryAll();
    
                // Initialize an array to store eventos
                $eventosList = ArrayHelper::map($eventos, 'id_evento', 'evento');
    
                // Generate HTML for dropdown list of eventos
                $dropdown = Html::dropDownList('LoginForm[id_evento]', '', $eventosList, ['prompt' => 'Seleccionar Evento...', 'class' => 'form-control']);
                return [
                    'success' => true,
                    'dropdown' => $dropdown,
                ];
            } else {
                // If privilegio is not 2, create an empty response
                return [
                    'success' => false,
                    'message' => 'No eventos for this privilegio',
                ];
            }
        } else {
            // If no user found, create an empty response
            return [
                'success' => false,
                'message' => 'User not found',
            ];
        }
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