<style>
	.input-sm {
		height: 26px;
	}
</style>
<!-- Breadcrumbs line -->
<div class="breadcrumb-line">
	<ul class="breadcrumb">
		<li><a href='<?php echo base_url();?>'>SIMKI</a></li>
		<li><a href='<?php echo base_url();?>pengaturan/pengguna'>Pengaturan Pengguna</a></li>
		<li class="active">Detail Pengguna</li>
	</ul>

	<div class="visible-xs breadcrumb-toggle">
		<a class="btn btn-link btn-lg btn-icon" data-toggle="collapse" data-target=".breadcrumb-buttons"><i class="icon-menu2"></i></a>
	</div>

</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<h6 class="panel-title"><i class="icon-copy"></i>Detail Pengguna</h6>
	</div>
	<form id="mki_form" method="post" enctype="multipart/form-data" novalidate="novalidate">
		<div class="panel-body">
			<div class="form-horizontal">

				<div class="form-group">
					<label class="col-sm-2 control-label text-right">Hak Akses : </label>
					<div class="col-sm-2 control-label text-left"><?php echo $pengguna["access_name"];?></div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label text-right">NIP : </label>
					<div class="col-sm-2 control-label text-left"><?php echo $pengguna["people_nip"];?></div>

				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label text-right">Username : </label>
					<div class="col-sm-2 control-label text-left"><?php echo $pengguna["user_name"];?></div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label text-right">Nama Lengkap : </label>
					<div class="col-sm-2 control-label text-left"><?php echo $pengguna["people_fullname"];?></div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label text-right">No. Telepon : </label>
					<div class="col-sm-2 control-label text-left"><?php echo $pengguna["people_phone"];?></div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label text-right">Email : </label>
					<div class="col-sm-2 control-label text-left"><?php echo $pengguna["people_email"];?></div>
				</div>
				<div class="form-group">
					<div class="col-sm-2">
					</div>
					<div class="col-sm-10">
						<a href="<?php echo base_url();?>pengaturan/pengguna/update/<?php echo $pengguna["user_id"];?>" class="btn btn-xs btn-primary">Edit Data</a>
						<a href="<?php echo base_url();?>pengaturan/pengguna" class="btn btn-xs btn-danger">Kembali</a>
					</div>
					
				</div>
			</div>
		</div>
	</form>
</div>