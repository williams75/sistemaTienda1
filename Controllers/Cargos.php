<?php
class Cargos extends Controllers
{
    public function __construct()
    {
        parent::__construct();
    }

    public function Cargos()
    {

        $data['page_tag'] = NOMBRE_EMPESA;
        $data['page_tag'] = "Cargos Usuario";
        $data['page_name'] = "cargo_usuario";
        $data['page_title'] = "Cargos <small> Sistema Comercial</small>";
        $data['page_functions_js'] = "functions_cargos.js";
        $this->views->getView($this, "cargos", $data);
    }

    //MOSTRAR CARGOS
    public function getCargos()
    {

        $arrData = $this->model->selectCargos();

        for ($i = 0; $i < count($arrData); $i++) {

            if ($arrData[$i]['estado'] == 1) {
                $arrData[$i]['estado'] = "<span class='badge bg-success'>Activo</span>";
            } else {
                $arrData[$i]['estado'] = "<span class='badge bg-danger'>Inactivo</span>";
            }
            $btnView = '<button class="btn btn-secondary btn-sm btnPermisosCargo" onClick="fntPermisos(' . $arrData[$i]['id_cargo'] . ')" title="Permisos"><i class="fas fa-key"></i></button>';
            $btnEdit = '<button class="btn btn-primary btn-sm btnEditCargo" onClick="fntEditCargo(' . $arrData[$i]['id_cargo'] . ')" title="Editar"><i class="fas fa-pencil-alt"></i></button>';


            $btnDelete = '<button class="btn btn-danger btn-sm btnDelCargo" onClick="fntDelCargo(' . $arrData[$i]['id_cargo'] . ')" title="Eliminar"><i class="far fa-trash-alt"></i></button>';

            $arrData[$i]['options'] = '<div class="text-center">' . $btnView . ' ' . $btnEdit . ' ' . $btnDelete . '</div>';
        }
        echo json_encode($arrData, JSON_UNESCAPED_UNICODE);

        die();
    }

    //GUARFAR y ACTUALIZAR CARGO
    public function guardarCargo()
    {
        $intId_cargo = intval($_POST['id_cargo']);
        $str_cargo =  strClean($_POST['txtCargo']);
        $str_descipcion = strClean($_POST['txtDescripcion']);
        $int_estado = intval($_POST['listaEstado']);
        if ($intId_cargo == 0) {
            //Crear
            $resquest_cargo = $this->model->insertCargo($str_cargo, $str_descipcion, $int_estado);
            $option = 1;
        } else {
            //Actualizar
            $resquest_cargo = $this->model->updateCargo($intId_cargo, $str_cargo, $str_descipcion, $int_estado);
            $option = 2;
        }

        if ($resquest_cargo > 0) {
            if ($option == 1) {
                $arrResponse = array('status' => true, 'msg' => 'Datos guardados correctamente.');
            } else {
                $arrResponse = array('status' => true, 'msg' => 'Datos Actualizados correctamente.');
            }
        } else if ($resquest_cargo == 'exist') {

            $arrResponse = array('status' => false, 'msg' => '¡Atención! El Cargo ya existe.');
        } else {
            $arrResponse = array("status" => false, "msg" => 'No es posible almacenar los datos.');
        }
        echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);

        die();
    }

    // EDIT EL CARGO SELECCIONADO
    public function selectCargo(int $idcargo)
    {

        $int_idcargo = intval(strClean($idcargo));
        if ($int_idcargo > 0) {
            $arrData = $this->model->selectCargo($int_idcargo);
            if (empty($arrData)) {
                $arrResponse = array('status' => false, 'msg' => 'Datos no encontrados.');
            } else {
                $arrResponse = array('status' => true, 'data' => $arrData);
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }

        die();
    }

    // ELIMINAR CARGO
    public function deleteCargo()
    {
        if ($_POST) {

            $intIdcargo = intval($_POST['idcargo']);
            $requestDelete = $this->model->delCargo($intIdcargo);
            if ($requestDelete == 'ok') {
                $arrResponse = array('status' => true, 'msg' => 'Se ha eliminado el Cargo');
            } else if ($requestDelete == 'exist') {
                $arrResponse = array('status' => false, 'msg' => 'No es posible eliminar un cargo asociado a usuarios.');
            } else {
                $arrResponse = array('status' => false, 'msg' => 'Error al eliminar el cargo.');
            }
            echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
        }
        die();
    }
}
