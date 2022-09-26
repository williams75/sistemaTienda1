let tableCargos;
let rowTable = "";
let divLoading = document.querySelector("#divLoading");
document.addEventListener(
  "DOMContentLoaded",
  function () {
    tableCargos = $("#tableCargos").dataTable({
      aProcessing: true,
      aServerSide: true,
      language: {
        url: base_url + "/Assets/js/Spanish.json",
      },
      ajax: {
        url: " " + base_url + "/cargos/getCargos",
        dataSrc: "",
      },
      columns: [
        { data: "id_cargo" },
        { data: "nombre_cargo" },
        { data: "descripcion" },
        { data: "estado" },
        { data: "options" },
      ],
      dom: "lBfrtip",
      buttons: [
        {
          extend: "copyHtml5",
          text: "<i class='far fa-copy'></i> Copiar",
          titleAttr: "Copiar",
          className: "btn btn-secondary",
        },
        {
          extend: "excelHtml5",
          text: "<i class='fas fa-file-excel'></i> Excel",
          titleAttr: "Esportar a Excel",
          className: "btn btn-success",
        },
        {
          extend: "pdfHtml5",
          text: "<i class='fas fa-file-pdf'></i> PDF",
          titleAttr: "Esportar a PDF",
          className: "btn btn-danger",
        },
        {
          extend: "csvHtml5",
          text: "<i class='fas fa-file-csv'></i> CSV",
          titleAttr: "Esportar a CSV",
          className: "btn btn-info",
        },
      ],
      resonsieve: "true",
      bDestroy: true,
      iDisplayLength: 10,
      order: [[0, "desc"]],
    });

    /* registrar cargo  */
    if (document.querySelector("#formCargo")) {
      let formCargo = document.querySelector("#formCargo");
      formCargo.onsubmit = function (e) {
        e.preventDefault();
        let str_cargo = document.querySelector("#txtCargo").value;
        let str_descripcion = document.querySelector("#txtDescripcion").value;
        let int_estado = document.querySelector("#listaEstado").value;
        if (str_cargo == "" || int_estado == "") {
          swal("Atención", "Todos los campos son obligatorios.", "error");
          return false;
        }

        divLoading.style.display = "flex";
        let request = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
        let ajaxUrl = base_url + "/cargos/guardarCargo";
        let formData = new FormData(formCargo);
        request.open("POST", ajaxUrl, true);
        request.send(formData);
        request.onreadystatechange = function () {
          if (request.readyState == 4 && request.status == 200) {
            let objData = JSON.parse(request.responseText);
            if (objData.status) {
              if (rowTable == "") {
                tableCargos.api().ajax.reload();
              } else {
                htmlEstado =
                  int_estado == 1
                    ? '<span class="badge badge-success">Activo</span>'
                    : '<span class="badge badge-danger">Inactivo</span>';
                rowTable.cells[1].textContent = str_cargo;
                rowTable.cells[2].textContent = str_descripcion;
                rowTable.cells[3].innerHTML = htmlEstado;
                rowTable = "";
              }
              $("#modalFormCargo").modal("hide");
              formCargo.reset();
              swal("Cargos", objData.msg, "success");
            } else {
              swal("Error", objData.msg, "error");
            }
          }
          divLoading.style.display = "none";
          return false;
        };
      };
    }
  },
  false
);

/** EDITAR EL CARGO  */
function fntEditCargo(idcargo) {
  document.querySelector("#titleModal").innerHTML = "Actualizar Cargo";
  document.querySelector(".modal-header").classList.replace("headerRegister", "headerUpdate");
  document.querySelector("#btnActionForm").classList.replace("btn-primary", "btn-info");
  document.querySelector("#btnText").innerHTML = "Actualizar";
  let request = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
  let ajaxUrl = base_url + "/Cargos/selectCargo/" + idcargo;
  request.open("GET", ajaxUrl, true);
  request.send();
  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      let objData = JSON.parse(request.responseText);
      if (objData.status) {
        document.querySelector("#id_cargo").value = objData.data.id_cargo;
        document.querySelector("#txtCargo").value = objData.data.nombre_cargo;
        document.querySelector("#txtDescripcion").value = objData.data.descripcion;

        if (objData.data.estado == 1) {
          var optionSelect = '<option value="1" selected class="notBlock">Activo</option>';
        } else {
          var optionSelect = '<option value="2" selected class="notBlock">Inactivo</option>';
        }
        var htmlSelect = `${optionSelect}
                                  <option value="1">Activo</option>
                                  <option value="2">Inactivo</option>
                                `;
        document.querySelector("#listaEstado").innerHTML = htmlSelect;
      }
    }
    $("#modalFormCargo").modal("show");
  };
}

function fntDelCargo(idcargo) {
  var idcargo = idcargo;

  swal(
    {
      title: "Eliminar Cargo",
      text: "¿Realmente quiere eliminar el cargo?",
      type: "warning",
      showCancelButton: true,
      confirmButtonText: "Si, eliminar!",
      cancelButtonText: "No, cancelar!",
      closeOnConfirm: false,
      closeOnCancel: true,
    },
    function (isConfirm) {
      if (isConfirm) {
        var request = window.XMLHttpRequest ? new XMLHttpRequest() : new ActiveXObject("Microsoft.XMLHTTP");
        var ajaxUrl = base_url + "/Cargos/deleteCargo/";
        var strData = "idcargo=" + idcargo;
        request.open("POST", ajaxUrl, true);
        request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        request.send(strData);
        request.onreadystatechange = function () {
          if (request.readyState == 4 && request.status == 200) {
            var objData = JSON.parse(request.responseText);
            if (objData.status) {
              swal("Eliminar!", objData.msg, "success");
              tableCargos.api().ajax.reload();
            } else {
              swal("Atención!", objData.msg, "error");
            }
          }
        };
      }
    }
  );
}

function openModal() {
  rowTable = "";
  document.querySelector("#id_cargo").value = "";
  document.querySelector(".modal-header").classList.replace("headerUpdate", "headerRegister");
  document.querySelector("#btnActionForm").classList.replace("btn-info", "btn-primary");
  document.querySelector("#btnText").innerHTML = "Guardar";
  document.querySelector("#titleModal").innerHTML = "Nuevo Cargo";
  document.querySelector("#formCargo").reset();
  $("#modalFormCargo").modal("show");
}
