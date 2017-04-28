<style>
	.input-sm {
		height: 26px;
	}
</style>
<!-- Breadcrumbs line -->
<div class="breadcrumb-line">
	<ul class="breadcrumb">
		<li><a href='<?php echo base_url();?>'>SITPU</a></li>
		<li><a href='<?php echo base_url();?>datamaster/politikus'>Data Politikus</a></li>
		<li class="active">Tambah Data Politikus</li>
	</ul>

	<div class="visible-xs breadcrumb-toggle">
		<a class="btn btn-link btn-lg btn-icon" data-toggle="collapse" data-target=".breadcrumb-buttons"><i class="icon-menu2"></i></a>
	</div>

</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<h6 class="panel-title"><i class="icon-copy"></i>Tambah Data Politikus</h6>
	</div>
	<form class="form-horizontal need_validation" action="" role="form" method="post" enctype="multipart/form-data">
		<div class="panel-body">
			<div class="form-horizontal">
				<div class="form-group">
					<label for="add_nik" class="col-sm-2 control-label text-right">
						NIK <span class="mandatory">*</span> :  
					</label>
					<div class="col-sm-10">
						<input type="text" class="form-control input-sm wajib" id="add_nik" name="add_nik" placeholder="NIK">
					</div>
				</div>
				<div class="form-group">
					<label for="add_nama_depan" class="col-sm-2 control-label text-right">
						Nama Depan <span class="mandatory">*</span> : 
					</label>
					<div class="col-sm-10">
						<input type="text" class="form-control input-sm wajib" id="add_nama_depan" name="add_nama_depan" placeholder="Nama Depan">
					</div>
				</div>
				<div class="form-group">
					<label for="add_nama_belakang" class="col-sm-2 control-label text-right">
						Nama Belakang <span class="mandatory">*</span> : 
					</label>
					<div class="col-sm-10">
						<input type="text" class="form-control input-sm wajib" id="add_nama_belakang" name="add_nama_belakang" placeholder="Nama Belakang">
					</div>
				</div>
				<div class="form-group">
					<label for="add_nama_alias" class="col-sm-2 control-label text-right">
						Nama Alias <span class="mandatory">*</span> : 
					</label>
					<div class="col-sm-10">
						<input type="text" class="form-control input-sm wajib" id="add_nama_alias" name="add_nama_alias" placeholder="Nama Alias">
					</div>
				</div>
				<div class="form-group">
					<label for="add_title_prefix" class="col-sm-2 control-label text-right">
						Title Prefix : 
					</label>
					<div class="col-sm-10">
						<input type="text" class="form-control input-sm" id="add_title_prefix" name="add_title_prefix" placeholder="Title Prefix">
					</div>
				</div>
				<div class="form-group">
					<label for="add_title_suffix" class="col-sm-2 control-label text-right">
						Title Suffix : 
					</label>
					<div class="col-sm-10">
						<input type="text" class="form-control input-sm" id="add_title_suffix" name="add_title_suffix" placeholder="Title Suffix">
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-2">
					</div>
					<div class="col-sm-10">
						<button type="submit" class="btn btn-xs btn-primary">Simpan</button>
						<a href="<?php echo base_url();?>datamaster/politikus" class="btn btn-xs btn-danger">Kembali</a>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>