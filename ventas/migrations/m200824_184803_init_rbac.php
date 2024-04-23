<?php

use yii\db\Migration;

/**
 * Class m200824_184803_init_rbac
 */
class m200824_184803_init_rbac extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
		$auth = Yii::$app->authManager;
		
		// add "verMenuUsuario" permission
        $verMenuUsuario = $auth->createPermission('verMenuUsuario');
        $verMenuUsuario->description = 'Ver Menu usuario';
        $auth->add($verMenuUsuario);
		
		// add "verMenuCrearUsuario" permission
        $verMenuCrearUsuario = $auth->createPermission('verMenuCrearUsuario');
        $verMenuCrearUsuario->description = 'Ver Menu Crear Usuario';
        $auth->add($verMenuCrearUsuario);
		
		// add "verMenuListarUsuarios" permission
        $verMenuListarUsuarios = $auth->createPermission('verMenuListarUsuarios');
        $verMenuListarUsuarios->description = 'Ver Menu Listar Usuarios';
        $auth->add($verMenuListarUsuarios);
		
		// add "verMenuRfc" permission
        $verMenuRfc = $auth->createPermission('verMenuRfc');
        $verMenuRfc->description = 'Ver Menu Rfc';
        $auth->add($verMenuRfc);
		
		// add "verMenuCrearRfc" permission
        $verMenuCrearRfc = $auth->createPermission('verMenuCrearRfc');
        $verMenuCrearRfc->description = 'Ver Menu Crear Rfc';
        $auth->add($verMenuCrearRfc);
		
		// add "verMenuListarRfcs" permission
        $verMenuListarRfcs = $auth->createPermission('verMenuListarRfcs');
        $verMenuListarRfcs->description = 'Ver Menu Listar Rfcs';
        $auth->add($verMenuListarRfcs);
		
		// add "verMenuCorreo" permission
        $verMenuCorreo = $auth->createPermission('verMenuCorreo');
        $verMenuCorreo->description = 'Ver Menu Correo';
        $auth->add($verMenuCorreo);
		
		// add "verMenuCrearCorreo" permission
        $verMenuCrearCorreo = $auth->createPermission('verMenuCrearCorreo');
        $verMenuCrearCorreo->description = 'Ver Menu Crear Correo';
        $auth->add($verMenuCrearCorreo);
		
		// add "verMenuListarCorreos" permission
        $verMenuListarCorreos = $auth->createPermission('verMenuListarCorreos');
        $verMenuListarCorreos->description = 'Ver Menu Listar Correos';
        $auth->add($verMenuListarCorreos);
		
		// add "verMenuDescargas" permission
        $verMenuDescargas = $auth->createPermission('verMenuDescargas');
        $verMenuDescargas->description = 'Ver Menu Descargas';
        $auth->add($verMenuDescargas);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200824_184803_init_rbac cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200824_184803_init_rbac cannot be reverted.\n";

        return false;
    }
    */
}
