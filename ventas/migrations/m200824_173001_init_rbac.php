<?php

use yii\db\Migration;

/**
 * Class m200824_173001_init_rbac
 */
class m200824_173001_init_rbac extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
		$auth = Yii::$app->authManager;
		
		// add "agregarUsuario" permission
        $agregarUsuario = $auth->createPermission('agregarUsuario');
        $agregarUsuario->description = 'Agregar Usuario';
        $auth->add($agregarUsuario);

        // add "listarUsuarios" permission
        $listarUsuarios = $auth->createPermission('listarUsuarios');
        $listarUsuarios->description = 'Listar Usuarios';
        $auth->add($listarUsuarios);
		
		// add "verUsuario" permission
        $verUsuario = $auth->createPermission('verUsuario');
        $verUsuario->description = 'Ver Usuario';
        $auth->add($verUsuario);
		
		// add "editarUsuario" permission
        $editarUsuario = $auth->createPermission('editarUsuario');
        $editarUsuario->description = 'Editar Usuario';
        $auth->add($editarUsuario);
		
		// add "borrarUsuario" permission
        $borrarUsuario = $auth->createPermission('borrarUsuario');
        $borrarUsuario->description = 'Borrar Usuario';
        $auth->add($borrarUsuario);

        // add "agregarRfc" permission
        $agregarRfc = $auth->createPermission('agregarRfc');
        $agregarRfc->description = 'Agregar Rfc';
        $auth->add($agregarRfc);

        // add "listarRfcs" permission
        $listarRfcs = $auth->createPermission('listarRfcs');
        $listarRfcs->description = 'Listar Rfcs';
        $auth->add($listarRfcs);
		
		// add "verRfc" permission
        $verRfc = $auth->createPermission('verRfc');
        $verRfc->description = 'Ver Rfc';
        $auth->add($verRfc);
		
		// add "editarRfc" permission
        $editarRfc = $auth->createPermission('editarRfc');
        $editarRfc->description = 'Editar Rfc';
        $auth->add($editarRfc);
		
		// add "borrarRfc" permission
        $borrarRfc = $auth->createPermission('borrarRfc');
        $borrarRfc->description = 'Borrar Rfc';
        $auth->add($borrarRfc);
		
		// add "agregarCorreo" permission
        $agregarCorreo = $auth->createPermission('agregarCorreo');
        $agregarCorreo->description = 'Agregar Correo';
        $auth->add($agregarCorreo);

        // add "listarCorreos" permission
        $listarCorreos = $auth->createPermission('listarCorreos');
        $listarCorreos->description = 'Listar Correos';
        $auth->add($listarCorreos);
		
		// add "verCorreo" permission
        $verCorreo = $auth->createPermission('verCorreo');
        $verCorreo->description = 'Ver Correo';
        $auth->add($verCorreo);
		
		// add "editarCorreo" permission
        $editarCorreo = $auth->createPermission('editarCorreo');
        $editarCorreo->description = 'Editar Correo';
        $auth->add($editarCorreo);
		
		// add "borrarCorreo" permission
        $borrarCorreo = $auth->createPermission('borrarCorreo');
        $borrarCorreo->description = 'Borrar Correo';
        $auth->add($borrarCorreo);
		
		// add "verExigibles" permission
        $verExigibles = $auth->createPermission('verExigibles');
        $verExigibles->description = 'Ver Exigibles';
        $auth->add($verExigibles);
		
		// add "descargaExigibles" permission
        $descargaExigibles = $auth->createPermission('descargaExigibles');
        $descargaExigibles->description = 'Descarga Exigibles';
        $auth->add($descargaExigibles);
		
		// add "verFirmes" permission
        $verFirmes = $auth->createPermission('verFirmes');
        $verFirmes->description = 'Ver Firmes';
        $auth->add($verFirmes);
		
		// add "descargaFirmes" permission
        $descargaFirmes = $auth->createPermission('descargaFirmes');
        $descargaFirmes->description = 'Descarga Firmes';
        $auth->add($descargaFirmes);
		
		// add "verNoLocalizados" permission
        $verNoLocalizados = $auth->createPermission('verNoLocalizados');
        $verNoLocalizados->description = 'Ver Localizados';
        $auth->add($verNoLocalizados);
		
		// add "descargaNoLocalizados" permission
        $descargaNoLocalizados = $auth->createPermission('descargaNoLocalizados');
        $descargaNoLocalizados->description = 'Descarga No Localizados';
        $auth->add($descargaNoLocalizados);

        // add "otro" role and give this role the "agregarRfc" permission
        $otro = $auth->createRole('otro');
        $auth->add($otro);
        $auth->addChild($otro, $verExigibles);
        $auth->addChild($otro, $descargaExigibles);
        $auth->addChild($otro, $verFirmes);
        $auth->addChild($otro, $descargaFirmes);
        $auth->addChild($otro, $verNoLocalizados);
        $auth->addChild($otro, $descargaNoLocalizados);

        // add "admin" role and give this role the "updatePost" permission
        // as well as the permissions of the "author" role
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $agregarUsuario);
        $auth->addChild($admin, $listarUsuarios);
        $auth->addChild($admin, $verUsuario);
        $auth->addChild($admin, $editarUsuario);
        $auth->addChild($admin, $borrarUsuario);
        $auth->addChild($admin, $agregarRfc);
        $auth->addChild($admin, $listarRfcs);
        $auth->addChild($admin, $verRfc);
        $auth->addChild($admin, $editarRfc);
        $auth->addChild($admin, $borrarRfc);
		$auth->addChild($admin, $agregarCorreo);
        $auth->addChild($admin, $listarCorreos);
        $auth->addChild($admin, $verCorreo);
        $auth->addChild($admin, $editarCorreo);
        $auth->addChild($admin, $borrarCorreo);
		$auth->addChild($admin, $verExigibles);
        $auth->addChild($admin, $descargaExigibles);
        $auth->addChild($admin, $verFirmes);
        $auth->addChild($admin, $descargaFirmes);
        $auth->addChild($admin, $verNoLocalizados);
        $auth->addChild($admin, $descargaNoLocalizados);
        $auth->addChild($admin, $otro);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $auth = Yii::$app->authManager;

        $auth->removeAll();
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200824_173001_init_rbac cannot be reverted.\n";

        return false;
    }
    */
}
