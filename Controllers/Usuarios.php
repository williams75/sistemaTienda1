<?php
class Usuarios extends Controllers
{
    public function __construct()
    {
        parent::__construct();
    }

    public function Usuarios()
    {

        $data['page_tag'] = NOMBRE_EMPESA;
        $data['page_tag'] = "Usuario";
        $data['page_name'] = "usuarios";
        $data['page_title'] = "Usuarios <small> Sistema Comercial</small>";
        $data['page_functions_js'] = "functions_usuarios.js";
        $this->views->getView($this, "usuarios", $data);
    }
}
