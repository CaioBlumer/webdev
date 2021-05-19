<?php
namespace App\Controllers\Admin;

class Users extends \Core\Controller
{
    /**
     * Filtro Antes
     *
     * @return void
     */
    protected function anterior()
    {
        // TODO: User admin deve estar logado!
        if (!isset($_SESSION['logado'])) 
            return false;
    }
    
    public function indexAction() {
        echo 'User Admin index';
    }
}

