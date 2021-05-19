<?php
namespace App;

use App\Models\User;

class Auth
{

    /**
     * Login do usuário
     *
     * @param User $usuario O Modelo do User
     *
     * @return void
     */
    public static function login($usuario)
    {
        session_regenerate_id(true);

        //$_SESSION['usuario_nome'] = $usuario->nome;
        $_SESSION['usuario_id'] = $usuario->id;
        $_SESSION['email'] = $usuario->email;
    }

    /**
     * Desconectar (logout) o usuário
     *
     * @return void
     */
    public static function logout()
    {
        $_SESSION = array();

        // If it's desired to kill the session, also delete the session cookie.
        // Note: This will destroy the session, and not just the session data!
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
                );
        }

        // Finally, destroy the session.
        session_destroy();
    }

    /**
     * Recuperar o usuário atual (corrente, deve estar logado) da sessão
     *
     * @return mixed The user model or null if not logged in
     */
    public static function getUser()
    {
        if (isset($_SESSION['usuario_id'])) {
            return User::findByID($_SESSION['usuario_id']);
        }
    }

    /**
     * Guardar na sessão a página originalmente requisitada pelo navegador
     *
     * @return void
     */
    public static function salvarPaginaRetorno()
    {
        $_SESSION['retornar_para'] = $_SERVER['REQUEST_URI'];
    }

    /**
     * Recuperar a página requisitada originalmente pelo navegador depois de requerer o login ou
     * voltar à página inicial
     *
     * @return void
     */
    public static function getPaginaRetorno()
    {
        return $_SESSION['retornar_para'] ?? '/';
    }
}
