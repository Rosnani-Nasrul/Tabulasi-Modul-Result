<style>
	.input-sm {
		height: 26px;
	}
</style>
<!-- Breadcrumbs line -->
<div class="breadcrumb-line">
	<ul class="breadcrumb">
		<li><a href='<?php echo base_url();?>'>SITPU</a></li>
		<li><a href='<?php echo base_url();?>pemilu/kandidat'>Kandidat</a></li>
		<li class="active">Tambah Data Kandidat</li>
	</ul>

	<div class="visible-xs breadcrumb-toggle">
		<a class="btn btn-link btn-lg btn-icon" data-toggle="collapse" data-target=".breadcrumb-buttons"><i class="icon-menu2"></i></a>
	</div>

</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<h6 class="panel-title"><i class="icon-copy"></i>Tambah Data Kandidat</h6>
	</div>
	<form class="form-horizontal need_validation" action="" role="form" method="post" enctype="multipart/form-data">
		<div class="panel-body">
			<div class="form-horizontal">
				<div class="form-group">
					<label for="add_id" class="col-sm-2 control-label text-right">
						Nama Pilkada <span class="mandatory">*</span> : 
					</label>
					<div class="col-sm-10">
					<select id="add_id" class="wajib select2" name="add_id" data-placeholder="Pilih Pilkada">
							<option></option>
							<?php foreach ($kandidatList as $kandidat) {?>
							<option value="<?php echo $kandidat["pilkada_id"];?>" <?php echo ((count($getDetail))?(($getDetail["pilkada_id"]==$kandidat["pilkada_id"])?"selected":""):"");?> ><?php echo $kandidat["pilkada_name"];?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="add_code" class="col-sm-2 control-label text-right">
						Kode Kandidat <span class="mandatory">*</span> : 
					</label>
					<div class="col-sm-10">
						<input type="text" class="form-control input-sm" id="add_code" name="add_code" placeholder="KODE KANDIDAT" value="<?php echo $getDetail["pilkada_candidate_code"];?>">
					</div>
				</div>
				<div class="form-group">
					<label for="add_number" class="col-sm-2 control-label text-right">
						No. Urut <span class="mandatory">*</span> :
					</label>
					<div class="col-sm-10">
						<input type="text" class="form-control input-sm wajib" id="add_number" name="add_number" placeholder="NO. URUT KANDIDAT" value="<?php echo $getDetail["pilkada_candidate_number"];?>">
					</div>
				</div>
				<div class="form-group">
					<label for="add_name" class="col-sm-2 control-label text-right">
						Nama Kandidat <span class="mandatory">*</span> : 
					</label>
					<div class="col-sm-10">
						<input type="text" class="form-control input-sm" id="add_name" name="add_name" placeholder="NAMA KANDIDAT" value="<?php echo $getDetail["pilkada_candidate_name"];?>">
					</div>
				</div>
				<div class="form-group">
					<label for="add_politician" class="col-sm-2 control-label text-right">
						Ketua <span class="mandatory">*</span> : 
					</label>
					<div class="col-sm-10">
					<select id="add_politician" class="wajib select2" name="add_politician1" data-placeholder="Pilih Ketua">
							<option></option>
							<?php foreach ($politicianList as $politician) {?>
							<option value="<?php echo $politician["politician_id"];?>" <?php echo ((count($getDetail))?(($getDetail["politician_id"]==$politician["politician_id"])?"selected":""):"");?> ><?php echo $politician["politician_name_alias"];?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="add_politician" class="col-sm-2 control-label text-right">
						Wakil <span class="mandatory">*</span> : 
					</label>
					<div class="col-sm-10">
					<select id="add_politician" class="wajib select2" name="add_politician2" data-placeholder="Pilih Wakil">
							<option></option>
							<?php foreach ($politicianList as $politician) {?>
							<option value="<?php echo $politician["politician_id"];?>" <?php echo ((count($getDetail))?(($getDetail["politician_id"]==$politician["politician_id"])?"selected":""):"");?> ><?php echo $politician["politician_name_alias"];?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="add_photo" class="col-sm-2 control-label text-right">
						Unggah Gambar:
					<?php 
					$imgfile = "";
					if($getDetail['pilkada_candidate_photo_path']!="" and $getDetail['pilkada_candidate_photo_path']!= null ){ ?>
							<?php $split = explode("/",$getDetail['pilkada_candidate_photo_path']);$imgfile = $split[count($split)-1];?>
					
					<?php } ?> 
					</label>
					<div class="col-sm-10">
						<input type="file" class="styled form-control" id="add_photo" name="add_photo" placeholder="GAMBAR" value="" accept="image/*">
						<input type="hidden" name="filessss" id="filessss" value="<?php echo $imgfile; ?>">
					</div>
				</div>
				<div class="form-group">
					<label for="add_visi" class="col-sm-2 control-label text-right">
						Visi <span class="mandatory">*</span> : 
					</label>
					<div class="col-sm-10">
						<input type="text" class="form-control input-sm" id="add_visi" name="add_visi" placeholder="VISI" value="<?php echo $getDetail["pilkada_candidate_visi"];?>">
					</div>
				</div>
				<div class="form-group">
					<label for="add_misi" class="col-sm-2 control-label text-right">
						Misi <span class="mandatory">*</span> : 
					</label>
					<div class="col-sm-10">
						<textarea class="form-control input-sm" id="add_misi" name="add_misi" rows="6" placeholder="MISI"><?php echo $getDetail["pilkada_candidate_misi"];?></textarea>
					</div>
				</div>
				<div class="form-group">
					<label for="add_jargon" class="col-sm-2 control-label text-right">
						Jargon <span class="mandatory">*</span> : 
					</label>
					<div class="col-sm-10">
						<input type="text" class="form-control input-sm" id="add_jargon" name="add_jargon" placeholder="JARGON" value="<?php echo $getDetail["pilkada_candidate_jargon"];?>">
					</div>
				</div>
				<div class="form-group">
					<label for="add_parties" class="col-sm-2 control-label text-right">
						Nama Partai <span class="mandatory">*</span> : 
					</label>
					<div class="col-sm-10">
					<select id="add_parties" multiple="multiple" class="wajib select2" name="add_parties[]" data-placeholder="Pilih Wakil">
							<option></option>
							<?php foreach ($partytList as $party) {?>
							<option value="<?php echo $party["party_id"];?>" <?php echo ((count($getDetail))?(($getDetail["party_id"]==$party["party_id"])?"selected":""):"");?> ><?php echo $party["party_name"];?></option>>
							<?php } ?>	
					</select>
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-2">
					</div>
					<div class="col-sm-10">
						<button type="submit" class="btn btn-xs btn-primary">Simpan</button>
						<a href="<?php echo base_url();?>pemilu/kandidat" class="btn btn-xs btn-danger">Kembali</a>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>