<?php
require_once '../helpers/session_helper.php';

require_once '../models/pregunta.php';
require_once '../models/curso.php';
require_once '../models/solicitud.php';
class AdminController {

    private $curso;
    private $solicitud;
    private $pregunta;
    
    public function __construct(){
        $this->curso=new Curso();
        $this->solicitud=new Solicitud();
        $this->pregunta=new Pregunta();
    }

    public function get_tipo_solicitud($TIPO_SOLICITUD){
        switch ($TIPO_SOLICITUD){
            case 'pendiente':
                $tipo_solicitud=0;
                break;
            case 'aceptada':
                $tipo_solicitud=1;
                break;
            case 'denegada':
                $tipo_solicitud=2;
                break;
            default:
                redirect("../views/login.php");
                break;
        }
        return $tipo_solicitud;
    }
    public function solicitud_registro($TIPO_SOLICITUD){
        $this->verificar_sesion();
        //procesar tipo de solicitud
        $tipo_solicitud = $this->get_tipo_solicitud($TIPO_SOLICITUD);
        // obtener los anios para la barra de navegacion
        $anios_registrados=$this->curso->get_anios();
        //obtener las solicitudes
        $solicitud_registro = $this->solicitud->getSolicitudedeRegistroPorEstado($tipo_solicitud);
        require_once("../views/admin__solicitudes-registro.php");
    }

    public function solicitud_revision_pregunta($TIPO_SOLICITUD){
        $this->verificar_sesion();
        //procesar tipo de solicitud
        $tipo_solicitud = $this->get_tipo_solicitud($TIPO_SOLICITUD);
        // obtener los anios para la barra de navegacion
        $anios_registrados=$this->curso->get_anios();
        //obtener las solicitudes
        $solicitud_registro =$this->solicitud->getSolicitudedeRevisionDePreguntaPorEstado($tipo_solicitud);
        require_once("../views/admin__solicitudes-preguntas.php");
    }

    public function go_to_formulario_eliminar(){
        $this->verificar_sesion();
        if(!isset($_GET['id_pregunta'])){
            redirect("../views/login.php");
        }
        $datos_pregunta = $this->pregunta->findQuestionById($_GET['id_pregunta']);
        require_once("../views/admin__form_borrar_pregunta.php");

    }

    public function solicitud_eliminacion_aceptada($data){
        $this->verificar_sesion();
    }

    public function eliminar_pregunta(){
        $this->verificar_sesion();
        $data['id_pregunta']=$_POST['id_pregunta'];
        $data['cui_usuario']=$_SESSION['usersCUI'];
        $data['descripcion']=$_POST['razon'];
        $data['fecha_creacion']=date_default_timezone_get();

        //verificar si no hay una solicitud con una misma pregunta
        if($this->solicitud->search_by_id_pregunta($data['id_pregunta'])==0){
            $this->solicitud->store_solicitud_revision_pregunta($data);
            $this->solicitud->solicitud_eliminacion_aceptar($data);
        }
        redirect("../index.php");        
    }

    public function verificar_sesion(){
        //session_start();
        if(!isset($_SESSION['usersCUI']) || $_SESSION['admin']!=1){
            redirect("../views/login.php");
            return 0;
        }
        else{
            return 1;
        }
    }

}

$init = new AdminController;

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    switch($_POST['action']){
        case 'eliminar_pregunta':
            $init->eliminar_pregunta();
            break;
        default:
            redirect("../views/login.php");
    }
} else 
{
    switch($_GET['action']){
        case 'solicitudRegistro':
            $init->solicitud_registro($_GET['solicitud']);
            break;
        case 'solicitudRevisionPregunta':
            $init->solicitud_revision_pregunta($_GET['solicitud']);
            break;
        case 'goTo_formulario_eliminar':
            $init->go_to_formulario_eliminar();
            break;
        default:
                redirect("../views/login.php");
    }
}

?>