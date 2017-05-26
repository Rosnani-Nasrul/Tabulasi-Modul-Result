<style>
	.input-sm {
		height: 26px;
	}
</style>
<!-- Breadcrumbs line -->
<div class="breadcrumb-line">
	<ul class="breadcrumb">
		<li><a href='<?php echo base_url();?>'>SITPU</a></li>
		<li><a href='<?php echo base_url();?>datamaster/kelurahan'>Data Kelurahan</a></li>
		<li class="active">Detail Data Kelurahan</li>
	</ul>

	<div class="visible-xs breadcrumb-toggle">
		<a class="btn btn-link btn-lg btn-icon" data-toggle="collapse" data-target=".breadcrumb-buttons"><i class="icon-menu2"></i></a>
	</div>

</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<h6 class="panel-title"><i class="icon-copy"></i>Detail Data Kelurahan</h6>
	</div>
	<form id="mki_form" method="post" enctype="multipart/form-data" novalidate="novalidate">
		<div class="panel-body">
			<div class="form-horizontal">
				<div class="form-group">
					<label class="col-sm-2 control-label text-right">Nama Provinsi : </label>
					<div class="col-sm-2 control-label text-left"><?php echo $kelurahan["province_name"];?></div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label text-right">Nama Kabupaten : </label>
					<div class="col-sm-2 control-label text-left"><?php echo $kelurahan["regency_name"];?></div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label text-right">Nama Kecamatan : </label>
					<div class="col-sm-2 control-label text-left"><?php echo $kelurahan["district_name"];?></div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label text-right">Kode Kecamatan : </label>
					<div class="col-sm-2 control-label text-left"><?php echo $kelurahan["district_code"];?></div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label text-right">Nama kelurahan : </label>
					<div class="col-sm-2 control-label text-left"><?php echo $kelurahan["village_name"];?></div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label text-right">Kode Kelurahan : </label>
					<div class="col-sm-2 control-label text-left"><?php echo $kelurahan["village_code"];?></div>
				</div>
				<div class="form-group">
					<div class="col-sm-2">
					</div>
					<div class="col-sm-10">
						<a href="<?php echo base_url();?>datamaster/kelurahan/update/<?php echo $kelurahan["village_id"];?>" class="btn btn-xs btn-primary">Edit Data</a>
						<a href="<?php echo base_url();?>datamaster/kelurahan" class="btn btn-xs btn-danger">Kembali</a>
					</div>
					
				</div>
			</div>
		</div>
	</form>
</div>