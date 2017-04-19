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
		<li class="active">Detail Kandidat</li>
	</ul>

	<div class="visible-xs breadcrumb-toggle">
		<a class="btn btn-link btn-lg btn-icon" data-toggle="collapse" data-target=".breadcrumb-buttons"><i class="icon-menu2"></i></a>
	</div>

</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<h6 class="panel-title"><i class="icon-copy"></i>Detail Kandidat</h6>
	</div>
	<form id="mki_form" method="post" enctype="multipart/form-data" novalidate="novalidate">
		<div class="panel-body">
			<div class="form-horizontal">
                <?php
                $data=explode('-',$kandidat["pilkada_candidate_name"]);

                ?>
				<div class="form-group">
					<label class="col-sm-2 control-label text-right">Kode Kandidat : </label>
					<div class="col-sm-4 control-label text-left"><?php echo $kandidat["pilkada_candidate_code"];?></div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label text-right">Nama Kandidat : </label>
					<div class="col-sm-4 control-label text-left"><?php echo $kandidat["pilkada_candidate_name"];?></div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label text-right">Ketua : </label>
					<div class="col-sm-4 control-label text-left"><?php echo $data[0];?></div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label text-right">Wakil : </label>
					<div class="col-sm-4 control-label text-left"><?php echo $data[1];?></div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label text-right">Photo : </label>
					<div class="col-sm-4 control-label text-left">
						<div class="block">
							<div class="thumbnail">
								<a href="<?php echo base_url().$kandidat['pilkada_candidate_photo_path']; ?>" class="thumb-zoom lightbox" title="Kandidat Image">
									<img src="<?php echo base_url().$kandidat['pilkada_candidate_photo_path']; ?>">
								</a>
							</div>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label text-right">Visi : </label>
					<div class="col-sm-4 control-label text-left"><?php echo $kandidat["pilkada_candidate_visi"];?></div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label text-right">Misi : </label>
					<div class="col-sm-4 control-label text-left"><?php echo $kandidat["pilkada_candidate_misi"];?></div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label text-right">Jargon : </label>
					<div class="col-sm-4 control-label text-left"><?php echo $kandidat["pilkada_candidate_jargon"];?></div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label text-right">Partai : </label>
					<div class="col-sm-4 control-label text-left">
					<?php
					foreach ($kandidats as $kandidats) {
					?>
					<?php echo $kandidats->party_name;?>
					<?php
				    }
					?>	
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-2">
					</div>
					<div class="col-sm-10">
						<a href="<?php echo base_url();?>pemilu/kandidat/update/<?php echo $kandidat["pilkada_candidate_id"];?>" class="btn btn-xs btn-primary">Edit Data</a>
						<a href="<?php echo base_url();?>pemilu/kandidat" class="btn btn-xs btn-danger">Kembali</a>
					</div>
					
				</div>
			</div>
		</div>
	</form>
</div>