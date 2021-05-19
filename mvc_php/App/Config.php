<?php
namespace App;

class Config
{

    /**
     * Banco de Dados - Servidor
     * @var string
     */
    #const DB_HOST = 'localhost';
    const BD_SERVIDOR = 'localhost';

    /**
     * Banco de Dados - nome
     * @var string
     */
    const BD_NOME = 'avii_desenvweb';

    /**
     * Banco de Dados - usuário
     * @var string
     */
    const BD_USUARIO = 'root';

    /**
     * Banco de Dados - senha
     * @var string
     */
    const BD_SENHA = '';

    /**
    * Banco de Dados - SGBD
    * @var string
    */
    const BD_SGBD = 'mysql';

    /**
     * Mostrar ou esconder as mensagens de erro na tela
     * @var boolean
     */
    const SHOW_ERRORS = true;

}
