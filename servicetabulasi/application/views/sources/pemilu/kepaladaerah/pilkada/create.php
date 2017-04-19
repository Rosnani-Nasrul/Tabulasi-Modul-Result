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
		<li class="active">Tambah Data Pilkada</li>
	</ul>

	<div class="visible-xs breadcrumb-toggle">
		<a class="btn btn-link btn-lg btn-icon" data-toggle="collapse" data-target=".breadcrumb-buttons"><i class="icon-menu2"></i></a>
	</div>

</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<h6 class="panel-title"><i class="icon-copy"></i>Tambah Data Pilkada</h6>
	</div>
	<form class="form-horizontal need_validation" action="" role="form" method="post" enctype="multipart/form-data">
		<div class="panel-body">
			<div class="form-horizontal">
				<div class="form-group">
					<label for="add_code" class="col-sm-2 control-label text-right">
						Kode Pilkada <span class="mandatory">*</span> : 
					</label>
					<div class="col-sm-10">
						<input type="text" class="form-control input-sm" id="add_code" name="add_code" placeholder="KODE PILKADA">
					</div>
				</div>
				<div class="form-group">
					<label for="add_level" class="col-sm-2 control-label text-right">
						Level Pilkada <span class="mandatory">*</span> : 
					</label>
					<div class="col-sm-10">
						<select id="add_level" class="wajib select2" name="add_level" data-placeholder="Pilih Level">
							<option></option>
							<option value="1">Presiden</option>
							<option value="2">Gubernur</option>
							<option value="3">Bupati</option>
							<option value="4">Walikota</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="add_name" class="col-sm-2 control-label text-right">
						Nama Pilkada <span class="mandatory">*</span> : 
					</label>
					<div class="col-sm-10">
						<input type="text" class="form-control input-sm" id="add_name" name="add_name" placeholder="NAMA PILKADA">
					</div>
				</div>
				<div class="form-group">
					<label for="add_lok" class="col-sm-2 control-label text-right">
						Lokasi <span class="mandatory">*</span> : 
					</label>
					<div class="col-sm-10">
					<select id="add_lok" class="wajib select2" name="add_lok" data-placeholder="Pilih Lokasi">
							<option></option>
							<?php foreach ($provinceList as $province) {?>
							<option value="<?php echo $province["province_id"];?>"><?php echo $province["province_name"];?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="add_start" class="col-sm-2 control-label text-right">
						Awal Periode <span class="mandatory">*</span> : 
					</label>
					<div class="col-sm-10">
						<input type="text" class="form-control input-sm" id="add_start" name="add_start" placeholder="AWAL PERIODE">
					</div>
				</div>
				<div class="form-group">
					<label for="add_end" class="col-sm-2 control-label text-right">
						Akhir Periode <span class="mandatory">*</span> :
					</label>
					<div class="col-sm-10">
						<input type="text" class="form-control input-sm wajib" id="add_end" name="add_end" placeholder="AKHIR PERIODE">
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-2">
					</div>
					<div class="col-sm-10">
						<button type="submit" class="btn btn-xs btn-primary">Simpan</button>
						<a href="<?php echo base_url();?>pemilu/pilkada" class="btn btn-xs btn-danger">Kembali</a>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>