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
		<li class="active">Detail Data Politikus</li>
	</ul>

	<div class="visible-xs breadcrumb-toggle">
		<a class="btn btn-link btn-lg btn-icon" data-toggle="collapse" data-target=".breadcrumb-buttons"><i class="icon-menu2"></i></a>
	</div>

</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<h6 class="panel-title"><i class="icon-copy"></i>Detail Data Politikus</h6>
	</div>
	<form id="mki_form" method="post" enctype="multipart/form-data" novalidate="novalidate">
		<div class="panel-body">
			<div class="form-horizontal">
				<?php
     					$tahun=substr($politikus["politician_create_date"],0,4);
    					$bulan=substr($politikus["politician_create_date"],5,2);
    					$tgl=substr($politikus["politician_create_date"],8,2);

     					$tanggal=$tgl.'-'.$bulan.'-'.$tahun;

     			?>
				<div class="form-group">
					<label class="col-sm-2 control-label text-right">NIK : </label>
					<div class="col-sm-2 control-label text-left"><?php echo $politikus["politician_nik"];?></div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label text-right">Nama Depan : </label>
					<div class="col-sm-2 control-label text-left"><?php echo $politikus["politician_name_first"];?></div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label text-right">Nama Belakang : </label>
					<div class="col-sm-2 control-label text-left"><?php echo $politikus["politician_name_last"];?></div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label text-right">Nama Alias : </label>
					<div class="col-sm-2 control-label text-left"><?php echo $politikus["politician_name_alias"];?></div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label text-right">Title Prefix : </label>
					<div class="col-sm-2 control-label text-left"><?php echo $politikus["politician_title_prefix"];?></div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label text-right">Title Suffix : </label>
					<div class="col-sm-2 control-label text-left"><?php echo $politikus["politician_title_suffix"];?></div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label text-right">Dibuat Oleh : </label>
					<div class="col-sm-2 control-label text-left"><?php echo $politikus["people_fullname"];?></div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label text-right">Dibuat Tanggal : </label>
					<div class="col-sm-2 control-label text-left"><?php echo $tanggal;?>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-2">
					</div>
					<div class="col-sm-10">
						<a href="<?php echo base_url();?>datamaster/politikus/update/<?php echo $politikus["politician_id"];?>" class="btn btn-xs btn-primary">Edit Data</a>
						<a href="<?php echo base_url();?>datamaster/politikus" class="btn btn-xs btn-danger">Kembali</a>
					</div>
					
				</div>
			</div>
		</div>
	</form>
</div>