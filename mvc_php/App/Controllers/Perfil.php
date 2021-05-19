<?php
namespace App\Controllers;

use Core\Controller;
use Core\View;
use App\Auth;
use App\Models\User;
use App\Flash;

class Perfil extends Controller
{
    /**
     * {@inheritDoc}
     * @see \Core\Controller::anterior()
     */
    protected function anterior()
    {
        $this->loginObrigatorio();

    }

    public function indexAction() {
        View::renderTemplate("Perfil/alterar.html", [
            'usuario'=> Auth::getUser()
        ]);
    }

    public function alterarAction() {
        $usuario = new User($_POST);

        if($usuario->alterar()) {
            Flash::addMensagens("Alteração realizada com sucesso!");
            $this->redirecionar("/perfil/index");
        } else {
            View::renderTemplate("Perfil/alterar.html", [
                'usuario'=> $usuario
            ]);
        }
    }
}
