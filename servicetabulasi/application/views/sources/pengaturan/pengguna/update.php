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
		<li class="active">Tambah Pengguna</li>
	</ul>

	<div class="visible-xs breadcrumb-toggle">
		<a class="btn btn-link btn-lg btn-icon" data-toggle="collapse" data-target=".breadcrumb-buttons"><i class="icon-menu2"></i></a>
	</div>

</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<h6 class="panel-title"><i class="icon-copy"></i>Tambah Pengguna</h6>
	</div>
	<form class="form-horizontal need_validation" action="" role="form" method="post" enctype="multipart/form-data">
		<div class="panel-body">
			<div class="form-horizontal">
				<div class="form-group">
					<label for="" class="col-sm-2 control-label text-right">Hak Akses <span class="mandatory">*</span> : </label>
					<div class="col-sm-4">
						<select id="add_accld" class="wajib select2" name="add_accld" data-placeholder="Pilih Hak Akses">
							<option></option>
							<?php if(count($accList)>0){?>
							<?php foreach ($accList as $acc) {?>
							<option value="<?php echo $acc["access_id"];?>" <?php echo ((count($getDetail)>0)?(($getDetail["access_id"]==$acc["access_id"])?"selected":""):"");?> ><?php echo $acc["access_name"];?></option>
							<?php } ?>
							<?php } ?>
						</select> 
					</div>
				</div>
				<div class="form-group">
					<label for="add_nip" class="col-sm-2 control-label text-right">
						NIP : 
					</label>
					<div class="col-sm-10">
						<input type="text" class="form-control input-sm" id="add_nip" name="add_nip" placeholder="NIP" value="<?php echo $getDetail["people_nip"];?>">
					</div>
				</div>
				<div class="form-group">
					<label for="add_name" class="col-sm-2 control-label text-right">
						Nama Lengkap <span class="mandatory">*</span> : 
					</label>
					<div class="col-sm-10">
						<input type="text" class="form-control input-sm wajib" id="add_name" name="add_name" placeholder="Nama Lengkap" value="<?php echo $getDetail["people_fullname"];?>">
					</div>
				</div>
				<div class="form-group">
					<label for="add_address" class="col-sm-2 control-label text-right">
						Alamat : 
					</label>
					<div class="col-sm-10">
						<input type="text" class="form-control input-sm" id="add_address" name="add_address" placeholder="Alamat Lengkap" value="<?php echo $getDetail["people_address"];?>">
					</div>
				</div>
				<div class="form-group">
					<label for="add_phone" class="col-sm-2 control-label text-right">
						No. Telepon:
					</label>
					<div class="col-sm-10">
						<input type="text" class="form-control input-sm wajib" id="add_phone" name="add_phone" placeholder="0123456789" value="<?php echo $getDetail["people_phone"];?>">
					</div>
				</div>
				<div class="form-group">
					<label for="email2" class="col-sm-2 control-label text-right">
						Email:
					</label>
					<div class="col-sm-10">
						<input type="email" class="form-control input-sm email" id="email2" name="email2" placeholder="mail@mail.id" value="<?php echo $getDetail["people_email"];?>">
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
			</div>
		</div>
	</form>
</div>
