<?php
namespace App\Controllers;

use \Core\View;
use App\Models\User;

class Signup extends \Core\Controller
{

    /**
     * Mostra a página de cadastro de usuários
     *
     * @return void
     */
    public function novoAction() {
        View::renderTemplate('Signup/register.html');
    }

    /**
     * Cadastrar novos usuários
     *
     * @return void
     */
    public function cadastrarAction() {
        $usuario = new User($_POST);

        if ($usuario->salvar()) {

            // Redirecionar para página de sucesso evitando reload e envio de dados novamente
            header('Location: http://'. $_SERVER['HTTP_HOST'].'/login/index', true, 303);
            exit;

        } else {
            View::renderTemplate('Signup/novo.html', [
                'usuario' => $usuario
            ]);
        }
    }

    /**
     * Sucesso ao cadastrar usuários
     *
     * @return void
     */
    public function sucessoAction() {
        View::renderTemplate('Signup/sucesso.html');
    }

}
