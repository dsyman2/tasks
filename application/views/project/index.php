<?php $profile = $this->session->userdata('profile'); ?>
<div class="row">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Listado de Proyectos</h3>
                <?php if ($profile < 3): ?>
                	<div class="box-tools">
                        <a href="<?php echo site_url('project/add'); ?>" class="btn btn-success btn-sm">
                            <i class="fa fa-plus"></i> Nuevo
                        </a>
                    </div>
                <?php endif ?>
            </div>
            <div class="box-body table-responsive">
                <table class="table table-striped" id="example" cellspacing="0" width="100%">
                    <thead>
                        <tr>
    						<th>ID</th>
    						<th>Nombre</th>
                            <th>Empresa</th>
                            <th>Fecha Inicial</th>
                            <th>Fecha Final</th>
    						<th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($projects as $p): ?>
                            <tr>
        						<td><?php echo $p['id_project']; ?></td>
        						<td><?php echo $p['name']; ?></td>
                                <td>
                                    <?php 
                                        $enterprise = $this->Enterprise_model->get_enterprise($p['enterprise_id']);
                                        echo $enterprise['name'];
                                    ?>
                                </td>
                                <td><?php echo $p['date_start']; ?></td>
                                <td><?php echo $p['date_end']; ?></td>
                                <td>
                                    <a href="<?php echo site_url('make_pdf/project_data/'. $p['id_project']); ?>" class="btn btn-primary btn-sm">
                                        <i class="fa fa-file-pdf-o"></i>
                                    </a>
                                    <a href="#" class="btn btn-primary btn-sm tasks" data-id="<?php echo $p['id_project']; ?>" data-title="<?php echo $p['name']; ?>">
                                        <i class="fa fa-tasks"></i>
                                    </a>
                                    <a href="#" class="btn btn-primary btn-sm timel" data-id="<?php echo $p['id_project']; ?>" data-title="<?php echo $p['name']; ?>">
                                        <i class="fa fa-sliders"></i>
                                    </a>
                                    <a href="<?php echo site_url('project/edit/'.$p['id_project']); ?>" class="btn btn-info btn-sm">
                                        <span class="fa fa-pencil"></span>
                                    </a> 
                                    <a href="<?php echo site_url('project/remove/'.$p['id_project']); ?>" class="btn btn-danger btn-sm del-row" data-title="<?php echo $p['name']; ?>">
                                        <span class="fa fa-trash"></span>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-default" id="modal-tasks">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Modal title</h4>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-block" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<style type="text/css">
    .modal-body {
        max-height: calc(100vh - 210px);
        overflow-y: auto;
    }
</style>

<div class="modal modal-default" id="modal-timeline">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Modal title</h4>
            </div>
            <div class="modal-body">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-block btn-lg" data-dismiss="modal">
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.4.1/css/buttons.bootstrap.min.css">

<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.4.1/js/buttons.bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.4.1/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.4.1/js/buttons.colVis.min.js"></script>

<script>
    $(document).ready(function() {
        var table = $('#example').DataTable( {
            lengthChange: false,
            buttons: [ 
                {
                    extend: 'copyHtml5',
                    text: 'Copiar',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'excelHtml5',
                    text: 'Excel',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'pdfHtml5',
                    text: 'PDF',
                    orientation: 'landscape',
                    pageSize: 'LETTER',
                    exportOptions: {
                        columns: ':visible'
                    },
                    customize: function(doc) {
                       doc.defaultStyle.alignment = 'center';
                       doc.styles.tableHeader.alignment = 'center';
                       doc.content[1].table.widths = Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                   }
                },
                {
                    extend: 'colvis',
                    text: 'Seleccionar columnas',
                    exportOptions: {
                        columns: ':visible'
                    }
                }
            ],
            language: {
                "sProcessing":     "Procesando...",
                "sLengthMenu":     "Mostrar _MENU_ registros",
                "sZeroRecords":    "No se encontraron resultados",
                "sEmptyTable":     "Ningún dato disponible en esta tabla",
                "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
                "sInfoPostFix":    "",
                "sSearch":         "Buscar:",
                "sUrl":            "",
                "sInfoThousands":  ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst":    "Primero",
                    "sLast":     "Último",
                    "sNext":     "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            }
        });

        table.buttons().container().appendTo( '#example_wrapper .col-sm-6:eq(0)');

        $(".tasks").click(function(e) {
            var id      = $(this).attr('data-id');
            var title   = $(this).attr('data-title');
            $("#modal-tasks").find('.modal-title').html("Tareas del proyecto: <b>"+title+"</b>");

            $.ajax({
                url: '<?php echo site_url("project/tasks") ?>',
                type: 'POST',
                data:{
                    id_project: id
                },
                success: function (response) {
                    $("#modal-tasks").find('.modal-body').html(response);
                }
            });


            $("#modal-tasks").modal('show');
        });

        $(".timel").click(function (e) {
            var id      = $(this).attr('data-id');
            var title   = $(this).attr('data-title');

            $("#modal-timeline").find('.modal-title').html("Timeline del proyecto: <b>"+title+"</b>");
            $("#modal-timeline").find('.modal-body').load('<?php echo site_url("project/timeline/"); ?>'+id);
            $("#modal-timeline").modal('show');
        });
    });
</script>

