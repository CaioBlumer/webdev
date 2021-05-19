<?php
namespace App\Models;

use PDO;
use PDOException;
use App\Auth;

class AgendaM extends \Core\Model
{
    public static function get_pacients() {

      $db = static::getConexaoBD();

      $stmt = $db->query('SELECT id, name FROM mad_users WHERE is_doctor = 0');
      $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

      return $results;
    }
    public static function get_consults($dId) {
      $db = static::getConexaoBD();
      $stmt = $db->query('SELECT * FROM mad_appointment WHERE doctor_id = '.$dId);

      $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

      return $results;
    }

    public static function update_consult($consult_data, $type, $comment, $id) {

      // Criar uma senha segura com função hash e salt
     $sql = 'UPDATE mad_appointment SET consult_date=:data, type=:type, comment=:comment WHERE id = :id';

     $db = static::getConexaoBD();

     $stmt = $db->prepare($sql);

     $stmt->bindValue(':data', $consult_data, PDO::PARAM_STR);
     $stmt->bindValue(':type', $type, PDO::PARAM_STR);
     $stmt->bindValue(':comment', $comment, PDO::PARAM_STR);
     $stmt->bindValue(':id', $id, PDO::PARAM_STR);

     $stmt->execute();


    }

    //deleta/cancela a consulta
    public static function delete_consult($id){

      $sql = 'DELETE FROM mad_appointment WHERE id = :id;';
      $db = static::getConexaoBD();

      $stmt = $db->prepare($sql);
      $stmt->bindValue(':id', $id, PDO::PARAM_STR);
      $stmt->execute();

    }

    public static function createConsult($pacient_name, $appoint_date, $type, $comment, $doctorid, $pacient_id) {
      $sql = "INSERT INTO mad_appointment (pacient, consult_date, type, comment, doctor_id, user_id) VALUES (:pacient, :consult_date, :type, :comment, :doctor_id, :user_id)";
      $db = static::getConexaoBD();

      $stmt = $db->prepare($sql);

      $stmt->bindValue(':pacient', $pacient_name, PDO::PARAM_STR);
      $stmt->bindValue(':consult_date', $appoint_date, PDO::PARAM_STR);
      $stmt->bindValue(':type', $type, PDO::PARAM_STR);
      $stmt->bindValue(':comment', $comment, PDO::PARAM_STR);
      $stmt->bindValue(':doctor_id', $doctorid, PDO::PARAM_STR);
      $stmt->bindValue(':user_id', $pacient_id, PDO::PARAM_STR);

      $stmt->execute();


    }


    public static function get_consults_pacient($id) {
      $db = static::getConexaoBD();
      $stmt = $db->query('SELECT * FROM mad_appointment WHERE user_id ='.$id);

      $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

      return $results;
    }

    public static function cancelConsult($id){

      $sql = 'DELETE FROM mad_appointment WHERE id = :id;';
      $db = static::getConexaoBD();

      $stmt = $db->prepare($sql);
      $stmt->bindValue(':id', $id, PDO::PARAM_STR);
      $stmt->execute();

    }
}
