<style>
	.input-sm {
		height: 26px;
	}
</style>
<!-- Breadcrumbs line -->
<div class="breadcrumb-line">
	<ul class="breadcrumb">
		<li><a href='<?php echo base_url();?>'>SIMKI</a></li>
		<li class="active">Data Hak Akses</li>
	</ul>

	<div class="visible-xs breadcrumb-toggle">
		<a class="btn btn-link btn-lg btn-icon" data-toggle="collapse" data-target=".breadcrumb-buttons"><i class="icon-menu2"></i></a>
	</div>

</div>
<div class="panel panel-default">
	<div class="panel-heading">
		<h6 class="panel-title"><i class="icon-copy"></i>Hak Akses</h6>
		<a class="pull-right btn btn-xs btn-primary" href='<?php echo base_url();?>pengaturan/hak_akses/create'>Tambah Data</a>
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-sm-12">
				<div class="tabbable">
					<ul id="myTab" class="nav nav-tabs tab-bricky">
						<li class="active">
							<a href="#aktif" data-toggle="tab" data-id="1">
								Hak Akses Aktif
							</a>
						</li>
						<li>
							<a href="#nonaktif" data-toggle="tab" data-id="2">
								Hak Akses Nonaktif
							</a>
						</li>
					</ul>
					<div class="tab-content">
						<div class="tab-pane in active" id="aktif">
							<div class="table-responsive">
								<table class="table table-striped table-bordered" id="table_1">
									<thead>
										<tr>
											<th class="text-center">No</th>
											<th class="text-center">Nama Hak Akses</th>
											<th class="text-center">Total User</th>
											<th class="text-center">Total Menu</th>
											<th class="text-center">Status</th>
											<th class="text-center" style="min-width:90px;width:90px">Aksi</th>
										</tr>
									</thead>
								</table>
							</div>
						</div>
						<div class="tab-pane" id="nonaktif">
							<div class="table-responsive">
								<table class="table table-striped table-bordered table-hover" id="table_2">
									<thead>
										<tr>
											<th class="text-center">No</th>
											<th class="text-center">Nama Hak Akses</th>
											<th class="text-center">Total User</th>
											<th class="text-center">Total Menu</th>
											<th class="text-center">Status</th>
											<th class="text-center" style="min-width:90px;width:90px">Aksi</th>
										</tr>
									</thead>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function() {
		$('#table_1').dataTable( {
			"processing": true,
			"serverSide": true,
			"bServerSide": true,
			"sAjaxSource": baseurl+"pengaturan/hak_akses/listdataaktif",
			"aaSorting": [[0, "desc"]],
			"aoColumns": [
			{ "bSortable": false, "sClass": "text-center" },
			{ "sClass": "text-left" },
			{ "sClass": "text-center" },
			{ "sClass": "text-center" },
			{ "sClass": "text-center" },
			{ "bSortable": false, "sClass": "text-center" }
			],
			"fnDrawCallback": function () {
				set_default_datatable();
			},
		});
		$('#table_2').dataTable( {
			"processing": true,
			"serverSide": true,
			"bServerSide": true,
			"sAjaxSource": baseurl+"pengaturan/hak_akses/listdatanonaktif",
			"aaSorting": [[0, "desc"]],
			"aoColumns": [
			{ "bSortable": false, "sClass": "text-center" },
			{ "sClass": "text-left" },
			{ "sClass": "text-center" },
			{ "sClass": "text-center" },
			{ "sClass": "text-center" },
			{ "bSortable": false, "sClass": "text-center" }
			],
			"fnDrawCallback": function () {
				set_default_datatable();
			},
		});
	});
</script>