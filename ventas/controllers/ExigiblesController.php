<?php

namespace app\controllers;

use Yii;
use app\models\Exigibles;
use app\models\ExigiblesSearch;
use app\models\CorreosAlerta;
use app\models\LogAlertas;
use app\models\CatPatentes;
use app\models\Rfc;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

/**
 * ExigiblesController implements the CRUD actions for Exigibles model.
 */
class ExigiblesController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'delete', 'descarga'],
                'rules' => [
					[
						'allow' => true,
						'actions' => ['index', 'view', 'create', 'update', 'delete', 'descarga'],
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
     * Lists all Exigibles models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ExigiblesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Exigibles model.
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
     * Creates a new Exigibles model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Exigibles();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Exigibles model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Exigibles model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
	
	public function actionDescarga()
    {
		$cuantos = Exigibles::find()
				->groupBy(['fecha_hora_registro'])
				->all();
		
		if( count($cuantos) === 2 ){
			$primero = $cuantos[0]->fecha_hora_registro;
			$segundo = $cuantos[1]->fecha_hora_registro;
			if( $primero < $segundo ){
				Exigibles::deleteAll(['fecha_hora_registro' => $primero]);
			}else{
				Exigibles::deleteAll(['fecha_hora_registro' => $segundo]);
			}
		}

		file_put_contents("exigibles.csv",file_get_contents("http://omawww.sat.gob.mx/cifras_sat/Documents/Exigibles.csv"));
		
		// $csv = array_map('str_getcsv', file("exigibles.csv"));
		// array_shift($csv);
		
		$file = fopen('exigibles.csv', 'r');
		$csv = array();
		while (($line = fgetcsv($file)) !== FALSE) {
			array_push($csv,preg_replace( "/\r|\n|\\\\/", "", $line ));
		}
		fclose($file);
		array_shift($csv);
		
		$data = array();
		
		foreach( $csv as $k=>$v ){
			if( $v[0] != "" ){
				$data[] = [utf8_encode($v[0]),utf8_encode($v[1]),$v[2],$v[3],date_format(date_create_from_format('d/m/Y', $v[4]), 'Y-m-d'),utf8_encode($v[5])];
			}
		}
		
		$filas = Yii::$app->db
				->createCommand()
				->batchInsert('exigibles',['rfc','razon_social','tipo_persona','supuesto','fecha_primera_publicacion','entidad_federativa'],$data)
				->execute();
				
		$success = ($filas === count($data));
		
		unlink("exigibles.csv");
		
		$return = array();
		$alertas = 0;
		$cuerpoCorreo = "";

		if( $success ){
			$rfcs = Rfc::find()
				->where(['borrado' => 0])
				->indexBy('id')
				->all();
			
			$mails = array();
				
			foreach( $rfcs as $rfc ){
				$registro = Exigibles::find()
					->where(['rfc' => $rfc['rfc']])
					->andWhere(['LIKE','fecha_hora_registro',date('Y-m-d').'%',false])
					->all();
				
				if( is_array($registro) && !empty($registro) ){
					$mails[] = ArrayHelper::merge($rfc->attributes, $registro[0]->attributes);
				}
			}
			
			
			$correos = CorreosAlerta::find()
				->where(['borrado' => 0])
				->indexBy('id')
				->all();
			$to = array();
			foreach( $correos as $correo ){
				$to[] = $correo['correo'];
			}
			
			if( is_array($mails) && !empty($mails) ){
				$cuerpoCorreo .= "<p><b>Los siguientes RFC se encontraron en la lista de Exigibles:</b></p>";
				$cuerpoCorreo .= "<ul>";
					foreach( $mails as $mail ){					
						$cuerpoCorreo .= "<li><b>".$mail['rfc']."</b></li>";
						$cuerpoCorreo .= "<ul>";
							$cuerpoCorreo .= "<li><b>Razón Social:</b> ".$mail['razon_social']."</li>";
							// $patente = CatPatentes::findOne(['id' => $rfc['patente']]);
							// $cuerpoCorreo .= "<li><b>Patente:</b> ".$patente->patente."</li>";
							$cuerpoCorreo .= "<li><b>Agente Aduanal:</b> ".$mail['agente_aduanal']."</li>";
							$cuerpoCorreo .= "<li><b>Descripcion:</b> ".$mail['descripcion']."</li>";
							$cuerpoCorreo .= "<li><b>Tipo de persona:</b> ".$mail['tipo_persona']."</li>";
							$cuerpoCorreo .= "<li><b>Fecha de primera publicación:</b> ".date_format(date_create_from_format('Y-m-d', $mail['fecha_primera_publicacion']), 'd/m/Y')."</li>";
							$cuerpoCorreo .= "<li><b>Entidad Federativa:</b> ".$mail['entidad_federativa']."</li>";
						$cuerpoCorreo .= "</ul>";
					}
				$cuerpoCorreo .= "</ul>";
				
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
					$logAlerta->tipo = "EXIGIBLES";
					$logAlerta->save();
				}
				
				$alertas = count($mails);
			}
		
			$return = [
				'filas' => $filas,
				'alertas' => $alertas,
				'resultado' => 'OK',
				'correo' => $cuerpoCorreo
			];
		}else{
			$return = [
				'filas' => 0,
				'alertas' => $alertas,
				'resultado' => 'ERROR'
			];
		}
		
		Yii::$app->utilFunctions->log(Yii::$app->user->identity->id,"DESCARGA EXIGIBLES","EXIGIBLES DESCARGADOS ".date('Y-m-d h:i:s'));
		
		print(json_encode($return));
    }

    /**
     * Finds the Exigibles model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Exigibles the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Exigibles::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
