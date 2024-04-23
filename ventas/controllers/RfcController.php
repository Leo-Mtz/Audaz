<?php

namespace app\controllers;

use Yii;
use app\models\Rfc;
use app\models\RfcSearch;
use app\models\CatPatentes;
use app\models\Exigibles;
use app\models\Firmes;
use app\models\NoLocalizados;
use app\models\CorreosAlerta;
use app\models\LogAlertas;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

/**
 * RfcController implements the CRUD actions for Rfc model.
 */
class RfcController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'delete'],
                'rules' => [
					[
						'allow' => true,
						'actions' => ['index', 'view', 'create', 'update', 'delete'],
						'roles' => ['admin'],
					],
				],
				'denyCallback' => function ($rule, $action) {
					throw new \yii\web\ForbiddenHttpException;
				}
            ],
        ];
    }

    /**
     * Lists all Rfc models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new RfcSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Rfc model.
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
     * Creates a new Rfc model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Rfc();

        if( $model->load(Yii::$app->request->post()) ) {
			if( $model->validate() ){
				$rfc = $model->rfc;
				$correos = array();
				
				$exigibles = Exigibles::find()
						->where(['rfc' => $rfc])
						->orderBy('fecha_hora_registro DESC')
						->limit(1)
						->all();
				if( is_array($exigibles) && !empty($exigibles) ){
					foreach( $exigibles as $exigible ){
						$correos[] = $exigible->attributes;
					}
				}

				$firmes = Firmes::find()
						->where(['rfc' => $rfc])
						->orderBy('fecha_hora_registro DESC')
						->limit(1)
						->all();
				if( is_object($firmes) && !empty($firmes) ){
					foreach( $firmes as $k=>$firme ){
						
						$correos[] = $firme->attributes;
					}
				}
				
				$noLocalizados = NoLocalizados::find()
						->where(['rfc' => $rfc])
						->orderBy('fecha_hora_registro DESC')
						->limit(1)
						->all();
				if( is_array($noLocalizados) && !empty($noLocalizados) ){
					foreach( $noLocalizados as $noLocalizado ){
						$correos[] = $noLocalizado->attributes;
					}
				}
				
				if( is_array($correos) && !empty($correos) ){
					$correos['datos'] = $model->attributes;
					$cuerpoCorreo = "";
					$datos = $correos['datos'];
					unset($correos['datos']);
					
					$cuerpoCorreo .= "<p><b>Se encontró el RFC ".$datos['rfc']." en las siguientes listas:</b></p>";
					foreach( $correos as $correo ){					
						$cuerpoCorreo .= "<ul>";
							$cuerpoCorreo .= "<li><b>Supuesto:</b> ".$correo['supuesto']."</li>";
							$cuerpoCorreo .= "<li><b>Razón Social:</b> ".$correo['razon_social']."</li>";
							$patente = CatPatentes::findOne(['id' => $datos['patente']]);
							$cuerpoCorreo .= "<li><b>Patente:</b> ".$patente->patente."</li>";
							$cuerpoCorreo .= "<li><b>Agente Aduanal:</b> ".$datos['agente_aduanal']."</li>";
							$cuerpoCorreo .= "<li><b>Descripcion:</b> ".$datos['descripcion']."</li>";
							$cuerpoCorreo .= "<li><b>Tipo de persona:</b> ".$correo['tipo_persona']."</li>";
							$cuerpoCorreo .= "<li><b>Fecha de primera publicación:</b> ".date_format(date_create_from_format('Y-m-d', $correo['fecha_primera_publicacion']), 'd/m/Y')."</li>";
							$cuerpoCorreo .= "<li><b>Entidad Federativa:</b> ".$correo['entidad_federativa']."</li>";
						$cuerpoCorreo .= "</ul>";
					}
						
					$correos = CorreosAlerta::find()
						->where(['borrado' => 0])
						->all();
					$to = array();
					foreach( $correos as $correo ){
						$to[] = $correo['correo'];
					}
					
					$enviado = Yii::$app->mailer->compose()
									->setFrom('alertas@claa.org.mx')
									->setTo($to)
									->setSubject('Alerta Exigibles')
									->setHtmlBody($cuerpoCorreo)
									->send();
					
					if( $enviado ){
						$logAlerta = new LogAlertas();
						$logAlerta->fecha_hora_alerta = date('Y-m-d h:i:s');
						$logAlerta->correos_alerta = implode("|",$to);
						$logAlerta->correo = base64_encode($cuerpoCorreo);
						$logAlerta->tipo = "NUEVO RFC";
						$logAlerta->save();
					}
				}
				
				Yii::$app->utilFunctions->log(Yii::$app->user->identity->id,"CREAR RFC","RFC ".$model->id." CREADO");
			
				$model->save();
				return $this->redirect(['view', 'id' => $model->id]);
			}
        }
		
		$items = ArrayHelper::map(CatPatentes::find()->all(),'id','patente');
		asort($items);

        return $this->render('create', [
            'model' => $model,'items' => $items,
        ]);
    }

    /**
     * Updates an existing Rfc model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			Yii::$app->utilFunctions->log(Yii::$app->user->identity->id,"ACTUALZIAR RFC","RFC ".$model->id." ACTUALIZADO");
            return $this->redirect(['view', 'id' => $model->id]);
        }
		
		$items = ArrayHelper::map(CatPatentes::find()->all(),'id','patente');
		asort($items);
		
        return $this->render('update', [
            'model' => $model,'items' => $items,
        ]);
    }

    /**
     * Deletes an existing Rfc model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
		$model = $this->findModel($id);
		$model->updateAttributes(['borrado' => "1"]);
		
		Yii::$app->utilFunctions->log(Yii::$app->user->identity->id,"ELIMINAR RFC","RFC ".$model->id." ELIMINADO");

        return $this->redirect(['index']);
    }

    /**
     * Finds the Rfc model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Rfc the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Rfc::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('La página solicitada no existe.');
    }
}
