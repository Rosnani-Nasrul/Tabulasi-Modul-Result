<style>
	.input-sm {
		height: 26px;
	}
</style>
<!-- Breadcrumbs line -->
<div class="breadcrumb-line">
	<ul class="breadcrumb">
		<li><a href='<?php echo base_url();?>'>SITPU</a></li>
		<li><a href='<?php echo base_url();?>datamaster/partai'>Data partai</a></li>
		<li class="active">Detail Data partai</li>
	</ul>

	<div class="visible-xs breadcrumb-toggle">
		<a class="btn btn-link btn-lg btn-icon" data-toggle="collapse" data-target=".breadcrumb-buttons"><i class="icon-menu2"></i></a>
	</div>

</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<h6 class="panel-title"><i class="icon-copy"></i>Detail Data partai</h6>
	</div>
	<form id="mki_form" method="post" enctype="multipart/form-data" novalidate="novalidate">
		<div class="panel-body">
			<div class="form-horizontal">
				<?php
     					$tahun=substr($partai["party_create_date"],0,4);
    					$bulan=substr($partai["party_create_date"],5,2);
    					$tgl=substr($partai["party_create_date"],8,2);

     					$tanggal=$tgl.'-'.$bulan.'-'.$tahun;
     			?>
				<div class="form-group">
					<label class="col-sm-2 control-label text-right">Kode : </label>
					<div class="col-sm-2 control-label text-left"><?php echo $partai["party_code"];?></div>
				</div>
				
				<div class="form-group">
				<label class="col-sm-2 control-label text-right">
					Icon Partai:
				</label>
				<div class="col-lg-3 col-md-6 col-sm-6">
					<div class="block">
						<div class="thumbnail">
							<a href="<?php echo base_url().$partai['party_icon']; ?>" class="thumb-zoom lightbox" title="news Image">
								<img src="<?php echo base_url().$partai['party_icon']; ?>">
							</a>
						</div>
					</div>
				</div>
				</div>

				<div class="form-group">
					<label class="col-sm-2 control-label text-right">Nama Partai : </label>
					<div class="col-sm-2 control-label text-left"><?php echo $partai["party_name"];?></div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-2 control-label text-right">Dibuat Oleh : </label>
					<div class="col-sm-2 control-label text-left"><?php echo $partai["people_fullname"];?></div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label text-right">Dibuat Tanggal: </label>
					<div class="col-sm-2 control-label text-left"><?php echo $tanggal;?></div>
				</div>
				<div class="form-group">
					<div class="col-sm-2">
					</div>
					<div class="col-sm-10">
						<a href="<?php echo base_url();?>datamaster/partai/update/<?php echo $partai["party_id"];?>" class="btn btn-xs btn-primary">Edit Data</a>
						<a href="<?php echo base_url();?>datamaster/partai" class="btn btn-xs btn-danger">Kembali</a>
					</div>
					
				</div>
			</div>
		</div>
	</form>
</div>