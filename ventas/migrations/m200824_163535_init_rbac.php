<?php

use yii\db\Migration;

/**
 * Class m200824_163535_init_rbac
 */
class m200824_163535_init_rbac extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
		$auth = Yii::$app->authManager;
		

        // add "agregarRfc" permission
        $agregarRfc = $auth->createPermission('agregarRfc');
        $agregarRfc->description = 'Agregar Rfc';
        $auth->add($agregarRfc);

        // add "actualizarRfc" permission
        $actualizarRfc = $auth->createPermission('actualizarRfc');
        $actualizarRfc->description = 'Actualizar Rfc';
        $auth->add($actualizarRfc);

        // add "otro" role and give this role the "agregarRfc" permission
        $otro = $auth->createRole('otro');
        $auth->add($otro);
        $auth->addChild($otro, $agregarRfc);

        // add "admin" role and give this role the "updatePost" permission
        // as well as the permissions of the "author" role
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $actualizarRfc);
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
        echo "m200824_163535_init_rbac cannot be reverted.\n";

        return false;
    }
    */
}
