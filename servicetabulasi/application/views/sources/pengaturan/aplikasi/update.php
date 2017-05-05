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
		<li class="active">Ubah Pengaturan</li>
	</ul>

	<div class="visible-xs breadcrumb-toggle">
		<a class="btn btn-link btn-lg btn-icon" data-toggle="collapse" data-target=".breadcrumb-buttons"><i class="icon-menu2"></i></a>
	</div>
</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<h6 class="panel-title"><i class="icon-copy"></i>Ubah Pengaturan Aplikasi</h6>
	</div>
	<div class="panel-body">		
		<form class="form-horizontal need_validation" action="" role="form" method="post" enctype="multipart/form-data">
			<div class="form-group">
				<label class="col-sm-2 control-label text-right">Kode  <span class="mandatory">*</span> : </label>
				<div class="col-sm-10">
					<input type="text" class="form-control wajib" id="add_code" name="add_code" value="<?php echo $aplikasi['config_code'] ?>" placeholder="kode">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label text-right">Nama  <span class="mandatory">*</span> : </label>
				<div class="col-sm-10">
					<input type="text" class="form-control wajib" id="add_name" name="add_name" value="<?php echo $aplikasi['config_name'] ?>" placeholder="nama">
				</div>
			</div>
			<div class="form-group">
				<label class="col-sm-2 control-label text-right">Value  <span class="mandatory">*</span> : </label>
				<div class="col-sm-10">
					<input type="text" class="form-control wajib" id="add_value" name="add_value" value="<?php echo $aplikasi['config_value'] ?>" placeholder="value">
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-2">
				</div>
				<div class="col-sm-10">
					<button type="submit" class="btn btn-xs btn-primary">Simpan</button>
					<a href="<?php echo base_url();?>pengaturan/pengguna" class="btn btn-xs btn-danger">Kembali</a>
				</div>

			</div>			
		</form>
	</div>
</div>