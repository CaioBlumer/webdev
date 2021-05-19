<?php
namespace App\Controllers;

use App\Models\User;
use \Core\View;
use App\Models\AgendaM;
/**
 * Posts controller
 *
 * PHP version 7.3
 * Author: Daveh.io
 * Modified: Vinicius Ramos
 */
class Agenda extends \Core\Controller
{

    /**
     * Mostra a página principal do Posts
     *
     * @return void
     */
    public function indexAction() {
        /* echo 'Hello de dentro do método index (ação) no Controlador Posts!';
        echo '<p>Query string parameters: <pre>' .
             htmlspecialchars(print_r($_GET, true)) . '</pre></p>'; */
       $email = $_SESSION['email'];
       $user = User::findByEmail($email);

       $pacient_rows = AgendaM::get_pacients();
       $consults = AgendaM::get_consults($user->id);

       if($user->is_doctor == 1){
       View::renderTemplate('Agenda/index.html', [
           'email' => $email, 'pacient_rows' => $pacient_rows, 'consults' => $consults,
       ]);
     }
     if($user->is_doctor == 0){
       $consults = AgendaM::get_consults_pacient($user->id);
     View::renderTemplate('Agenda/indexP.html', [
         'email' => $email, 'consults' => $consults,
     ]);
   }

    }

    /**
     * Mostrar a página de adicionar novo
     *
     * @return void
     */
    public function addNovoAction() {
        echo 'Hello de dentro do método addNovo (ação) no Controlador Posts!';
    }


    /**
     * Mostrar a página de Edição
     *
     * @return void
     */
    public function editarAction()
    {
        echo 'Hello de dentro do método editar (ação) no Controlador Posts!';
        echo '<p>Parâmetros da Rota: <pre>' .
            htmlspecialchars(print_r($this->params_rota, true)) . '</pre></p>';
    }
    public function updateAction()
    {
      if(isset($_POST["submit_update"])) {
        AgendaM::update_consult($_POST['consult_data'], $_POST['consult_type'], $_POST['consult_comment'], $_POST['id']);
        $this->redirecionar("/agenda/index");
      }
      if(isset($_POST["submit_delete"])) {
        AgendaM::delete_consult($_POST['id']);
        $this->redirecionar("/agenda/index");
      }
    }

    public function createAction()
    {
      if($_POST["date"] == ''){$this->redirecionar("/agenda/index"); exit;}
      $pacient_name = User::findByID($_POST["pacient"]);
      AgendaM::createConsult($pacient_name->name, $_POST["date"], $_POST["consult_type"], $_POST["comment"],  $_SESSION['usuario_id'], $_POST["pacient"]);
      $this->redirecionar("/agenda/index");
    }
    public function cancelAction()
    {
      AgendaM::cancelConsult($_POST["id"]);
      $this->redirecionar("/agenda/index");
    }

    /**
     * Filtro Antes
     *
     * @return void
     */
    protected function anterior()
    {
        //echo "(ANTERIOR) ";
        //return false;
    }

    /**
     * Filtro Depois
     *
     * @return void
     */
    protected function posterior()
    {
       // echo " (POSTERIOR)";
    }
     public static function teste()
    {
        return "oi";
    }
}
