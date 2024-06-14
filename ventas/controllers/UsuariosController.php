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
        // return [
            // 'access' => [
                // 'class' => AccessControl::className(),
                // 'only' => ['index', 'view', 'create', 'update', 'delete', 'blank'],
                // 'rules' => [
                    // [
                        // 'allow' => true,
                        // 'actions' => ['index', 'view', 'create', 'update', 'delete', 'blank'],
                        // 'roles' => ['@'],
                    // ],
                // ],
				// 'denyCallback' => function ($rule, $action) {
					// throw new \Exception('No tiene permiso para acceder a esta página');
				// }
            // ],
        // ];
		return [
			'access' => [
				'class' => AccessControl::className(),
				'rules' => [
					[
						'allow' => true,
						'actions' => ['index', 'view', 'create', 'update', 'delete', 'blank', 'pass', 'reset'],
						'roles' => ['admin'],
					],
					[
						'allow' => true,
						'actions' => ['blank'],
						'roles' => ['otro'],
					],
				],

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
        $searchModel = new UsuariosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	
	public function actionBlank()
    {
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

        if ( $model->load(Yii::$app->request->post()) ) {		
			$model->password = $this->createPassword();
			if( $model->validate() ){			
				if( strlen($model->password) < 8 ){
					$model->addError('password','ERROR: La contraseña de contener al menos 8 caracteres');
				}elseif( !preg_match("#[0-9]+#",$model->password) ){
					$model->addError('password','ERROR: La contraseña de contener al menos un número');
				}elseif( !preg_match("#[A-Z]+#",$model->password) ){
					$model->addError('password','ERROR: La contraseña de contener al menos una letra mayuscula');
				}elseif( !preg_match("#[a-z]+#",$model->password) ){
					$model->addError('password','ERROR: La contraseña de contener al menos una letra minúscula');
				}elseif( !preg_match('/[#$%^&*()+=\-\[\]\';,.\/{}|":<>?~\\\\]/',$model->password) ){
					$model->addError('password','ERROR: La contraseña de contener al menos un carácter especial: #$%^&*()+=-[];,./{}|:<>?~');
				}elseif( preg_match("#(.*?)(12345678|87654321|ADMIN|HOLA|PASSWORD|CONTRA|ABCDEF)(.*?)#", strtoupper($model->password)) ){
					$model->addError('password','ERROR: La contraseña contiene palabaras no permitidas');
				}else{
					$pass = $model->password;

					$model->save(false);
				
					$auth = \Yii::$app->authManager;
					if( $model->privilegio == 2 ){
						$rol = $auth->getRole('otro');
					}else{
						$rol = $auth->getRole('admin');
					}
					$auth->assign($rol, $model->getId());
					
					$cuerpoCorreo = '<p>Su cuenta para ingresar al Sistema del artículo 69 ha sido creada, puede ingresar en <a href="http://rfcalertas.claa.org.mx">http://rfcalertas.claa.org.mx</a></p><p>Su usuario y contrase&ntilde;a son :</p><ul><li>Usuario: '.$model->username.'</li><li>Contrase&ntilde;a: '.$pass.'</li></ul></p><br/><br/><p>Es responsabilidad de cada usuario el cuidado y uso de sus contraseñas. En el momento en que se hace la entrega de la contraseña se reitera que el usuario y contraseña son su responsabilidad, no debe compartirla y debe utilizarlas en apego a las políticas de seguridad establecidas.</p>';
					
					Yii::$app->mailer->compose()
							 ->setFrom('alertas@claa.org.mx')
							 ->setTo($model->username)
							 ->setSubject('REGISTRO SISTEMA ARTICULO 69')
							 ->setHtmlBody($cuerpoCorreo)
							 ->send();
							 
					Yii::$app->utilFunctions->log(Yii::$app->user->identity->id,"CREAR USUARIO","USUARIO ".$model->id." CREADO");
					
					return $this->redirect(['view', 'id' => $model->id]);
				}
			}
        }

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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			Yii::$app->utilFunctions->log(Yii::$app->user->identity->id,"ACTUALIZAR USUARIO","USUARIO ".$model->id." ACTUALIZADO");
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }
	
	public function actionPass($id)
    {
        $model = $this->findModel($id);
			
		if( $model->load(Yii::$app->request->post()) ){
			$passAnterior = $model->_passAnterior;
			$passNuevo = $model->_passNuevo;
			$passConfirmarNuevo = $model->_passConfirmarNuevo;
			if( Yii::$app->getSecurity()->validatePassword($passAnterior, $model->password) ){
				if( $passNuevo == $passConfirmarNuevo ){
					if( strlen($passNuevo) < 8 ){
						$model->addError('pass','ERROR: El password debe ser mínimo de 8 caracteres, al menos una letra mayúscula, una letra minúscula, un número y un carácter especial');
					}elseif( !preg_match("#[0-9]+#",$passNuevo) ){
						$model->addError('pass','ERROR: El password debe ser mínimo de 8 caracteres, al menos una letra mayúscula, una letra minúscula, un número y un carácter especial');
					}elseif( !preg_match("#[A-Z]+#",$passNuevo) ){
						$model->addError('pass','ERROR: El password debe ser mínimo de 8 caracteres, al menos una letra mayúscula, una letra minúscula, un número y un carácter especial');
					}elseif( !preg_match("#[a-z]+#",$passNuevo) ){
						$model->addError('pass','ERROR: El password debe ser mínimo de 8 caracteres, al menos una letra mayúscula, una letra minúscula, un número y un carácter especial');
					}elseif( !preg_match('/[#$%^&*()+=\-\[\]\';,.\/{}|":<>?~\\\\]/',$passNuevo) ){
						$model->addError('pass','ERROR: El password debe ser mínimo de 8 caracteres, al menos una letra mayúscula, una letra minúscula, un número y un carácter especial');
					}elseif( preg_match("#(.*?)(12345678|87654321|ADMIN|HOLA|PASSWORD|CONTRA|ABCDEF)(.*?)#", strtoupper($passNuevo)) ){
						$model->addError('pass','ERROR: El password debe ser mínimo de 8 caracteres, al menos una letra mayúscula, una letra minúscula, un número y un carácter especial');
					}else{
						$model->pass_actualizado = "1";
						$model->password = Yii::$app->getSecurity()->generatePasswordHash($passNuevo);
						$model->save();
						// echo "<pre>";
						// print_r($model);
						// die();
						// return $this->redirect(['view', 'id' => $model->id]);
						
						return $this->redirect(['usuarios/blank']);
					}
				}else{
					$model->addError('_passNuevo','La contraseña nueva no coincide');
					$model->addError('_passConfirmarNuevo','La contraseña nueva no coincide');
				}
			}else{
				$model->addError('_passAnterior','La contraseña ingresada no coincide con la contraseña anterior');
			}
        }

        return $this->render('pass', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Usuarios model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
		
		Yii::$app->utilFunctions->log(Yii::$app->user->identity->id,"ELIMINAR USUARIO","USUARIO ".$model->id." ELIMINADO");

        return $this->redirect(['index']);
    }
	
	public function actionReset($id)
    {
        $model = $this->findModel($id);
		$model->password = $this->createPassword();
		if( $model->validate() ){
			if( (strlen($model->password) >= 8) && (preg_match("#[0-9]+#",$model->password)) && (preg_match("#[A-Z]+#",$model->password)) && (preg_match("#[a-z]+#",$model->password)) && (preg_match('/[#$%^&*()+=\-\[\]\';,.\/{}|":<>?~\\\\]/',$model->password)) && (!preg_match("#(.*?)(12345678|87654321|ADMIN|HOLA|PASSWORD|CONTRA|ABCDEF)(.*?)#", strtoupper($model->password))) ){
				$pass = $model->password;
				$model->password = Yii::$app->getSecurity()->generatePasswordHash($model->password);
				$model->pass_actualizado = '0';

				$model->save(false);
				
				$cuerpoCorreo = '<p>Se reinicio su contraseña para ingresar al Sistema del artículo 69, puede ingresar en <a href="http://rfcalertas.claa.org.mx">http://rfcalertas.claa.org.mx</a></p><p>Su usuario y contrase&ntilde;a son :</p><ul><li>Usuario: '.$model->username.'</li><li>Contrase&ntilde;a: '.$pass.'</li></ul></p>';
				
				Yii::$app->mailer->compose()
						 ->setFrom('alertas@claa.org.mx')
						 ->setTo($model->username)
						 ->setSubject('CAMBIO CONTRASEÑA SISTEMA ARTICULO 69')
						 ->setHtmlBody($cuerpoCorreo)
						 ->send();
				
				// return $this->redirect(['view', 'id' => $model->id]);
				return $this->redirect(['index']);
			}	
		}
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
        if (($model = Usuarios::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
	
	function createPassword()
	{
	    $mayusculas = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	    $minusculas = "abcdefghijklmanopqrstuvwxyz";
	    $numeros = "0123456789";
	    $cEspecial = "#$%&";
		$mayusculas = substr(str_shuffle( $mayusculas ),0, 3 );
		$minusculas = substr(str_shuffle( $minusculas ),0, 2 );
		$numeros = substr(str_shuffle( $numeros ),0, 2 );
		$cEspecial = substr(str_shuffle( $cEspecial ),0, 1 );
	    $password = $mayusculas.$minusculas.$numeros.$cEspecial;
	    return str_shuffle($password); 
	}
}
