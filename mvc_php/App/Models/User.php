<?php
namespace App\Models;

use PDO;
use PDOException;
use App\Auth;

class User extends \Core\Model
{

    /**
     * Mensagens de Erro
     *
     * @var array
     */
    public $errors = [];


    /**
     * Class constructor
     *
     * @param vetor $data Valores das propriedades iniciais
     *
     * @return void
     */
    public function __construct($data = [])
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        };
    }

    /**
     * Salvar o Usuário com as propriedades correntes
     *
     * @return void
     */
    public function salvar() {
      $this->validar();
        if (empty($this->errors)) {

            // Criar uma senha segura com função hash e salt
            $password_hash = password_hash($this->password, PASSWORD_DEFAULT);

            $sql = 'INSERT INTO mad_users (name, email, password, birth_date)
                VALUES (:name, :email, :password, :birth_date)';

            $db = static::getConexaoBD();

            $stmt = $db->prepare($sql);

            $stmt->bindValue(':name', $this->name, PDO::PARAM_STR);
            $stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
            $stmt->bindValue(':birth_date', $this->birthday, PDO::PARAM_STR);
            $stmt->bindValue(':password', $password_hash, PDO::PARAM_STR);

            return $stmt->execute();

        }
        return false;

    }

    /**
     * Validar os valores das propriedades atuais, adicionando mensagens de erro ao vetor de errors (property)
     *
     * @return void
     */
    public function validar()
    {
        // Nome
        if ($this->name == '') {
            $this->errors[] = 'Nome é obrigatório';
        }

        // email
        if (filter_var($this->email, FILTER_VALIDATE_EMAIL) === false) {
            $this->errors[] = 'Email inválido';
        }

        if (static::emailExists($this->email)) {
            $this->errors[] = 'Email já cadastrado no sistema';
        }

        // Senha
        /*if ($this->senha != $this->confirmacao) {
            $this->errors[] = 'Senha deve ser igual à Confirmação de Senha';
        }*/

        // Quantidade de caracteres
        if (strlen($this->password) < 4) {
            $this->errors[] = 'A senha deve conter, no mínimo, 4 caracteres';
        }

        // Mínimo de 1 letra
        if (preg_match('/.*[a-z]+.*/i', $this->password) == 0) {
            $this->errors[] = 'A senha deve conter, no mínimo, uma letra';
        }

        // Mínimo de 1 número
        if (preg_match('/.*\d+.*/i', $this->password) == 0) {
            $this->errors[] = 'A senha deve conter, no mínimo, um número';
        }
    }

    /**
     * Verificar se já existe o email cadastrado na base de dados
     *
     * @param string $email email a ser buscado na base de dados
     *
     * @return boolean  True se o registro existir com o email específico, false caso contrário
     */
    public static function emailExists($email)
    {
        return static::findByEmail($email) !== false;
    }

    /**
     * Buscar um usuário a partir do seu email
     *
     * @param string $email email a ser buscado na base de dados
     *
     * @return boolean  True se o registro existir com o email específico, false caso contrário
     */
    public static function findByEmail($email)
    {
        $sql = 'SELECT * FROM mad_users WHERE email = :email';

        $db = static::getConexaoBD();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();

        return $stmt->fetch();
    }

    public static function findByID($id)
    {
        $sql = 'SELECT * FROM mad_users WHERE id = :id';

        $db = static::getConexaoBD();
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        $stmt->setFetchMode(PDO::FETCH_CLASS, get_called_class());

        $stmt->execute();

        return $stmt->fetch();
    }

    /**
     * Autenticação (Auth) do usuário pelo email e senha
     *
     * @param string $email email
     * @param string $senha senha
     *
     * @return mixed  O objeto Usuário (User) ou falso se der errado
     */
    public static function autenticar($email, $senha)
    {
        $usuario = static::findByEmail($email);

        if ($usuario) {
            if (password_verify($senha, $usuario->password)) {
                return $usuario;
            }
        }

        return false;

    }

    /**
     * Salvar o Usuário com as propriedades correntes
     *
     * @return void
     */
    public function alterar() {


        $this->validarAlteracao();

        if (empty($this->errors)) {

            $usuarioAtual = Auth::getUser();

            if(isset($this->senha) && $this->senha != "") {
                $sql = 'UPDATE mad_users SET name=:nome, email=:email, password=:senha_hash
                    WHERE id=:id';
            } else {
                 $sql = 'UPDATE mad_users SET name=:nome, email=:email
                    WHERE id=:id';
            }

            $db = static::getConexaoBD();

            $stmt = $db->prepare($sql);

            $stmt->bindValue(':nome', $this->nome, PDO::PARAM_STR);
            $stmt->bindValue(':email', $this->email, PDO::PARAM_STR);
            $stmt->bindValue(':id', $usuarioAtual->id, PDO::PARAM_INT);

            if(isset($this->senha) && $this->senha != "") {
                // Criar uma senha segura com função hash e salt
                $password_hash = password_hash($this->senha, PASSWORD_DEFAULT);
                $stmt->bindValue(':senha_hash', $password_hash, PDO::PARAM_STR);
            }

            return $stmt->execute();

        }
        return false;

    }

    /**
     * Validar os valores das propriedades atuais, adicionando mensagens de erro ao vetor de errors (property)
     *
     * @return void
     */
    public function validarAlteracao()
    {
        // Nome
        if ($this->nome == '') {
            $this->errors[] = 'Nome é obrigatório';
        }

        // email
        if (filter_var($this->email, FILTER_VALIDATE_EMAIL) === false) {
            $this->errors[] = 'Email inválido';
        }

        $usuarioAtual = Auth::getUser();
        if ($this->email != $usuarioAtual->email) {
            if (static::emailExists($this->email)) {
                $this->errors[] = 'Email já cadastrado no sistema';
            }
        }


        if(isset($this->senha) && $this->senha != "") {
            // Quantidade de caracteres
            if (strlen($this->senha) < 4) {
                $this->errors[] = 'A senha deve conter, no mínimo, 4 caracteres';
            }

            // Mínimo de 1 letra
            if (preg_match('/.*[a-z]+.*/i', $this->senha) == 0) {
                $this->errors[] = 'A senha deve conter, no mínimo, uma letra';
            }

            // Mínimo de 1 número
            if (preg_match('/.*\d+.*/i', $this->senha) == 0) {
                $this->errors[] = 'A senha deve conter, no mínimo, um número';
            }
        }
    }

    public static function get_pacients() {

      $db = static::getConexaoBD();

      $stmt = $db->query('SELECT id, name FROM mad_users WHERE is_doctor = 0');
      $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

      return $results;
    }

}
