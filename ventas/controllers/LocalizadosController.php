<?php

namespace app\controllers;

use Yii;
use app\models\NoLocalizados;
use app\models\LocalizadosSearch;
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
 * LocalizadosController implements the CRUD actions for NoLocalizados model.
 */
class LocalizadosController extends Controller
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
     * Lists all NoLocalizados models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LocalizadosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single NoLocalizados model.
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
     * Creates a new NoLocalizados model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new NoLocalizados();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing NoLocalizados model.
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
     * Deletes an existing NoLocalizados model.
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
		$cuantos = NoLocalizados::find()
				->groupBy(['fecha_hora_registro'])
				->all();
		
		if( count($cuantos) === 2 ){
			$primero = $cuantos[0]->fecha_hora_registro;
			$segundo = $cuantos[1]->fecha_hora_registro;
			if( $primero < $segundo ){
				NoLocalizados::deleteAll(['fecha_hora_registro' => $primero]);
			}else{
				NoLocalizados::deleteAll(['fecha_hora_registro' => $segundo]);
			}
		}
		
		file_put_contents("noLocalizados.csv",file_get_contents("http://omawww.sat.gob.mx/cifras_sat/Documents/No%20localizados.csv"));
		
		// $csv = array_map('str_getcsv', file("noLocalizados.csv"));
		// array_shift($csv);
		
		$file = fopen('noLocalizados.csv', 'r');
		$csv = array();
		while (($line = fgetcsv($file)) !== FALSE) {
			array_push($csv,preg_replace( "/\r|\n|\\\\/", "", $line ));
		}
		fclose($file);
		array_shift($csv);
		
		$data = array();
		
		foreach( $csv as $k=>$v ){
			if( $v[0] != "" ){
				$data[] = [utf8_encode($v[0]),utf8_encode($v[1]),trim($v[2]),$v[3],date_format(date_create_from_format('d/m/Y', $v[4]), 'Y-m-d'),utf8_encode($v[5])];
			}
		}
		
		
		$filas = Yii::$app->db
				->createCommand()
				->batchInsert('no_localizados',['rfc','razon_social','tipo_persona','supuesto','fecha_primera_publicacion','entidad_federativa'],$data)
				->execute();
				
		$success = ($filas === count($data));
		
		unlink("noLocalizados.csv");
		
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
				$registro = NoLocalizados::find()
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
				$cuerpoCorreo .= "<p><b>Los siguinetes RFC se encontraron en la lista de No Localizados:</b></p>";
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
						->setSubject('Alerta No Localizados')
						->setHtmlBody($cuerpoCorreo)
						->send();
				
				if( $enviado ){
					$logAlerta = new LogAlertas();
					$logAlerta->fecha_hora_alerta = date('Y-m-d h:i:s');
					$logAlerta->correos_alerta = implode("|",$to);
					$logAlerta->correo = base64_encode($cuerpoCorreo);
					$logAlerta->tipo = "NO LOCALIZADOS";
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
		
		Yii::$app->utilFunctions->log(Yii::$app->user->identity->id,"DESCARGA NO LOCALIZADOS","NO LOCALIZADOS DESCARGADOS ".date('Y-m-d h:i:s'));
		
		print(json_encode($return));
    }

    /**
     * Finds the NoLocalizados model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return NoLocalizados the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = NoLocalizados::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
