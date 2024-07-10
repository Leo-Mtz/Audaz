<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Ventas */

$this->title = 'Registro de Ventas';
$this->params['breadcrumbs'][] = ['label' => 'Ventas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ventas-create">


    <!-- This is a view for creating a new Ventas model -->
    <!-- It renders the '_form' view, which is a form for creating a new Ventas model -->
    <!-- The '_form' view takes the '$model' variable, which is the Ventas model being created, and several other variables: '$producto', which is a list of all the available productos, '$vendedor', which is a list of all the available vendedores, and '$evento', which is a list of all the available eventos -->
    <!-- The '$model' variable is used to populate the form fields with the data from the Ventas model -->
    <!-- The view also provides a way for the user to submit the form and create a new Ventas model -->
    <!-- The render() function is used to render the '_form' view and pass in the necessary variables -->
    <?= $this->render('_form', [
       
       
       'model'=>$model,
     'productosDropdown'=>$productosDropdown,
<<<<<<< HEAD
<<<<<<< HEAD
      'id_producto'=> $model->id_producto,
=======
=======
     'eventos'=>$eventos,
>>>>>>> main
      
>>>>>>> main
    
    ]) ?>

</div>
