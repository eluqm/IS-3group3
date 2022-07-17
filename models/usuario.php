<?php
require_once '../config/conexion.php';

class User {

    private $db;

    public function __construct(){
        $this->db = new database;
    }

    public function register($data){
        $this->db->query('INSERT INTO solicitud_registro (fecha_creacion, CUI, nombre, correo, DNI, contrasenia, estado, admin_encargado, fecha_atencion)
        VALUES (NOW(), :usersCUI, :usersName, :usersEmail, :usersDNI, :usersPwd, 0, 20190742, now()');
        $this->db->bind(':usersCUI', $data['usersCUI']);
        $this->db->bind(':usersName', $data['usersName']);
        $this->db->bind(':usersEmail', $data['usersEmail']);
        $this->db->bind(':usersDNI', $data['usersDNI']);
        $this->db->bind(':usersPwd', $data['usersPwd']);
        if($this->db->execute()){
            return true;
        }
        return false;
    }

    public function findUserByEmail($email){
        $this->db->query('SELECT * FROM usuario WHERE correo_electronico = :email');
        $this->db->bind(':email', $email);

        $row = $this->db->single();

        if($this->db->rowCount() > 0){
            return $row;
        }else{
            return false;
        }
    }

    public function isAdmin($CUI){
        $this->db->query('SELECT * FROM administrador WHERE cui = :CUI');
        $this->db->bind(':CUI', $CUI);
        
        $this->db->single();
        
        if($this->db->rowCount() > 0){
            return 1;
        }
        return 0;
    }

    public function login($email, $password){
        $row = $this->findUserByEmail($email);

        if($row == false)
        {
            return false;
        }
        
        if($row->contrasenia==$password){
            $row->admin = $this->isAdmin($row->cui);
            return $row;
        }
        return false;   
    }

    public function getProfile($CUI){
        $this->db->query('SELECT perfil.descripcion, usuario.nombre FROM perfil INNER JOIN usuario ON usuario.cui=perfil.cui WHERE usuario.cui=:CUI');
        $this->db->bind(':CUI', $CUI);
        
        $row = $this->db->single();
        
        if($this->db->rowCount() > 0){
            return $row;
        }
        return false;
    }

    public function getMisPreguntas($CUI){
        $this->db->query("SELECT pregunta.*, curso.nombre 'nombre_curso' from pregunta INNER JOIN curso ON curso.idcurso=pregunta.curso WHERE pregunta.cui_usuario=:CUI");
        $this->db->bind(':CUI', $CUI);
        $row = $this->db->resultSet();
        if($this->db->rowCount() > 0){
            return $row; 
        }
        return 0;
    }

    public function getMisMentorias($CUI){
        $this->db->query("SELECT pregunta.*, curso.nombre 'nombre_curso' from pregunta INNER JOIN curso ON curso.idcurso=pregunta.curso WHERE pregunta.cui_mentor=:CUI");
        $this->db->bind(':CUI', $CUI);
        $row = $this->db->resultSet();
        if($this->db->rowCount() > 0){
            return $row; 
        }
        return 0;
    }

}