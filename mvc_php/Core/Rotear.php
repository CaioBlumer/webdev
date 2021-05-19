<?php
namespace Core;

/**
 * Rotear - responsavel por distribuir as requisicoes no App
 *
 * PHP version 7.3
 *
 * Autor: Daveh.io
 * Modified: Vinicius Ramos
 */
class Rotear
{

    /**
     * Vetor associativo de rotas (tabela de rotas)
     *
     * @var array
     */
    protected $rotas = [];

    /**
     * Vetor com os parâmteros da rota encontrada (match)
     *
     * @var array
     */
    protected $params = [];

    /**
     * Adicionar uma rota a tabela de rotas
     *
     * @param string $rota
     *            A URL da rota
     * @param array $params
     *            Parametros (controller, action, etc.)
     *            
     * @return void
     */
    public function add($rota, $params = [])
    {
        // Converter a rota em uma expressão regular: ignorar barra
        $rota = preg_replace('/\//', '\\/', $rota);

        // Converter variáveis, por exemplo, {controller}
        $rota = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[a-z-]+)', $rota);

        // Converter variáveis com uma expressão regular customizada, ex. {id:\d+}
        $rota = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?P<\1>\2)', $rota);

        // Adicionar delimitadores de início e de fim e indicação e
        // de não distinguir maiúsculas e minúsculas ('case insensitive')
        $rota = '/^' . $rota . '$/i';

        $this->rotas[$rota] = $params;
    }

    /**
     * Recuperar todas as rotas da Tabela de Rotas
     *
     * @return array
     */
    public function getRotas()
    {
        return $this->rotas;
    }

    /**
     * Igualar a rota às rotas da tabela de rotas,
     * determinando as propriedades dos parametros ($params)
     * se uma rota for encontrada
     *
     * @param string $url
     *            URL da rota
     *            
     * @return boolean true se encontrar uma rota, false caso contrario
     */
    public function match($url)
    {
        foreach ($this->rotas as $rota => $params) {
            if (preg_match($rota, $url, $matches)) {
                foreach ($matches as $key => $match) {
                    if (is_string($key)) {
                        $params[$key] = $match;
                    }
                }

                $this->params = $params;
                return true;
            }
        }

        return false;
    }

    /**
     * Pegar os parametros encontrados
     *
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * Encaminhar a rota, criar o objeto do controlador responsável e
     * executar o método de ação responsável
     *
     * @param string $url
     *            A URL da rota
     *            
     * @return void
     */
    public function dispatch($url)
    {
        $url = $this->removeQueryStringVariables($url);

        if ($this->match($url)) {
            $controller = $this->params['controller'];
            $controller = $this->convertToStudlyCaps($controller);
            // $controller = "App\Controllers\\$controller";
            $controller = $this->getNamespace() . $controller;

            if (class_exists($controller)) {
                $controller_object = new $controller($this->params);

                $action = $this->params['action'];
                $action = $this->convertToCamelCase($action);

                /*
                 * if (is_callable([$controller_object, $action])) {
                 * $controller_object->$action();
                 *
                 * } else {
                 * echo "Método $action (no controlador $controller) não encontrado!";
                 * }
                 */
                if (preg_match('/action$/i', $action) == 0) {
                    $controller_object->$action();
                } else {
                    throw new \Exception("O método $action do controlador $controller não pode ser acessado diretamente - remova o sufixo Action dessa chamada.");
                }
            } else {
                throw new \Exception("Classe Controladora $controller não encontrada!");
            }
        } else {
            throw new \Exception('Rota não encontrada.', 404);
        }
    }

    /**
     * Converter a string com hífens para StudlyCaps,
     * ex.
     * post-authors => PostAuthors
     *
     * @param string $string
     *            A string a ser convertida
     *            
     * @return string
     */
    protected function convertToStudlyCaps($string)
    {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
    }

    /**
     * Converter a string com hífens para camelCase,
     * e.g.
     * add-new => addNew
     *
     * @param string $string
     *            A string a ser convertida
     *            
     * @return string
     */
    protected function convertToCamelCase($string)
    {
        return lcfirst($this->convertToStudlyCaps($string));
    }

    /**
     * Remove the query string variables from the URL (if any).
     * As the full
     * query string is used for the route, any variables at the end will need
     * to be removed before the route is matched to the routing table. For
     * example:
     *
     * URL $_SERVER['QUERY_STRING'] Route
     * -------------------------------------------------------------------
     * localhost '' ''
     * localhost/? '' ''
     * localhost/?page=1 page=1 ''
     * localhost/posts?page=1 posts&page=1 posts
     * localhost/posts/index posts/index posts/index
     * localhost/posts/index?page=1 posts/index&page=1 posts/index
     *
     * A URL of the format localhost/?page (one variable name, no value) won't
     * work however. (NB. The .htaccess file converts the first ? to a & when
     * it's passed through to the $_SERVER variable).
     *
     * @param string $url
     *            The full URL
     *            
     * @return string The URL with the query string variables removed
     */
    protected function removeQueryStringVariables($url)
    {
        if ($url != '') {
            $parts = explode('&', $url, 2);

            if (strpos($parts[0], '=') === false) {
                $url = $parts[0];
            } else {
                $url = '';
            }
        }

        return $url;
    }

    /**
     * Recuperar o namespace para a classe controladora.
     * O namespace é definido nos parâmetros da rota e é adicionado
     * se ele existir na rota
     *
     * @return string A URL requisitada
     */
    protected function getNamespace()
    {
        $namespace = 'App\Controllers\\';

        if (array_key_exists('namespace', $this->params)) {
            $namespace .= $this->params['namespace'] . '\\';
        }

        return $namespace;
    }
}
