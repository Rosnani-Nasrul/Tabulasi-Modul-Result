<style>
	.input-sm {
		height: 26px;
	}
</style>
<!-- Breadcrumbs line -->
<div class="breadcrumb-line">
	<ul class="breadcrumb">
		<li><a href='<?php echo base_url();?>'>SITPU</a></li>
		<li><a href='<?php echo base_url();?>datamaster/kelurahan'>Data kelurahan</a></li>
		<li class="active">Tambah Data kelurahan</li>
	</ul>

	<div class="visible-xs breadcrumb-toggle">
		<a class="btn btn-link btn-lg btn-icon" data-toggle="collapse" data-target=".breadcrumb-buttons"><i class="icon-menu2"></i></a>
	</div>
</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<h6 class="panel-title"><i class="icon-copy"></i>Tambah Data kelurahan</h6>
	</div>
	<form class="form-horizontal need_validation" action="" role="form" method="post" enctype="multipart/form-data">
		<div class="panel-body">
			<div class="form-horizontal">
				<div class="form-group">
					<label for="" class="col-sm-2 control-label text-right">Nama Provinsi <span class="mandatory">*</span>:</label>
					<div class="col-sm-4">
						<select id="provinsi" class="wajib select2" name="provinsi"">
							<option value=''>--Pilih Nama Provinsi--</option>
						</select> 
					</div>
				</div>
				<div class="form-group">
					<label for="" class="col-sm-2 control-label text-right">Nama Kabupaten <span class="mandatory">*</span>:</label>
					<div class="col-sm-4">
						<select id="kabupaten" class="wajib select2" name="kabupaten">
							<option value=''>--Pilih Nama Kabupaten--</option>
						</select> 
					</div>
				</div>
				<div class="form-group">
					<label for="" class="col-sm-2 control-label text-right">Nama Kecamatan <span class="mandatory">*</span>:</label>
					<div class="col-sm-4">
						<select id="kecamatan" class="wajib select2" name="kecamatan">
							<option value=''>--Pilih Nama Kecamatan--</option>
						</select> 
					</div>
				</div>
				<div class="form-group">
					<label for="" class="col-sm-2 control-label text-right">Kode Kecamatan : </label>
					<div class="col-sm-10">
						<input type="text" class="form-control input-sm" id="kode_kecamatan" name="kode_kecamatan" placeholder="Kode Kecamatan" readonly="true">
					</div>
				</div>
				<div class="form-group">
					<label for="add_code" class="col-sm-2 control-label text-right">
						 Kode Kelurahan<span class="mandatory">*</span> : 
					</label>
					<div class="col-sm-10">
						<input type="text" class="form-control input-sm wajib" id="add_code" name="add_code" placeholder="Kode Kelurahan">
					</div>
				</div>
				<div class="form-group">
					<label for="add_name" class="col-sm-2 control-label text-right">
						Nama kelurahan <span class="mandatory">*</span> : 
					</label>
					<div class="col-sm-10">
						<input type="text" class="form-control input-sm wajib" id="add_name" name="add_name" placeholder="Nama kelurahan">
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-2">
					</div>
					<div class="col-sm-10">
						<button type="submit" class="btn btn-xs btn-primary">Simpan</button>
						<a href="<?php echo base_url();?>datamaster/kelurahan" class="btn btn-xs btn-danger">Kembali</a>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>

<script type="text/javascript">

$(document).ready(function(){

		$.ajax({
		      url: "<?php echo site_url('datamaster/kelurahan/provinsi')?>",
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
		      url: "<?php echo site_url('datamaster/kelurahan/kabupaten') ?>/" + provinsi_id,
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
		      url: "<?php echo site_url('datamaster/kelurahan/kecamatan') ?>/" + kabupaten_id,
		      type: "GET",
		      dataType: "JSON",
		      success: function (data) {
		          var obj = new Object(data);
		          var select = document.querySelector('#kecamatan');
		          for (var i = 0; i < Object.keys(data).length; i++) {
		              select.innerHTML += "<option value='" + data[i]['district_id'] + "'>" + data[i]['district_name'] + "</option>";
		          	}
		      	}
			});
		});
    
    $("#kecamatan").change(function()
    {
	    var id = $("#kecamatan").val();
			$.ajax({
			      url: "<?php echo site_url('datamaster/kelurahan/place') ?>/" + id,
			      type: "GET",
			      dataType: "JSON",
			      success: function (data) {
			          $('[name="kode_kecamatan"]').val(data.district_code);
			      	}
				});
			});
    });
   </script>









<!-- <script type="text/javascript">
   $(document).ready(function(){
  $('#add_name_district').autocomplete(
   {
    source : "<?php);?>"   }
  );
 });
</script> -->