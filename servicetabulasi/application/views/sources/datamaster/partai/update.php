<style>
	.input-sm {
		height: 26px;
	}
</style>
<!-- Breadcrumbs line -->
<div class="breadcrumb-line">
	<ul class="breadcrumb">
		<li><a href='<?php echo base_url();?>'>SITPU</a></li>
		<li><a href='<?php echo base_url();?>datamaster/partai'>Data Partai</a></li>
		<li class="active">Edit Data Partai</li>
	</ul>

	<div class="visible-xs breadcrumb-toggle">
		<a class="btn btn-link btn-lg btn-icon" data-toggle="collapse" data-target=".breadcrumb-buttons"><i class="icon-menu2"></i></a>
	</div>

</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<h6 class="panel-title"><i class="icon-copy"></i>Edit Data Partai</h6>
	</div>
	<form class="form-horizontal need_validation" action="" role="form" method="post" enctype="multipart/form-data">
		<div class="panel-body">
			<div class="form-horizontal">
				<div class="form-group">
					<label for="add_code" class="col-sm-2 control-label text-right">
						Kode <span class="mandatory">*</span> :  
					</label>
					<div class="col-sm-10">
						<input type="text" class="form-control input-sm wajib" id="add_code" name="add_code" placeholder="Kode" value="<?php echo $getDetail["party_code"];?>">
					</div>
				</div>
				<div class="form-group">
					<label for="add_name" class="col-sm-2 control-label text-right">
						Nama Depan <span class="mandatory">*</span> : 
					</label>
					<div class="col-sm-10">
						<input type="text" class="form-control input-sm wajib" id="add_name" name="add_name" placeholder="Nama Partai" value="<?php echo $getDetail["party_name"];?>">
					</div>
				</div>
				<div class="form-group">
				<label class="col-sm-2 control-label text-right">
					Icon Partai :
					<?php 
					$imgfile = "";
					if($getDetail['party_icon']!="" and $getDetail['party_icon']!= null ){ ?>
							<?php $split = explode("/",$getDetail['party_icon']);$imgfile = $split[count($split)-1];?>
					
					<?php } ?>
				</label>
				<div class="col-sm-8">
				<input type="file" class="styled form-control" id="add_icon" name="add_icon" placeholder="Gambar" value="">
				<input type="hidden" name="filessss" id="filessss" value="<?php echo $imgfile; ?>">
				
				</div>
			</div>

				<div class="form-group">
					<div class="col-sm-2">
					</div>
					<div class="col-sm-10">
						<button type="submit" class="btn btn-xs btn-primary">Simpan</button>
						<a href="<?php echo base_url();?>datamaster/partai" class="btn btn-xs btn-danger">Kembali</a>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
