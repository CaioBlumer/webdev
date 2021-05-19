<?php
namespace App\Controllers;

use App\Models\User;
use Core\View;
use App\Flash;
use App\Auth;
use App\Models\AgendaM;
class Login extends \Core\Controller
{
    /**
     * Mostra a página principal do Login
     *
     * @return void
     */
    public function indexAction() {
        View::renderTemplate('Login/index.html');
    }

    /**
     * Responsável por fazer a consulta ao banco e fazer o login
     *
     * @return void
     */
    public function novoAction() {

        $usuario = User::autenticar($_POST['email'], $_POST['password']);

        if ($usuario) {

            Auth::login($usuario);

            Flash::addMensagens("Usuário logado com sucesso!");

            $this->redirecionar("/agenda/index");



        } else {

            Flash::addMensagens("Problemas ao fazer login. Verifique seu email e senha.", Flash::WARNING);

            View::renderTemplate('Login/index.html', [
                'email' => $_POST['email'],
            ]);
        }

    }

    /**
     * Log out a user
     *
     * @return void
     */
    public function sairAction()
    {
        Auth::logout();

        $this->redirecionar("/login/mostrar-mensagem-logout");

    }

    /**
     * Show a "logged out" flash message and redirect to the homepage. Necessary to use the flash messages
     * as they use the session and at the end of the logout method (destroyAction) the session is destroyed
     * so a new action needs to be called in order to use the session.
     *
     * @return void
     */
    public function mostrarMensagemLogoutAction()
    {
        Flash::addMensagens('Usuário desconectado!');

        $this->redirecionar("/");

    }
    public static function getEmail()
    {
        $usuario = User::autenticar($_POST['email'], $_POST['password']);
        return $usuario->email;
    }

}
