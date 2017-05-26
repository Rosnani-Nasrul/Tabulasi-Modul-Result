<style>
	.input-sm {
		height: 26px;
	}
</style>
<!-- Breadcrumbs line -->
<div class="breadcrumb-line">
	<ul class="breadcrumb">
		<li><a href='<?php echo base_url();?>'>SITPU</a></li>
		<li><a href='<?php echo base_url();?>pemilu/tps'>TPS</a></li>
		<li class="active">Detail TPS</li>
	</ul>

	<div class="visible-xs breadcrumb-toggle">
		<a class="btn btn-link btn-lg btn-icon" data-toggle="collapse" data-target=".breadcrumb-buttons"><i class="icon-menu2"></i></a>
	</div>

</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<h6 class="panel-title"><i class="icon-copy"></i>Detail TPS</h6>
	</div>
	<form id="mki_form" method="post" enctype="multipart/form-data" novalidate="novalidate">
		<div class="panel-body">
			<div class="form-horizontal">
				<div class="form-group">
					<label class="col-sm-2 control-label text-right">Nama Pilkada : </label>
					<div class="col-sm-4 control-label text-left"><?php echo $tps["pilkada_name"];?></div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label text-right">Kode TPS : </label>
					<div class="col-sm-4 control-label text-left"><?php echo $tps["pilkada_tps_code"];?></div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label text-right">Nama TPS : </label>
					<div class="col-sm-4 control-label text-left"><?php echo $tps["pilkada_tps_name"];?></div>

				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label text-right">Photo : </label>
					<div class="col-sm-4 control-label text-left">
						<div class="block">
							<div class="thumbnail">
								<a href="<?php echo base_url().$tps['pilkada_tps_photo_path']; ?>" class="thumb-zoom lightbox" title="TPS Image">
									<img src="<?php echo base_url().$tps['pilkada_tps_photo_path']; ?>">
								</a>
							</div>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label text-right">Provinsi : </label>
					<div class="col-sm-4 control-label text-left"><?php echo $tps["province_name"];?></div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label text-right">Kabupaten : </label>
					<div class="col-sm-4 control-label text-left"><?php echo $tps["regency_name"];?></div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label text-right">Kecamatan : </label>
					<div class="col-sm-4 control-label text-left"><?php echo $tps["district_name"];?></div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label text-right">Kelurahan : </label>
					<div class="col-sm-4 control-label text-left"><?php echo $tps["village_name"];?></div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label text-right">Alamat : </label>
					<div class="col-sm-4 control-label text-left"><?php echo $tps["pilkada_tps_address"];?></div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label text-right">Jumlah Suara : </label>
					<div class="col-sm-4 control-label text-left"><?php echo $tps["pilkada_tps_total_voter"];?></div>
				</div>
				<div class="form-group">
					<div class="col-sm-2">
					</div>
					<div class="col-sm-10">
						<a href="<?php echo base_url();?>pemilu/tps/update/<?php echo $tps["pilkada_tps_id"];?>" class="btn btn-xs btn-primary">Edit Data</a>
						<a href="<?php echo base_url();?>pemilu/tps" class="btn btn-xs btn-danger">Kembali</a>
					</div>
					
				</div>
			</div>
		</div>
	</form>
</div>