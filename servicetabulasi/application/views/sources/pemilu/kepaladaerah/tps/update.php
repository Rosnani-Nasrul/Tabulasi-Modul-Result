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
		<li class="active">Tambah Data TPS</li>
	</ul>

	<div class="visible-xs breadcrumb-toggle">
		<a class="btn btn-link btn-lg btn-icon" data-toggle="collapse" data-target=".breadcrumb-buttons"><i class="icon-menu2"></i></a>
	</div>

</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<h6 class="panel-title"><i class="icon-copy"></i>Tambah Data TPS</h6>
	</div>
	<form class="form-horizontal need_validation" action="" role="form" method="post" enctype="multipart/form-data">
		<div class="panel-body">
			<div class="form-horizontal">
				<div class="form-group">
					<label for="add_code" class="col-sm-2 control-label text-right">
						Kode TPS <span class="mandatory">*</span> : 
					</label>
					<div class="col-sm-10">
						<input type="text" class="form-control input-sm" id="add_code" name="add_code" placeholder="KODE TPS" value="<?php echo $getDetail["pilkada_tps_code"];?>">
					</div>
				</div>
				<div class="form-group">
					<label for="add_pilkada" class="col-sm-2 control-label text-right">
						Nama Pilkada <span class="mandatory">*</span> : 
					</label>
					<div class="col-sm-10">
						<select id="add_pilkada" class="wajib select2" name="add_pilkada" data-placeholder="Pilih Pilkada">
							<option></option>
							<?php foreach ($pilkadaList as $pilkada) {?>
							<option value="<?php echo $pilkada["pilkada_id"];?>" <?php echo ((count($getDetail))?(($getDetail["pilkada_id"]==$pilkada["pilkada_id"])?"selected":""):"");?> ><?php echo $pilkada["pilkada_name"];?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="add_name" class="col-sm-2 control-label text-right">
						Nama TPS <span class="mandatory">*</span> : 
					</label>
					<div class="col-sm-10">
						<input type="text" class="form-control input-sm" id="add_name" name="add_name" placeholder="NAMA TPS" value="<?php echo $getDetail["pilkada_tps_name"];?>">
					</div>
				</div>
				<div class="form-group">
					<label for="add_photo" class="col-sm-2 control-label text-right">
					Unggah Gambar:
					<?php 
					$imgfile = "";
					if($getDetail['pilkada_tps_photo_path']!="" and $getDetail['pilkada_tps_photo_path']!= null ){ ?>
							<?php $split = explode("/",$getDetail['pilkada_tps_photo_path']);$imgfile = $split[count($split)-1];?>
					
					<?php } ?> 
					</label>
					<div class="col-sm-10">
						<input type="file" class="styled form-control" id="add_photo" name="add_photo" placeholder="GAMBAR" value="" accept="image/*">
						<input type="hidden" name="filessss" id="filessss" value="<?php echo $imgfile; ?>">
					</div>
				</div>

				<div class="form-group">
					<label for="add_village" class="col-sm-2 control-label text-right">
						Provinsi <span class="mandatory">*</span> : 
					</label>
					<div class="col-sm-10">
						<select class='form-control' id='provinsi'>
							<option value="<?php echo $getDetail["province_code"];?>" <?php echo (($getDetail["province_code"]!=="")?"selected":"");?> ><?php echo $getDetail["province_name"];?></option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="add_village" class="col-sm-2 control-label text-right">
						Kabupaten/Kota <span class="mandatory">*</span> : 
					</label>
					<div class="col-sm-10">
						<select class='form-control' id='kabupaten'>
							<option value="<?php echo $getDetail["regency_code"];?>" <?php echo (($getDetail["regency_code"]!=="")?"selected":"");?>><?php echo $getDetail["regency_name"];?></option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="add_village" class="col-sm-2 control-label text-right">
						Kecamatan <span class="mandatory">*</span> : 
					</label>
					<div class="col-sm-10">
						<select class='form-control' id='kecamatan'>
							<option value="<?php echo $getDetail["district_code"];?>" <?php echo (($getDetail["district_code"]!=="")?"selected":"");?>><?php echo $getDetail["district_name"];?></option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="add_village" class="col-sm-2 control-label text-right">
						Kelurahan <span class="mandatory">*</span> : 
					</label>
					<div class="col-sm-10">
						<select class='form-control' id='kelurahan' name='add_village'>
							<option value="<?php echo $getDetail["village_id"];?>" <?php echo (($getDetail["village_id"]!=="")?"selected":"");?>><?php echo $getDetail["village_name"];?></option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="add_address" class="col-sm-2 control-label text-right">
						Alamat <span class="mandatory">*</span> :
					</label>
					<div class="col-sm-10">
						<input type="text" class="form-control input-sm wajib" id="add_address" name="add_address" placeholder="ALAMAT" value="<?php echo $getDetail["pilkada_tps_address"];?>">
					</div>
				</div>
				<div class="form-group">
					<label for="add_voter" class="col-sm-2 control-label text-right">
						Jumlah Suara <span class="mandatory">*</span> :
					</label>
					<div class="col-sm-10">
						<input type="text" class="form-control input-sm wajib" id="add_voter" name="add_voter" placeholder="JUMLAH SUARA" value="<?php echo $getDetail["pilkada_tps_total_voter"];?>">
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-2">
					</div>
					<div class="col-sm-10">
						<button type="submit" class="btn btn-xs btn-primary">Simpan</button>
						<a href="<?php echo base_url();?>pemilu/tps" class="btn btn-xs btn-danger">Kembali</a>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
<script type="text/javascript">

$(document).ready(function(){

	$.ajax({
	       url: "<?php echo site_url('pemilu/tps/data_provinsi') ?>/",
	       type: "GET",
	       dataType: "JSON",
	       success: function (data) {
	           var obj = new Object(data);
	           var select = document.querySelector('#provinsi');
	           for (var i = 0; i < Object.keys(data).length; i++) {
	               select.innerHTML += "<option value='" + data[i]['province_code'] + "'>" + data[i]['province_name'] + "</option>";
	        }
	    }
	});

        $("#provinsi").change(function(){
            var provinsi_id = $("#provinsi").val();
            $("#kabupaten").empty();
            $.ajax({
		       url: "<?php echo site_url('pemilu/tps/data_kabupaten') ?>/" + provinsi_id,
		       type: "GET",
		       dataType: "JSON",
		       success: function (data) {
		           var obj = new Object(data);
		           var select = document.querySelector('#kabupaten');
		           for (var i = 0; i < Object.keys(data).length; i++) {
		               select.innerHTML += "<option value='" + data[i]['regency_code'] + "'>" + data[i]['regency_name'] + "</option>";
		           }
		       }
      		});
        });

        $("#kabupaten").change(function(){
            var kabupaten_id = $("#kabupaten").val();
            $("#kecamatan").empty();
            $.ajax({
		       url: "<?php echo site_url('pemilu/tps/data_kecamatan') ?>/" + kabupaten_id,
		       type: "GET",
		       dataType: "JSON",
		       success: function (data) {
		           var obj = new Object(data);
		           var select = document.querySelector('#kecamatan');
		           for (var i = 0; i < Object.keys(data).length; i++) {
		               select.innerHTML += "<option value='" + data[i]['district_code'] + "'>" + data[i]['district_name'] + "</option>";
		           }
		       }
			});
        });

        $("#kecamatan").change(function(){
           var kecamatan_id = $("#kecamatan").val();
            $("#kelurahan").empty();
            $.ajax({
		       url: "<?php echo site_url('pemilu/tps/data_kelurahan') ?>/" + kecamatan_id,
		       type: "GET",
		       dataType: "JSON",
		       success: function (data) {
		           var obj = new Object(data);
		           var select = document.querySelector('#kelurahan');
		           for (var i = 0; i < Object.keys(data).length; i++) {
		               select.innerHTML += "<option value='" + data[i]['village_id'] + "'>" + data[i]['village_name'] + "</option>";
		           }
		       }
			});
        });
    });
    </script>
