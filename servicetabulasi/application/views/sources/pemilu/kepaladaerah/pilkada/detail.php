<style>
	.input-sm {
		height: 26px;
	}
</style>
<!-- Breadcrumbs line -->
<div class="breadcrumb-line">
	<ul class="breadcrumb">
		<li><a href='<?php echo base_url();?>'>SITPU</a></li>
		<li><a href='<?php echo base_url();?>pemilu/pilkada'>Pilkada</a></li>
		<li class="active">Detail Pilkada</li>
	</ul>

	<div class="visible-xs breadcrumb-toggle">
		<a class="btn btn-link btn-lg btn-icon" data-toggle="collapse" data-target=".breadcrumb-buttons"><i class="icon-menu2"></i></a>
	</div>

</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<h6 class="panel-title"><i class="icon-copy"></i>Detail Pilkada</h6>
	</div>
	<form id="mki_form" method="post" enctype="multipart/form-data" novalidate="novalidate">
		<div class="panel-body">
			<div class="form-horizontal">

			<?php
			     $tahun=substr($pilkada["pilkada_create_date"],0,4);
			     $bulan=substr($pilkada["pilkada_create_date"],5,2);
			     $tgl=substr($pilkada["pilkada_create_date"],8,2);

			     $tanggal=$tgl.'-'.$bulan.'-'.$tahun;

			?>

				<div class="form-group">
					<label class="col-sm-2 control-label text-right">Kode Pilkada : </label>
					<div class="col-sm-4 control-label text-left"><?php echo $pilkada["pilkada_code"];?></div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label text-right">Nama Pilkada : </label>
					<div class="col-sm-4 control-label text-left"><?php echo $pilkada["pilkada_name"];?></div>

				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label text-right">Lokasi : </label>
					<div class="col-sm-4 control-label text-left"><?php echo $pilkada["province_name"];?></div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label text-right">Awal Periode : </label>
					<div class="col-sm-4 control-label text-left"><?php echo $pilkada["pilkada_periode_start"];?></div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label text-right">Akhir Periode : </label>
					<div class="col-sm-4 control-label text-left"><?php echo $pilkada["pilkada_periode_end"];?></div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label text-right">Dibuat Oleh : </label>
					<div class="col-sm-4 control-label text-left"><?php echo $pilkada["people_fullname"];?></div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label text-right">Tanggal Dibuat : </label>
					<div class="col-sm-4 control-label text-left"><?php echo $tanggal;?></div>
				</div>
				<div class="form-group">
					<div class="col-sm-2">
					</div>
					<div class="col-sm-10">
						<a href="<?php echo base_url();?>pemilu/pilkada/update/<?php echo $pilkada["pilkada_id"];?>" class="btn btn-xs btn-primary">Edit Data</a>
						<a href="<?php echo base_url();?>pemilu/pilkada" class="btn btn-xs btn-danger">Kembali</a>
					</div>
					
				</div>
			</div>
		</div>
	</form>
</div>