<?php

namespace tests\unit\models;

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
        $this->assertNotNull($precio);
        $this->assertIsNumeric($precio);
    }

    public function testGetPrecioUnitarioWithInvalidProductId()
    {
        $precio = $this->model->getPrecioUnitario(9999);
        $this->assertNull($precio);
    }
}