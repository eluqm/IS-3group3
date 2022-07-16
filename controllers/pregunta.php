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
            'fecha_limite' => trim($_POST['fechaLim'])
        ];
        if( empty($data['titulo'])
            || empty($data['descripcion'])
            || empty($data['curso'])
            || empty($data['tema'])
            || empty($data['cui'])
            || empty($data['fecha_limite'])){
            flash("store", "Please fill out all inputs");
            redirect("../views/publicar_pregunta.php");
        }
        
        if(!filter_var($data['usersEmail'], FILTER_VALIDATE_EMAIL)){
            flash("register", "Invalid email");
            redirect("../views/signup.php");
        }

        if(strlen($data['usersPwd']) < 6){
            flash("register", "Invalid password");
            redirect("../views/signup.php");
        } else if($data['usersPwd'] !== $data['pwdRepeat']){
            flash("register", "Passwords don't match");
            redirect("../views/signup.php");
        }

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
}

$init = new PreguntaController;

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    switch($_POST['action']){
        case 'store':
            $init->store();
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
        default:
            redirect("../views/login.php");
    }
}


?>