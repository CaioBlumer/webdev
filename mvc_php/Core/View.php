<?php
namespace Core;

/**
 * View
 *
 * PHP version 7.3
 * Author: Daveh.io
 * Modified: Vinicius Ramos
 * 
 */
class View
{
    
    /**
     * Renderizar um arquivo de vista
     *
     * @param string $view  O arquivo de vista
     *
     * @return void
     */
    public static function render($view, $args = [])
    {
        extract($args, EXTR_SKIP);
        
        $file = "../App/Views/$view";  // relativo à pasta Core
        
        if (is_readable($file)) {
            require $file;
        } else {
            throw new \Exception("$file não encontrado!");
        }
    }
    
    /**
     * Renderizar uma vista de um template usando Twig
     *
     * @param string $template  O template
     * @param array $args  Array associativo de dados a serem mostrados na vista (opcional)
     *
     * @return void
     */
    public static function renderTemplate($template, $args = [])
    {
        static $twig = null;
        
        if ($twig === null) {
            //$loader = new \Twig_Loader_Filesystem('../App/Views');
            $loader = new \Twig\Loader\FilesystemLoader(dirname(__DIR__) . '/App/Views');
            $twig = new \Twig\Environment($loader);
            $twig->addGlobal('usuario_logado', \App\Auth::getUser());
            $twig->addGlobal('mensagens_flash', \App\Flash::getMensagens());
        }
        
        echo $twig->render($template, $args);
    }
    
}


