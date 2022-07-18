<?php
require_once '../config/conexion.php';

class Curso {

    private $db;

    public function __construct(){
        $this->db = new database;
    }

    public function get_all(){
        $this->db->query("SELECT curso.* from curso");
        $row = $this->db->resultSet();
        if($this->db->rowCount() > 0){
            return $row; 
        }
        return 0;
    }

    public function get_por_anio($ANIO){
        $this->db->query("SELECT curso.* from curso  WHERE anio=:anio");
        $this->db->bind(':anio', $ANIO);
        $row = $this->db->resultSet();
        if($this->db->rowCount() > 0){
            return $row; 
        }
        return 0;
    }

    public function get_anios(){
        $this->db->query("SELECT curso.anio from curso group by anio");
        $row = $this->db->resultSet();
        if($this->db->rowCount() > 0){
            return $row; 
        }
        return 0;
    }
    public function search_id_course_by_name($NAME)
    {
        $this->db->query("SELECT curso.idcurso from curso where curso.nombre=:name_");
        $this->db->bind('name_', $NAME);
        $row = $this->db->resultSet();
        if ($this->db->rowCount() > 0) {
            return $row;
        }
        return 0;
    }
}