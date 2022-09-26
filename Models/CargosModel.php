<?php

class CargosModel extends Mysql
{
    public $int_Id_cargo;
    public $str_cargo;
    public $str_descripcion;
    public $int_estado;

    public function __construct()
    {
        parent::__construct();
    }

    // SQL MOSTRAR CARGOS
    public function selectCargos()
    {
        //EXTRAE ROLES
        $sql = "SELECT * FROM cargo WHERE estado != 0";
        $request = $this->select_all($sql);
        return $request;
    }

    // seleccionar cargo buscado
    public function selectCargo(int $idcargo)
    {
        //BUSCAR ROLE
        $this->int_Id_cargo = $idcargo;
        $sql = "SELECT * FROM cargo WHERE id_cargo = $this->int_Id_cargo";
        $request = $this->select($sql);
        return $request;
    }

    // sql insertar cargo
    public function insertCargo(string $cargo, string $descripcion, int $estado)
    {
        $return = "";
        $this->str_cargo = $cargo;
        $this->str_descripcion = $descripcion;
        $this->int_estado = $estado;
        // verificando que no hay cargos iguales
        $sql = "SELECT * from cargo where nombre_cargo ='{$this->str_cargo}' ";
        $request = $this->select_all($sql);

        if (empty($request)) {
            $query_insert = "INSERT into cargo(nombre_cargo,descripcion,estado) values(?,?,?)";
            $arrData = array($this->str_cargo, $this->str_descripcion, $this->int_estado);
            $request_insert = $this->insert($query_insert, $arrData);
            $return = $request_insert;
        } else {
            $return = "exist";
        }
        return $return;
    }

    public function updateCargo(int $idcargo, string $cargo, string $descripcion, int $estado)
    {
        $this->int_Id_cargo = $idcargo;
        $this->str_cargo = $cargo;
        $this->str_descripcion = $descripcion;
        $this->int_estado = $estado;

        $sql = "SELECT * FROM cargo WHERE nombre_cargo = '$this->str_cargo' AND id_cargo != $this->int_Id_cargo";
        $request = $this->select_all($sql);

        if (empty($request)) {
            $sql = "UPDATE cargo SET nombre_cargo = ?, descripcion = ?, estado = ? WHERE id_cargo = $this->int_Id_cargo ";
            $arrData = array($this->str_cargo, $this->str_descripcion, $this->int_estado);
            $request = $this->update($sql, $arrData);
        } else {
            $request = "exist";
        }
        return $request;
    }

    public function delCargo(int $idcargo)
    {
        $this->int_Id_cargo = $idcargo;
        $sql = "SELECT * FROM persona WHERE cargo_id_cargo = $this->int_Id_cargo";
        $request = $this->select_all($sql);
        if (empty($request)) {
            $sql = "UPDATE cargo SET estado = ? WHERE id_cargo = $this->int_Id_cargo ";
            $arrData = array(0);
            $request = $this->update($sql, $arrData);
            if ($request) {
                $request = 'ok';
            } else {
                $request = 'error';
            }
        } else {
            $request = 'exist';
        }
        return $request;
    }
}
