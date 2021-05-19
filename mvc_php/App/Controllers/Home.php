<?php
namespace App\Controllers;

use \Core\View;

/**
 * Posts controller
 *
 * PHP version 7.3
 * Author: Daveh.io
 * Modified: Vinicius Ramos
 */

class Home extends \Core\Controller{

    /**
     * Mostra a página principal do Home
     *
     * @return void
     */
    public function indexAction() {
        /* View::render('Home/index.php', [
            'name'    => 'Vinicius',
            'languages' => ['C', 'PHP', 'Python', 'Julia']
        ]); */

        View::renderTemplate('Home/index.html');
    }

    /**
     * Filtro Antes
     *
     * @return void
     */
    protected function anterior()
    {
        //echo "(ANTERIOR) ";
        //return false;
    }

    /**
     * Filtro Depois
     *
     * @return void
     */
    protected function posterior()
    {
        //echo " (POSTERIOR)";
    }
    public function aboutAction() {
        /* View::render('Home/index.php', [
            'name'    => 'Vinicius',
            'languages' => ['C', 'PHP', 'Python', 'Julia']
        ]); */

        View::renderTemplate('Home/about.html');
    }

}
