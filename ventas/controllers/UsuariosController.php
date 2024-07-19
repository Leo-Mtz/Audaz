<?php

namespace app\controllers;

use Yii;
use app\models\Usuarios;
use app\models\UsuariosSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * UsuariosController implements the CRUD actions for Usuarios model.
 */
class UsuariosController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            // Access control to restrict actions based on roles
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    // Allowing certain actions only to admin
                    [
                        'allow' => true,
                        'actions' => ['index', 'view', 'create', 'update', 'delete', 'blank', 'pass', 'reset'],
                        'roles' => ['admin'],
                    ],
                    // Allowing 'blank' action to 'otro' role
                    [
                        'allow' => true,
                        'actions' => ['blank'],
                        'roles' => ['otro'],
                    ],
                ],
                // Deny callback throws a forbidden HTTP exception if access is denied
                'denyCallback' => function ($rule, $action) {
                    throw new ForbiddenHttpException();
                }
            ],
        ];
    }

    /**
     * Lists all Usuarios models.
     * @return mixed
     */
    public function actionIndex()
    {
        // Create a search model and data provider for listing users
        $searchModel = new UsuariosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        // Render the index view with the search model and data provider
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Renders a blank page.
     * @return mixed
     */
    public function actionBlank()
    {
        // Render the blank view
        return $this->render('blank');
    }

    /**
     * Displays a single Usuarios model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        // Render the view view with the model found by ID
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Usuarios model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Usuarios();

        // Load the data into the model
        if ($model->load(Yii::$app->request->post())) {
            $model->password = $this->createPassword();
            if ($model->validate()) {
                // Password validation rules
                if (strlen($model->password) < 8) {
                    $model->addError('password', 'ERROR: La contraseña debe contener al menos 8 caracteres');
                } elseif (!preg_match("#[0-9]+#", $model->password)) {
                    $model->addError('password', 'ERROR: La contraseña debe contener al menos un número');
                } elseif (!preg_match("#[A-Z]+#", $model->password)) {
                    $model->addError('password', 'ERROR: La contraseña debe contener al menos una letra mayúscula');
                } elseif (!preg_match("#[a-z]+#", $model->password)) {
                    $model->addError('password', 'ERROR: La contraseña debe contener al menos una letra minúscula');
                } elseif (!preg_match('/[#$%^&*()+=\-\[\]\';,.\/{}|":<>?~\\\\]/', $model->password)) {
                    $model->addError('password', 'ERROR: La contraseña debe contener al menos un carácter especial: #$%^&*()+=-[];,./{}|:<>?~');
                } elseif (preg_match("#(.*?)(12345678|87654321|ADMIN|HOLA|PASSWORD|CONTRA|ABCDEF)(.*?)#", strtoupper($model->password))) {
                    $model->addError('password', 'ERROR: La contraseña contiene palabras no permitidas');
                } else {
                    $pass = $model->password;
                    $model->save(false); // Save the model without further validation

                    // Assign role to the user
                    $auth = \Yii::$app->authManager;
                    $rol = $model->privilegio == 2 ? $auth->getRole('otro') : $auth->getRole('admin');
                    $auth->assign($rol, $model->getId());

                    // Email content for notifying the user
                    $cuerpoCorreo = '<p>Su cuenta para ingresar al Sistema del artículo 69 ha sido creada, puede ingresar en <a href="http://rfcalertas.claa.org.mx">http://rfcalertas.claa.org.mx</a></p><p>Su usuario y contraseña son :</p><ul><li>Usuario: '.$model->username.'</li><li>Contraseña: '.$pass.'</li></ul></p><br/><br/><p>Es responsabilidad de cada usuario el cuidado y uso de sus contraseñas. En el momento en que se hace la entrega de la contraseña se reitera que el usuario y contraseña son su responsabilidad, no debe compartirla y debe utilizarlas en apego a las políticas de seguridad establecidas.</p>';

                    // Send the email
                    Yii::$app->mailer->compose()
                        ->setFrom('alertas@claa.org.mx')
                        ->setTo($model->username)
                        ->setSubject('REGISTRO SISTEMA ARTICULO 69')
                        ->setHtmlBody($cuerpoCorreo)
                        ->send();

                    // Log the creation of the user
                    Yii::$app->utilFunctions->log(Yii::$app->user->identity->id, "CREAR USUARIO", "USUARIO ".$model->id." CREADO");

                    // Redirect to the view page of the created user
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }
        }

        // Render the create view with the model
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Usuarios model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        // Load the data into the model and save if valid
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            // Log the update action
            Yii::$app->utilFunctions->log(Yii::$app->user->identity->id, "ACTUALIZAR USUARIO", "USUARIO ".$model->id." ACTUALIZADO");
            // Redirect to the view page of the updated user
            return $this->redirect(['view', 'id' => $model->id]);
        }

        // Render the update view with the model
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Allows a user to change their password.
     * @param integer $id
     * @return mixed
     */
<<<<<<< HEAD
    public function actionDelete($id)
    {
<<<<<<< HEAD
		$model = $this->findModel($id);
=======
		
        $model = $this->findModel($id);
>>>>>>> main
        $this->findModel($id)->delete();
		
		Yii::$app->utilFunctions->log(Yii::$app->user->identity->id,"ELIMINAR USUARIO","USUARIO ".$model->id." ELIMINADO");

        return $this->redirect(['index']);
    }
	
	public function actionReset($id)
=======
    public function actionPass($id)
>>>>>>> main
    {
        $model = $this->findModel($id);

        // Load the data into the model
        if ($model->load(Yii::$app->request->post())) {
            $passAnterior = $model->_passAnterior; // Get the previous password
            $passNuevo = $model->_passNuevo; // Get the new password
            $passConfirmarNuevo = $model->_passConfirmarNuevo; // Confirm the new password

            // Validate the previous password
            if (Yii::$app->getSecurity()->validatePassword($passAnterior, $model->password)) {
                // Check if the new password and its confirmation match
                if ($passNuevo == $passConfirmarNuevo) {
                    // Password validation rules for the new password
                    if (strlen($passNuevo) < 8) {
                        $model->addError('pass', 'ERROR: El password debe ser mínimo de 8 caracteres, al menos una letra mayúscula, una letra minúscula, un número y un carácter especial');
                    } elseif (!preg_match("#[0-9]+#", $passNuevo)) {
                        $model->addError('pass', 'ERROR: El password debe ser mínimo de 8 caracteres, al menos una letra mayúscula, una letra minúscula, un número y un carácter especial');
                    } elseif (!preg_match("#[A-Z]+#", $passNuevo)) {
                        $model->addError('pass', 'ERROR: El password debe ser mínimo de 8 caracteres, al menos una letra mayúscula, una letra minúscula, un número y un carácter especial');
                    } elseif (!preg_match("#[a-z]+#", $passNuevo)) {
                        $model->addError('pass', 'ERROR: El password debe ser mínimo de 8 caracteres, al menos una letra mayúscula, una letra minúscula, un número y un carácter especial');
                    } elseif (!preg_match('/[#$%^&*()+=\-\[\]\';,.\/{}|":<>?~\\\\]/', $passNuevo)) {
                        $model->addError('pass', 'ERROR: El password debe ser mínimo de 8 caracteres, al menos una letra mayúscula, una letra minúscula, un número y un carácter especial');
                    } elseif (preg_match("#(.*?)(12345678|87654321|ADMIN|HOLA|PASSWORD|CONTRA|ABCDEF)(.*?)#", strtoupper($passNuevo))) {
                        $model->addError('pass', 'ERROR: El password debe ser mínimo de 8 caracteres, al menos una letra mayúscula, una letra minúscula, un número y un carácter especial');
                    } else {
                        $model->pass_actualizado = "1"; // Set the password updated flag
                        $model->password = Yii::$app->getSecurity()->generatePasswordHash($passNuevo); // Hash the new password
                        $model->save(); // Save the model
                        return $this->redirect(['usuarios/blank']); // Redirect to the blank page
                    }
                } else {
                    $model->addError('_passNuevo', 'La contraseña nueva no coincide');
                    $model->addError('_passConfirmarNuevo', 'La contraseña nueva no coincide');
                }
            } else {
                $model->addError('_passAnterior', 'La contraseña ingresada no coincide con la contraseña anterior');
            }
        }

        // Render the pass view with the model
        return $this->render('pass', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the Usuarios model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Usuarios the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        // Find the model by ID, throw an exception if not found
        if (($model = Usuarios::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
