<style>
	.input-sm {
		height: 26px;
	}
</style>
<!-- Breadcrumbs line -->
<div class="breadcrumb-line">
	<ul class="breadcrumb">
		<li><a href='<?php echo base_url();?>'>SITPU</a></li>
		<li><a href='<?php echo base_url();?>pemilu/session'>Session</a></li>
		<li class="active">Tambah Data Session</li>
	</ul>

	<div class="visible-xs breadcrumb-toggle">
		<a class="btn btn-link btn-lg btn-icon" data-toggle="collapse" data-target=".breadcrumb-buttons"><i class="icon-menu2"></i></a>
	</div>

</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<h6 class="panel-title"><i class="icon-copy"></i>Tambah Data Session</h6>
	</div>
	<form class="form-horizontal need_validation" action="" role="form" method="post" enctype="multipart/form-data">
		<div class="panel-body">
			<div class="form-horizontal">
				<div class="form-group">
					<label for="add_pilkada" class="col-sm-2 control-label text-right">
						Nama Pilkada <span class="mandatory">*</span> : 
					</label>
					<div class="col-sm-10">
					<select id="add_pilkada" class="wajib select2" name="add_pilkada" data-placeholder="Pilih Pilkada">
							<option></option>
							<option value="<?php echo $getDetail["pilkada_id"];?>" <?php echo (($getDetail["pilkada_id"]!=="")?"selected":"");?> ><?php echo $getDetail["pilkada_name"];?></option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="add_code" class="col-sm-2 control-label text-right">
						Kode Putaran <span class="mandatory">*</span> : 
					</label>
					<div class="col-sm-10">
						<input type="text" class="form-control input-sm" id="add_code" name="add_code" value="<?php echo $getDetail["pilkada_session_code"];?>" placeholder="KODE PUTARAN">
					</div>
				</div>
				<div class="form-group">
					<label for="add_name" class="col-sm-2 control-label text-right">
						Nama Putaran <span class="mandatory">*</span> : 
					</label>
					<div class="col-sm-10">
						<input type="text" class="form-control input-sm" id="add_name" name="add_name" value="<?php echo $getDetail["pilkada_session_name"];?>" placeholder="NAMA PUTARAN">
					</div>
				</div>
				<div class="form-group">
					<label for="add_start" class="col-sm-2 control-label text-right">
						Tanggal Putaran Awal : 
					</label>
					<div class="col-sm-10">
						<input type="text" class="form-control input-sm" id="add_start" name="add_start" value="<?php echo date('m/d/Y',strtotime($getDetail['pilkada_session_date_start'])); ?>" placeholder="TANGGAL AWAL">
					</div>
				</div>
				<div class="form-group">
					<label for="add_end" class="col-sm-2 control-label text-right">
						Tanggal Putaran Akhir : 
					</label>
					<div class="col-sm-10">
						<input type="text" class="form-control input-sm" id="add_end" name="add_end" value="<?php echo date('m/d/Y',strtotime($getDetail['pilkada_session_date_end'])); ?>" placeholder="TANGGAL AKHIR">
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-2">
					</div>
					<div class="col-sm-10">
						<button type="submit" class="btn btn-xs btn-primary">Simpan</button>
						<a href="<?php echo base_url();?>pemilu/session" class="btn btn-xs btn-danger">Kembali</a>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
<script type="text/javascript">

$(document).ready(function(){

	$.ajax({
	       url: "<?php echo site_url('pemilu/session/pilkada') ?>/",
	       type: "GET",
	       dataType: "JSON",
	       success: function (data) {
	           var obj = new Object(data);
	           var select = document.querySelector('#add_pilkada');
	           for (var i = 0; i < Object.keys(data).length; i++) {
	               select.innerHTML += "<option value='" + data[i]['pilkada_id'] + "'>" + data[i]['pilkada_name'] + "</option>";
	        }
	    }
	});

        $("#add_pilkada").change(function(){
            var pilkada_id = $("#add_pilkada").val();
            $("#add_candidat").empty();
            $.ajax({
		       url: "<?php echo site_url('pemilu/session/candidate') ?>/" + pilkada_id,
		       type: "GET",
		       dataType: "JSON",
		       success: function (data) {
		           var obj = new Object(data);
		           var select = document.querySelector('#add_candidat');
		           for (var i = 0; i < Object.keys(data).length; i++) {
		               select.innerHTML += "<option value='" + data[i]['pilkada_candidate_id'] + "'>" + data[i]['pilkada_candidate_name'] + "</option>";
		           }
		       }
      		});
        });
    });
    </script>