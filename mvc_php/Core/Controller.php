<?php
namespace Core;

use App\Auth;
use App\Flash;

abstract class Controller
{

    /**
     * Parêmtros da rota encontrada
     *
     * @var array
     */
    protected $params_rota = [];

    /**
     * Classe constructor
     *
     * @param array $params_rota
     *            Parâmetros da rota encontrada
     *            
     * @return void
     */
    public function __construct($params_rota)
    {
        $this->params_rota = $params_rota;
    }

    /**
     * Magic method called when a non-existent or inaccessible method is
     * called on an object of this class.
     * Used to execute before and after
     * filter methods on action methods. Action methods need to be named
     * with an "Action" suffix, e.g. indexAction, showAction etc.
     *
     * @param string $name
     *            Method name
     * @param array $args
     *            Arguments passed to the method
     *            
     * @return void
     */
    public function __call($name, $args)
    {
        $method = $name . 'Action';

        if (method_exists($this, $method)) {
            if ($this->anterior() !== false) {
                call_user_func_array([
                    $this,
                    $method
                ], $args);
                $this->posterior();
            }
        } else {
            throw new \Exception("O método $method não foi encontrado no Controlador " . get_class($this));
        }
    }

    /**
     * Filtro Antes - chamado ANTES de executar o método de ação
     *
     * @return void
     */
    protected function anterior()
    {}

    /**
     * Filtro Depois - chamado DEPOIS da execução do método de ação
     *
     * @return void
     */
    protected function posterior()
    {}
    
    /**
     * Redirecionar para uma página diferente
     *
     * @param string $url  The relative URL
     *
     * @return void
     */
    public function redirecionar($url)
    {
        header('Location: http://' . $_SERVER['HTTP_HOST'] . $url, true, 303);
        exit;
    }
    
    /**
     * Obrigatório estar logado antes de acessar uma determinada página.
     * Salvar a página requisitada e depois redirecionar para a página de login.
     *
     * @return void
     */
    public function loginObrigatorio()
    {
        if (!Auth::getUser()) {
            Auth::salvarPaginaRetorno();
            Flash::addMensagens("Por favor, faça o login para acessar a página.", Flash::INFO);
            
            $this->redirecionar("/login");
        }
    }
}
