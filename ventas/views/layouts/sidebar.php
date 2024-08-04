<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?=\yii\helpers\Url::home()?>" class="brand-link">
        <!--<img src="../images/IMG_1661.png" alt="TEMP" class="brand-image img-square elevation-3" style="opacity: .8">-->
        <img src="" alt="" class="brand-image img-square elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">SITE</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu --> 
        <nav class="mt-2">

            <?php
            $user = \app\models\Usuarios::findOne(Yii::$app->user->identity->id);
            
            if ($user->privilegio == "1") {
                echo \hail812\adminlte3\widgets\Menu::widget([
                    'items' => [
                        [
                            'label' => 'Usuarios',
                            'iconClass' => 'fa fa-fw fa-users',
                            'items' => [
                                [
                                    'label' => 'Crear Usuario',
                                    'url' => ['usuarios/create'],
                                    'iconClass' => 'fa fa-fw fa-plus',
                                    // 'visible' => \Yii::$app->user->can('verMenuCrearUsuario'),
                                ],
                                [
                                    'label' => 'Listado Usuarios',
                                    'url' => ['usuarios/index'],
                                    'iconClass' => 'fa fa-fw fa-list',
                                    // 'visible' => \Yii::$app->user->can('verMenuListarUsuarios'),
                                ],
                            ],
                            // 'visible' => \Yii::$app->user->can('verMenuUsuario'),
                        ],
                        [
                            'label' => 'Empleados',
                            'iconClass' => 'fa fa-fw fa-book',
                            'items' => [
                                [
                                    'label' => 'Agregar Empleado',
                                    'iconClass' => 'fa fa-fw fa-plus',
                                    'url' => ['empleados/create'],
                                    // 'visible' => \Yii::$app->user->can('verMenuCrearRfc'),
                                ],
                                [
                                    'label' => 'Listar Empleados',
                                    'iconClass' => 'fa fa-fw fa-list',
                                    'url' => ['empleados/index'],
                                    // 'visible' => \Yii::$app->user->can('verMenuListarRfcs'),
                                ],
                            ],
                            // 'visible' => \Yii::$app->user->can('verMenuRfc'),
                        ],
                        [
                            'label' => 'Eventos',
                            'iconClass' => 'fa fa-fw fa-calendar',
                            'items' => [
                                [
                                    'label' => 'Agregar Evento',
                                    'iconClass' => 'fa fa-fw fa-plus',
                                    'url' => ['eventos/create'],
                                    // 'visible' => \Yii::$app->user->can('verMenuCrearCorreo'),
                                ],
                                [
                                    'label' => 'Listar Eventos',
                                    'iconClass' => 'fa fa-fw fa-list',
                                    'url' => ['eventos/index'],
                                    // 'visible' => \Yii::$app->user->can('verMenuListarCorreos'),
                                ],
                            ],
                            // 'visible' => \Yii::$app->user->can('verMenuCorreo'),
                        ],
                        [
                            'label' => 'Presentaciones',
                            'iconClass' => 'fa fa-fw fa-industry',
                            'items' => [
                                [
                                    'label' => 'Agregar Presentación',
                                    'iconClass' => 'fa fa-fw fa-plus',
                                    'url' => ['presentaciones/create'],
                                    // 'visible' => \Yii::$app->user->can('verMenuCrearCorreo'),
                                ],
                                [
                                    'label' => 'Listar Presentaciones',
                                    'iconClass' => 'fa fa-fw fa-list',
                                    'url' => ['presentaciones/index'],
                                    // 'visible' => \Yii::$app->user->can('verMenuListarCorreos'),
                                ],
                            ],
                            // 'visible' => \Yii::$app->user->can('verMenuCorreo'),
                        ],
                        [
                            'label' => 'Productos',
                            'iconClass' => 'fa fa-fw fa-cart-plus',
                            'items' => [
                                [
                                    'label' => 'Agregar Producto',
                                    'iconClass' => 'fa fa-fw fa-plus',
                                    'url' => ['productos/create'],
                                    // 'visible' => \Yii::$app->user->can('verMenuCrearCorreo'),
                                ],
                                [
                                    'label' => 'Listar Productos',
                                    'iconClass' => 'fa fa-fw fa-list',
                                    'url' => ['productos/index'],
                                    // 'visible' => \Yii::$app->user->can('verMenuListarCorreos'),
                                ],
                            ],
                            // 'visible' => \Yii::$app->user->can('verMenuCorreo'),
                        ],
                        [
                            'label' => 'Sabores',
                            'iconClass' => 'fa fa-fw fa-at',
                            'items' => [
                                [
                                    'label' => 'Agregar Sabor',
                                    'iconClass' => 'fa fa-fw fa-plus',
                                    'url' => ['sabores/create'],
                                    // 'visible' => \Yii::$app->user->can('verMenuCrearCorreo'),
                                ],
                                [
                                    'label' => 'Listar Sabores',
                                    'iconClass' => 'fa fa-fw fa-list',
                                    'url' => ['sabores/index'],
                                    // 'visible' => \Yii::$app->user->can('verMenuListarCorreos'),
                                ],
                            ],
                            // 'visible' => \Yii::$app->user->can('verMenuCorreo'),
                        ],
                        
                        [
                            'label' => 'Entradas',
                            'iconClass' => 'fa fa-fw fa-share',
                            'items' => [
                                [
                                    'label' => 'Agregar Entrada',
                                    'iconClass' => 'fa fa-fw fa-plus',
                                    'url' => ['entradas/create'],
                                    // 'visible' => \Yii::$app->user->can('verMenuCrearCorreo'),
                                ],
                                [
                                    'label' => 'Listar Entradas',
                                    'iconClass' => 'fa fa-fw fa-list',
                                    'url' => ['entradas/index'],
                                    // 'visible' => \Yii::$app->user->can('verMenuListarCorreos'),
                                ],
                            ],

                        ],

                        [
                            'label' => 'Salidas ',
                            'iconClass' => 'fa fa-fw fa-reply',
                            'items' => [
                                [
                                    'label' => 'Agregar Salidas',
                                    'iconClass' => 'fa fa-fw fa-plus',
                                    'url' => ['salidas/create'],
                                    // 'visible' => \Yii::$app->user->can('verMenuCrearCorreo'),
                                ],
                                [
                                    'label' => 'Listar Salidas',
                                    'iconClass' => 'fa fa-fw fa-list',
                                    'url' => ['salidas/index'],
                                    // 'visible' => \Yii::$app->user->can('verMenuListarCorreos'),
                                ],
                            ],

                        ],


                        // [
                            // 'label' => 'Dev',
                            // 'iconClass' => 'fa fa-fw fa-bug',
                            // 'visible' => Yii::$app->user->identity->privilegio == 1,
                            // 'items' => [
                                // [
                                    // 'label' => 'Gii', 
                                    // 'icon' => 'file-code',
                                    // 'url' => ['/gii'],
                                    // 'target' => '_blank',
                                    // 'visible' => Yii::$app->user->identity->privilegio == 1
                                // ],
                                // [
                                    // 'label' => 'Debug',
                                    // 'icon' => 'bug',
                                    // 'url' => ['/debug'],
                                    // 'target' => '_blank',
                                    // 'visible' => Yii::$app->user->identity->privilegio == 1
                                // ],
                            // ]
                        // ],
                    ],
                ]);
            }


            if ($user->privilegio == "2") {

                echo \hail812\adminlte3\widgets\Menu::widget([
                    'items' => [
                        [
                            'label' => 'Ventas',
                            'iconClass' => 'fa fa-fw fa-cash-register',
                            'items' => [
                                [
                                    'label' => 'Registrar Venta',
                                    'url' => ['ventas/create'],
                                    'iconClass' => 'fa fa-fw fa-plus',
                                    // 'visible' => \Yii::$app->user->can('verMenuCrearUsuario'),
                                ],
                                [
                                    'label' => 'Listado Ventas',
                                    'url' => ['ventas/index'],
                                    'iconClass' => 'fa fa-fw fa-list',
                                    // 'visible' => \Yii::$app->user->can('verMenuListarUsuarios'),
                                ],

                                [
                                    'label' => 'Reporte de Ventas',
                                    'url' => ['reportes/index'],
                                    'iconClass' => 'fa fa-fw fa-book-open',

                                ],

                            ],
                            // 'visible' => \Yii::$app->user->can('verMenuUsuario'),
                        ],

                    ],
                ]);
            }
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
