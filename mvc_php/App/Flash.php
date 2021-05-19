<?php
namespace App;


/**
 * Mensagens Rápidas de Notificação (Flash Messages): mensagens apresentadas apenas uma vez numa sessão
 *
 * PHP version 7.3
 */
class Flash
{
    
    /**
     * Success message type
     * @var string
     */
    const SUCCESS = 'success';
    
    /**
     * Information message type
     * @var string
     */
    const INFO = 'info';
    
    /**
     * Warning message type
     * @var string
     */
    const WARNING = 'warning';
    
    /**
     * Danger message type
     * @var string
     */
    const DANGER = 'danger';

    /**
     * Adicionar uma mensagem
     *
     * @param string $mensagem  O conteúdo da mensagem
     *
     * @return void
     */
    public static function addMensagens($mensagem, $tipo = "success")
    {
        // Criar um array na sessão se ele não existir
        if (! isset($_SESSION['flash_notificacoes'])) {
            $_SESSION['flash_notificacoes'] = [];
        }
        
        // Incluir (ao final do array (append)) a mensagem
        $_SESSION['flash_notificacoes'][] = [
            'conteudo' => $mensagem,
            'tipo' => $tipo
        ];
    }
    
    /**
     * Recuperar todas as mensagens
     *
     * @return mixed  Um array com todas as mensagens ou null se não existir
     */
    public static function getMensagens()
    {
        if (isset($_SESSION['flash_notificacoes'])) {
            // return $_SESSION['flash_notificacoes'];
            
            $msgs = $_SESSION['flash_notificacoes'];
            unset($_SESSION['flash_notificacoes']);
            
            return $msgs;
        }
    }
    
    
}

