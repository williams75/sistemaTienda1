<?php
headerAdmin($data);
getModal('modalCargo', $data);
?>

<main class="app-content">
    <div class="container-fluid px-4">
        <h1><i class="fas fa-user-tag"></i> <?= $data['page_title'] ?>

            <button class="btn btn-primary" type="button" onclick="openModal()"><i class="fas fa-plus-circle"></i> Nuevo</button>

        </h1>
        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-table me-1"></i>
                Listado de los cargos
            </div>
            <div class="card-body">
                <table id="tableCargos">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Cargo</th>
                            <th>Descripcion</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Cargo</th>
                            <th>Descripcion</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <tr>
                            <td>Tiger Nixon</td>
                            <td>System Architect</td>
                            <td>Edinburgh</td>
                            <td>61</td>
                            <td>Acciones</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</main>

<?php footerAdmin($data); ?>