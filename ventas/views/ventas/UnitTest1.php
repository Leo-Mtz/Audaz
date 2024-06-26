<?php

namespace app\controllers;

use Yii;
use app\models\Ventas;
use app\Models\CatProductos;
use app\models\VentasSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

// Include the necessary files and classes

// Assuming the Ventas model is included and the getPrecioUnitario method exists
$ventas = new Ventas();

// Call the getPrecioUnitario method with a specific product ID
$precio = $ventas->getPrecioUnitario(2); // Replace 2 with the actual product ID

echo $precio; // Output the price retrieved by the method
