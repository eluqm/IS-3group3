<?php
require_once __DIR__.'/../config/conexion.php';

class Pregunta {

    private $db;

    public function __construct(){
        $this->db = new database;
    }

    public function register($data){
        $this->db->query('INSERT INTO pregunta (titulo, descripcion, curso, tema, fecha_publicacion,cui_usuario,disponibilidad,estado,fecha_limite)
        VALUES (:titulo, :descripcion, :curso, :tema, NOW(), :cui, :disponibilidad, 0 , :fecha_limite)');
        $this->db->bind(':titulo', $data['titulo']);
        $this->db->bind(':descripcion', $data['descripcion']);
        $this->db->bind(':curso', $data['curso']);
        $this->db->bind(':tema', $data['tema']);
        $this->db->bind(':cui', $data['cui']);
        $this->db->bind(':disponibilidad', $data['disponibilidad']);
        $this->db->bind(':fecha_limite', $data['fecha_limite']);
        
        if($this->db->execute())
        {
            return true;
        }
        return false;
    }

    /*
        -1 => all
        0 => open
        1 => closed
    */
    public function register_in_non_rejected($data)
    {
        $this->db->query('INSERT INTO pregunta_no_rechazada (id)
        VALUES (:id)');
        $this->db->bind(':id', $data);
        if ($this->db->execute()) {
            return true;
        }
        return false;
    }
        
    // no cambiar esta funcion pls Malnacidos >:V
    public function findQuestionById_2($id) {
        $this->db->query('SELECT * FROM pregunta WHERE id = :id');
        $this->db->bind(':id', $id);

        $row = $this->db->single();

        if($this->db->rowCount() > 0){
            return $row;
        }else{
            return false;
        }
    }

    public function find_id_by_tittle($tittle)
    {
        $this->db->query('SELECT pregunta.id from pregunta
        WHERE pregunta.titulo=:tittle');
        $this->db->bind(':tittle', $tittle);
        $row = $this->db->resultSet();
        if ($this->db->rowCount()>0) {
            return $row;
        }
        else {
            return 0;
        }
    }

    public function get_estado_for_query($ESTADO){
        if($ESTADO=='all'){
            return -1;
        }
        else if($ESTADO=='open'){
            return 0;
        } 
        else if($ESTADO=='close'){
            return 1;
        }          
    }

    public function get_all(){
        $this->db->query("SELECT pregunta.*, curso.nombre 'nombre_curso' FROM pregunta_no_rechazada INNER JOIN pregunta on pregunta_no_rechazada.id=pregunta.id INNER JOIN curso ON curso.idcurso=pregunta.curso");
        $row = $this->db->resultSet();
        if($this->db->rowCount() > 0){
            return $row; 
        }
        return 0;
    }

    public function get_all_by_tema($TEMA){
        $this->db->query("SELECT pregunta.*, curso.nombre 'nombre_curso' FROM pregunta_no_rechazada INNER JOIN pregunta on pregunta_no_rechazada.id=pregunta.id  INNER JOIN curso ON curso.idcurso=pregunta.curso WHERE tema=:tema");
        $this->db->bind(':tema', $TEMA);
        $row = $this->db->resultSet();
        if($this->db->rowCount() > 0){
            return $row; 
        }
        return 0;
    }
  
    public function get_all_by_curso($CURSO){
        $this->db->query("SELECT pregunta.*, curso.nombre 'nombre_curso' FROM pregunta_no_rechazada INNER JOIN pregunta on pregunta_no_rechazada.id=pregunta.id  INNER JOIN curso ON curso.idcurso=pregunta.curso WHERE curso=:curso");
        $this->db->bind(':curso', $CURSO);
        $row = $this->db->resultSet();
        if($this->db->rowCount() > 0){
            return $row; 
        }
        return 0;
    }
    
    public function get_all_by_curso_and_tema($CURSO,$TEMA){
        $this->db->query("SELECT pregunta.*, curso.nombre 'nombre_curso' FROM pregunta_no_rechazada INNER JOIN pregunta on pregunta_no_rechazada.id=pregunta.id  INNER JOIN curso ON curso.idcurso=pregunta.curso WHERE pregunta.tema=:tema AND pregunta.curso=:curso");
        $this->db->bind(':tema', $TEMA);
        $this->db->bind(':curso', $CURSO);
        $row = $this->db->resultSet();
        if($this->db->rowCount() > 0){
            return $row; 
        }
        return 0;
    }

    public function get_all_by_estado_and_tema($ESTADO,$TEMA){
        $this->db->query("SELECT pregunta.*, curso.nombre 'nombre_curso' FROM pregunta_no_rechazada INNER JOIN pregunta on pregunta_no_rechazada.id=pregunta.id  INNER JOIN curso ON curso.idcurso=pregunta.curso WHERE pregunta.tema=:tema AND pregunta.estado=:estado");
        $this->db->bind(':tema', $TEMA);
        $this->db->bind(':estado', $ESTADO);
        $row = $this->db->resultSet();
        if($this->db->rowCount() > 0){
            return $row; 
        }
        return 0;
    }

    public function get_all_by_anio($ANIO){
        $this->db->query("SELECT pregunta.*, curso.nombre 'nombre_curso' FROM pregunta_no_rechazada INNER JOIN pregunta on pregunta_no_rechazada.id=pregunta.id INNER JOIN curso ON curso.idcurso=pregunta.curso WHERE curso.anio=:anio");
        $this->db->bind(':anio', $ANIO);
        $row = $this->db->resultSet();
        if($this->db->rowCount() > 0){
            return $row; 
        }
        return 0;
    }

    public function get_all_by_estado_and_anio($ESTADO,$ANIO){
        $this->db->query("SELECT pregunta.*, curso.nombre 'nombre_curso' FROM pregunta_no_rechazada INNER JOIN pregunta on pregunta_no_rechazada.id=pregunta.id INNER JOIN curso ON curso.idcurso=pregunta.curso WHERE curso.anio=:anio AND pregunta.estado=:estado");
        $this->db->bind(':anio', $ANIO);
        $this->db->bind(':estado', $ESTADO);
        $row = $this->db->resultSet();
        if($this->db->rowCount() > 0){
            return $row; 
        }
        return 0;
    }
    /*
        0 => abierta
        1 => cerrada
    */
    public function get_all_by_estado_and_curso($ESTADO,$CURSO){
        $this->db->query("SELECT pregunta.*, curso.nombre 'nombre_curso' FROM pregunta_no_rechazada INNER JOIN pregunta on pregunta_no_rechazada.id=pregunta.id  INNER JOIN curso ON curso.idcurso=pregunta.curso WHERE pregunta.curso=:curso AND pregunta.estado=:estado");
        $this->db->bind(':curso', $CURSO);
        $this->db->bind(':estado', $ESTADO);
        $row = $this->db->resultSet();
        if($this->db->rowCount() > 0){
            return $row; 
        }
        return 0;
    }

    public function get_all_by_estado($ESTADO){
        $this->db->query("SELECT pregunta.*, curso.nombre 'nombre_curso' FROM pregunta_no_rechazada INNER JOIN pregunta on pregunta_no_rechazada.id=pregunta.id  INNER JOIN curso ON curso.idcurso=pregunta.curso WHERE pregunta.estado=:estado");
        $this->db->bind(':estado', $ESTADO);
        $row = $this->db->resultSet();
        if($this->db->rowCount() > 0){
            return $row; 
        }
        return 0;
    }

    public function findQuestionById($id) {
        $this->db->query("SELECT pregunta.*, curso.nombre 'nombre_curso' FROM pregunta_no_rechazada INNER JOIN pregunta on pregunta_no_rechazada.id=pregunta.id  INNER JOIN curso ON curso.idcurso=pregunta.curso WHERE pregunta.id = :id");
        $this->db->bind(':id', $id);

        $row = $this->db->single();

        if($this->db->rowCount() > 0){
            return $row;
        }else{
            return false;
        }
    }

    // editar pregunta
    public function edit($data) {
        $this->db->query('UPDATE pregunta
        SET titulo=:titulo, descripcion=:descripcion,
        curso=:curso, tema=:tema, disponibilidad=:disponibilidad,
        fecha_limite=:fecha_limite
        WHERE id=:id');
        $this->db->bind(':titulo', $data['titulo']);
        $this->db->bind(':descripcion', $data['descripcion']);
        $this->db->bind(':curso', $data['curso']);
        $this->db->bind(':tema', $data['tema']);
        $this->db->bind(':disponibilidad', $data['disponibilidad']);
        $this->db->bind(':fecha_limite', $data['fecha_limite']);
        $this->db->bind(':id', $data['id']);

        if($this->db->execute())
            return true;
            
        return false;
    }

    // borrar pregunta
    public function delete($id) {

        /*$this->db->query('
                DELETE FROM `solicitud_revision-pregunta` WHERE id_pregunta = :id;
                DELETE FROM `reunion_publica-participantes` WHERE id_pregunta = :id;
                DELETE FROM pregunta_rechazada WHERE id_pregunta = :id;
                DELETE FROM pregunta_no_rechazada WHERE id = :id;
                DELETE FROM pregunta WHERE id = :id;');
        $this->db->bind(':id', $id);*/
        
        $this->db->query('
                DELETE FROM pregunta_no_rechazada WHERE id = :id;
                DELETE FROM pregunta WHERE id = :id;');
        $this->db->bind(':id', $id);

        if($this->db->execute())
            return true;
            
        return false;
    }

    public function edit_for_schedule($data)
    {
        $this->db->query(
            'UPDATE pregunta SET estado = 1, cui_mentor = :cui, fecha_meet=:fecha, link_meet=:meet, reunion_privada=:priv, max_participantes=:maxp, cupos_disponibles=:maxp-1
            WHERE `pregunta`.`id` = :id_q');
        $this->db->bind(':id_q', $data['id_pregunta']);
        $this->db->bind(':cui', $data['cui']);
        $this->db->bind(':fecha', $data['fecha']);
        $this->db->bind(':meet', $data['meet']);
        $this->db->bind(':priv', $data['priv']);
        $this->db->bind(':maxp', $data['max']);

        if ($this->db->execute()) {
            return true;
        }
        return false;
    }
    public function find_question_by_id_user($data)
    {
        $this->db->query('SELECT pregunta.* from pregunta
        where pregunta.cui_usuario = :cui
        and pregunta.id =:id_q');
        $this->db->bind(':id_q', $data['id_pregunta']);
        $this->db->bind(':cui', $data['cui']);

        $row = $this->db->single();

        if($this->db->rowCount() > 0){
            return $row;
        }else{
            return false;
        }
    }
}