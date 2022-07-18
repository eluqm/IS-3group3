<?php

require_once '../models/pregunta.php';
require_once '../models/curso.php';
require_once '../helpers/session_helper.php';

class PreguntaController {

    private $preguntaModel;
    private $curso;
    
    public function __construct(){
        $this->preguntaModel = new Pregunta;
        $this->curso=new Curso();
    }

    public function store()
	{
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $data = [
            'titulo' => trim($_POST['titulo']),
            'descripcion' => trim($_POST['descripcion']),
            'curso' => trim($_POST['curso']),
            'tema' => trim($_POST['tema']),
            'cui' => $_SESSION['usersCUI'],
            'fecha_limite' => $_POST['fecha_limite']
        ];
        if( empty($data['titulo'])
            || empty($data['descripcion'])
            || empty($data['curso'])
            || empty($data['tema'])
            || empty($data['fecha_limite'])){
            flash("publicar_pregunta", "Error Fill all the inputs");
            redirect("../views/editar_pregunta.php");
        }
        
        $curso_=$this->curso->search_id_course_by_name($data['curso']);
        $data['curso']=$curso_[0]->idcurso;

        if($this->preguntaModel->register($data))
        {
            redirect("../views/user__inicio.php");
        }
        else {
            die("Something went wrong");
        }
	}

    public function search_by_tema(){
        if(!isset($_GET['tema']) || $_GET['tema']==''){
            redirect('./inicioController.php');    
        }
        else {
            //variables para la vista
            $tema_actual = $_GET['tema'];
            if(isset($_GET['estado'])){
                $estado_actual = $this->preguntaModel->get_estado_for_query($_GET['estado']);
            }
            else{
                $estado_actual = '-1';
            }
            //obtener preguntas para la vista
            if($estado_actual == '-1'){
                $preguntas_encontradas = $this->preguntaModel->get_all_by_tema($tema_actual);
            }
            else {
                $preguntas_encontradas = $this->preguntaModel->get_all_by_estado_and_tema($estado_actual,$tema_actual);
            }
            //anio registrados para el componente nav_bar
            $anios_registrados=$this->curso->get_anios();
            require_once("../views/pregunta__busqueda_by_tema.php");
        }

    }
    public function show_question()
    {
        $data_id=$_GET['id_pregunta'];
        if(!isset($data_id)){
            redirect('./inicioController.php');
        }
        else {
            $data = $this->preguntaModel->findQuestionById($data_id);
            if (!isset($data)) {
                redirect('./inicioController.php');
            }
            else {
                require_once("../views/pregunta.php");
            }
        }
    }
}

$init = new PreguntaController;

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    switch($_POST['type']){
        case 'store':
            $init->store();
            break;
        default:
            redirect("../views/publicar_pregunta.php");
    }
}
else {
    switch($_GET['action']){
        case 'buscar_tema':
            $init->search_by_tema();
            break;
        case 'listar_cursos':
            $init->search_by_tema();
            break;
        case 'go_to_show_question':
            $init->show_question();
            break;
        default:
            redirect("../views/login.php");
    }
}


?>