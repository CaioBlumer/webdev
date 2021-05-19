<?php
namespace Core;

use PDO;
use PDOException;
use App\Config;

abstract class Model
{

    /**
     * Pegar a conexão com o Banco de Dados usando PDO
     *
     * @return mixed
     */
    protected static function getConexaoBD()
    {
        static $connDB = null;

        if ($connDB === null) {

            $dsn = Config::BD_SGBD . ':host=' . Config::BD_SERVIDOR . ';dbname=' . Config::BD_NOME;
            $connDB = new PDO($dsn, Config::BD_USUARIO, Config::BD_SENHA);
            
            // Lançar uma Exceção quando erros acontecerem
            $connDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        return $connDB;
    }
}

