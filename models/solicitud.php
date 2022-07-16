<?php
require_once __DIR__.'/../config/conexion.php';

class Solicitud {

    private $db;

    public function __construct(){
        $this->db = new database;
    }

    /*
        0 => Pendiente
        1 => Aceptada
        2 => Denegada
    */
    public function getSolicitudedeRegistroPorEstado($ESTADO){
        $this->db->query("SELECT r.fecha_creacion,u.cui,u.nombre,u.correo_electronico,r.dni FROM SOLICITUD_REGISTRO r INNER JOIN USUARIO u ON u.cui = r.user_cui WHERE r.estado=:estado");
        $this->db->bind(':estado', $ESTADO);
        $row = $this->db->resultSet();
        if($this->db->rowCount() > 0){
            return $row; 
        }
        return 0;
    }
    /*
        0 => Pendiente
        1 => Aceptada
        2 => Denegada
    */
    public function getSolicitudedeRevisionDePreguntaPorEstado($ESTADO){
        $this->db->query("SELECT r.* , p.titulo , p.descripcion FROM solicitud_revision_pregunta r INNER JOIN pregunta p ON r.id_pregunta = p.id WHERE r.estado=:estado");
        $this->db->bind(':estado', $ESTADO);
        $row = $this->db->resultSet();
        if($this->db->rowCount() > 0){
            return $row; 
        }
        return 0;
    }

    public function store_solicitud_revision_pregunta($data){
        $this->db->query("INSERT INTO solicitud_revision_pregunta (id,id_pregunta,cui_usuario,razon,fecha_creacion,estado) VALUES (0,:id_pregunta,:cui_usuario,:descripcion,:fecha_creacion,0)");
        $this->db->bind(':id_pregunta', $data['id_pregunta']);
        $this->db->bind(':cui_usuario', $data['cui_usuario']);
        $this->db->bind(':descripcion', $data['descripcion']);
        $this->db->bind(':fecha_creacion', $data['fecha_creacion']);
        if($this->db->execute()){
            return true;
        }
        return false;
    }

    public function solicitud_eliminacion_aceptar($data){
        $this->db->query("UPDATE solicitud_revision_pregunta SET estado= 1, cui_admin=:cui_admin ,admin_nota=:admin_nota,fecha_solucion=:fecha_solucion WHERE id_pregunta=:id_pregunta;");
        $this->db->bind(':id_pregunta', $data['id_pregunta']);
        $this->db->bind(':cui_admin', $data['cui_usuario']);
        $this->db->bind(':admin_nota', $data['descripcion']);
        $this->db->bind(':fecha_solucion', $data['fecha_creacion']);
        if($this->db->execute()){
            
            $this->db->query("INSERT INTO pregunta_rechazada VALUES (:id_pregunta);");
            $this->db->bind(':id_pregunta', $data['id_pregunta']);
            if($this->db->execute()){
                $this->db->query("DELETE FROM pregunta_no_rechazada WHERE id=:id_pregunta;");
                $this->db->bind(':id_pregunta', $data['id_pregunta']);
                if($this->db->execute()){
                    return true;
                }
            }
            return true;
        }
        return false;
    }

    public function search_by_id_pregunta($id_pregunta) {
        $this->db->query('SELECT * FROM solicitud_revision_pregunta WHERE id_pregunta = :id_pregunta');
        $this->db->bind(':id_pregunta', $id_pregunta);

        $row = $this->db->single();
        if($this->db->rowCount() > 0){
            return 1;
        }else{
            return 0;
        }
    }

}