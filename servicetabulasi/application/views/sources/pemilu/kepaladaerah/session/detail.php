<style>
	.input-sm {
		height: 26px;
	}
</style>
<!-- Breadcrumbs line -->
<body onload="detail();">
<div class="breadcrumb-line">
	<ul class="breadcrumb">
		<li><a href='<?php echo base_url();?>'>SITPU</a></li>
		<li><a href='<?php echo base_url();?>pemilu/session'>Session</a></li>
		<li class="active">Detail Session</li>
	</ul>

	<div class="visible-xs breadcrumb-toggle">
		<a class="btn btn-link btn-lg btn-icon" data-toggle="collapse" data-target=".breadcrumb-buttons"><i class="icon-menu2"></i></a>
	</div>

</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<h6 class="panel-title"><i class="icon-copy"></i>Detail Session</h6>
		<a class="pull-right btn btn-xs btn-primary" href='<?php echo base_url();?>pemilu/session/createcandidate'>Tambah Data <?php echo $session["pilkada_session_name"];?> </a>
	</div>
	<form id="mki_form" method="post" enctype="multipart/form-data" novalidate="novalidate">
		<div class="panel-body">
			<div class="form-horizontal">
		     <?php
				     $tahunstart=substr($session["pilkada_session_date_start"],0,4);
				     $bulanstart=substr($session["pilkada_session_date_start"],5,2);
				     $tglstart=substr($session["pilkada_session_date_start"],8,2);

				     $tahunend=substr($session["pilkada_session_date_end"],0,4);
				     $bulanend=substr($session["pilkada_session_date_end"],5,2);
				     $tglend=substr($session["pilkada_session_date_end"],8,2);

				     $tahun=substr($session["pilkada_session_create_date"],0,4);
				     $bulan=substr($session["pilkada_session_create_date"],5,2);
				     $tgl=substr($session["pilkada_session_create_date"],8,2);

				     $tanggalstart=$tglstart.'-'.$bulanstart.'-'.$tahunstart;
				     $tanggalend=$tglend.'-'.$bulanend.'-'.$tahunend;
				     $tanggal=$tgl.'-'.$bulan.'-'.$tahun;

		     ?>
				<div class="form-group">
					<label class="col-sm-2 control-label text-right">Kode Putaran : </label>
					<div class="col-sm-4 control-label text-left"><input type="hidden" id="kd_putar" value="<?php echo $session['pilkada_session_id'];?>" /><?php echo $session['pilkada_session_code'];?></div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label text-right">Nama Pilkada : </label>
					<div class="col-sm-4 control-label text-left"><?php echo $session["pilkada_name"];?></div>

				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label text-right">Nama : </label>
					<div class="col-sm-4 control-label text-left"><?php echo $session["pilkada_session_name"];?></div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label text-right">Tanggal Awal Putaran : </label>
					<div class="col-sm-4 control-label text-left"><?php echo $tanggalstart;?></div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label text-right">Tanggal Akhir Putaran : </label>
					<div class="col-sm-4 control-label text-left"><?php echo $tanggalend;?></div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label text-right">Tanggal Dibuat : </label>
					<div class="col-sm-4 control-label text-left"><?php echo $tanggal;?></div>
				</div>
				<div class="form-group">
					<div class="col-sm-2">
					</div>
					<div class="col-sm-10">
						<a href="<?php echo base_url();?>pemilu/session/update/<?php echo $session["pilkada_session_id"];?>" class="btn btn-xs btn-primary">Edit Data</a>
						<a href="<?php echo base_url();?>pemilu/session" class="btn btn-xs btn-danger">Kembali</a>
					</div>
					
				</div>
			</div>
			<div class="panel-body">
		<div class="row">
			<div class="col-sm-12">
				<div class="tabbable">
					<ul id="myTab" class="nav nav-tabs tab-bricky">
						<li class="active">
							<a href="#aktif" data-toggle="tab" data-id="1">Kandidat <?php echo $session["pilkada_session_name"];?></a>
						</li>
						<!-- <li class="">
							<a href="#nonaktif" data-toggle="tab" data-id="2">Session Nonaktif</a>
						</li> -->
					</ul>
					<div class="tab-content">
						<div class="tab-pane active" id="aktif">
							<div class="table-responsive">
								<table class="table table-striped table-bordered table-hover" id="datacandidat">
									<thead>
										<tr>
											<th class="text-center">No</th>
											<th class="text-center">Nama Kandidat</th>
											<th class="text-center">Photo</th>
										</tr>
									</thead>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
		</div>
	</form>
</div>
</body>
<script type="text/javascript">
function detail(){
	var id = $('#kd_putar').val();
	$(document).ready(function() {
		$('#datacandidat').dataTable( {
			"processing": true,
			"serverSide": true,
			"bServerSide": true,
			"sAjaxSource": baseurl+"pemilu/session/listdatacandidat/"+id ,
			"aaSorting": [[0, "asc"]],
			"aoColumns": [
			{ "bSortable": false, "sClass": "text-center" },
			{ "sClass": "text-left" },
			{ "sClass": "text-left" }
			],
			"fnDrawCallback": function () {
				set_default_datatable();
			},
		});
	});
}
</script>