<style>
	.input-sm {
		height: 26px;
	}
</style>
<!-- Breadcrumbs line -->
<div class="breadcrumb-line">
	<ul class="breadcrumb">
		<li><a href='<?php echo base_url();?>'>SIMKI</a></li>
		<li><a href='<?php echo base_url();?>pengaturan/aplikasi'>Pengaturan Aplikasi</a></li>
		<li class="active">Detail Pengaturan</li>
	</ul>

	<div class="visible-xs breadcrumb-toggle">
		<a class="btn btn-link btn-lg btn-icon" data-toggle="collapse" data-target=".breadcrumb-buttons"><i class="icon-menu2"></i></a>
	</div>

</div>
<!-- /breadcrumbs line -->
<div class="panel panel-default">
	<div class="panel-heading">
		<h6 class="panel-title"><i class="icon-copy"></i>Detail Pengaturan Aplikasi</h6>
	</div>
	<div class="panel-body">
		<form class="form-horizontal" id="mki_form" method="post" enctype="multipart/form-data" novalidate="novalidate">
			<div class="form-group">
				<label class="col-sm-2 control-label text-right">Kode:</label>
				<div class="col-sm-10 control-label text-left"><?php echo $aplikasi["config_code"] ?></div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label text-right">Nama:</label>
				<div class="col-sm-10 control-label text-left"><?php echo $aplikasi["config_name"];?></div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label text-right">Value:</label>
				<div class="col-sm-10 control-label text-left"><?php echo $aplikasi["config_value"];?></div>
			</div>
			<div class="form-group">
				<div class="col-sm-2">
				</div>
				<div class="col-sm-10">
					<a href="<?php echo base_url();?>pengaturan/aplikasi/update/<?php echo $aplikasi["config_id"];?>" class="btn btn-xs btn-primary">Edit Data</a>
					<a href="<?php echo base_url();?>pengaturan/pengguna" class="btn btn-xs btn-danger">Kembali</a>
				</div>
			</div>
		</form>
	</div>
</div>