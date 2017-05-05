<style>
    .input-sm {
        height: 26px;
    }
</style>
<!-- Breadcrumbs line -->
<div class="breadcrumb-line">
    <ul class="breadcrumb">
        <li><a href='<?php echo base_url();?>'>SIMKI</a></li>
        <li class="active">Data Pengaturan Aplikasi</li>
    </ul>

    <div class="visible-xs breadcrumb-toggle">
        <a class="btn btn-link btn-lg btn-icon" data-toggle="collapse" data-target=".breadcrumb-buttons"><i class="icon-menu2"></i></a>
    </div>

</div>
<div class="panel panel-default">
    <div class="panel-heading">
        <h6 class="panel-title"><i class="icon-copy"></i>Pengaturan Aplikasi</h6>
    </div>
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered" id="table_1">
                <thead>
                    <tr>
                        <th class="text-center" style="min-width:15px;width:15px">No</th>
                        <th class="text-center" style="min-width:20px;width:20px">Kode</th>
                        <th class="text-center">Nama</th>
                        <th class="text-center">Value</th>
                        <th class="text-center">Status</th>
                        <th class="text-center" style="min-width:90px;width:90px">Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#table_1').dataTable( {
            "processing": true,
            "serverSide": true,
            "bServerSide": true,
            "sAjaxSource": baseurl+"pengaturan/aplikasi/listdata",
            "aaSorting": [[0, "desc"]],
            "aoColumns": [
            { "bSortable": false, "sClass": "text-center" },
            { "sClass": "text-left" },
            { "sClass": "text-left" },
            { "sClass": "text-left" },
            { "sClass": "text-center" },
            { "bSortable": false, "sClass": "text-center" }
            ],
            "fnDrawCallback": function () {
                set_default_datatable();
            },
        });
    });
</script>
