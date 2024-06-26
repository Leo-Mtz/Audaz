<?php

namespace tests\unit\models;

use app\models\Ventas;
use app\models\CatProductos;
use yii\mail\MessageInterface;



class GetPrecioUnitarioTest extends \Codeception\Test\Unit
{
    private $model;
    public $tester;

    public function testGetPrecioUnitarioWithValidProductId()
    {
        $ventas = new Ventas();
        $precio = $ventas->getPrecioUnitario(2);
        $this->assertNotNull($precio);
        $this->assertIsNumeric($precio);
    }

    public function testGetPrecioUnitarioWithInvalidProductId()
    {
        $ventas = new Ventas();
        $precio = $ventas->getPrecioUnitario(9999);
        $this->assertNull($precio);
    }
}