<?php

class UsuariosModel extends Mysql
{
    private $int_Id_usuario;
    private $str_nombre;
    private $str_email;
    private $int_telefono;
    private $str_password;
    private $strToken;
    private $int_Id_cargo;
    private $int_estado;

    public function __construct()
    {
        parent::__construct();
    }
    /* utilizando el controlador de HOME */
    public function insertUsuario(string $nombre, string $correo, string $password, string $telefono, string $estado, int $idcargo)
    {
        $this->str_nombre = $nombre;
        $this->str_email = $correo;
        $this->str_password = $password;
        $this->int_telefono = $telefono;
        $this->int_estado = $estado;
        $this->int_Id_cargo = $idcargo;
        $return = 0;

        $sql = "SELECT * from persona where correo ='{$this->str_email}'";

        $request = $this->select_all($sql);
        if (empty($request)) {
            $query_insert = "INSERT into persona(cargo_id_cargo,nombre_completo,correo,password,telefono,estado) values(?,?,?,?,?,?)";
            $arrData = array(
                $this->int_Id_cargo,
                $this->str_nombre,
                $this->str_email,
                $this->str_password,
                $this->int_telefono,
                $this->int_estado
            );
            $request_insert = $this->insert($query_insert, $arrData);
            $return = $request_insert;
        } else {
            $return = "exist";
        }
        return $return;
    }
}
