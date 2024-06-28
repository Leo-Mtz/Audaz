<?php

namespace tests\unit\models;

<<<<<<< HEAD
use Yii;
use app\models\Ventas;
use PHPUnit\Framework\TestCase;

class getPrecioUnitarioTest extends \Codeception\Test\Unit
{
    private $model;

    protected function setUp(): void
    {
        parent::setUp();
        $this->model = new Ventas();
    }

    public function testGetPrecioUnitarioWithValidProductId()
    {
        $precio = $this->model->getPrecioUnitario(2);
=======
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
>>>>>>> main
        $this->assertNotNull($precio);
        $this->assertIsNumeric($precio);
    }

    public function testGetPrecioUnitarioWithInvalidProductId()
    {
<<<<<<< HEAD
        $precio = $this->model->getPrecioUnitario(9999);
=======
        $ventas = new Ventas();
        $precio = $ventas->getPrecioUnitario(9999);
>>>>>>> main
        $this->assertNull($precio);
    }
}