<style>
	.input-sm {
		height: 26px;
	}
</style>
<!-- Breadcrumbs line -->
<div class="breadcrumb-line">
	<ul class="breadcrumb">
		<li><a href='<?php echo base_url();?>'>SITPU</a></li>
		<li><a href='<?php echo base_url();?>datamaster/kecamatan'>Data kecamatan</a></li>
		<li class="active">Edit Data kecamatan</li>
	</ul>

	<div class="visible-xs breadcrumb-toggle">
		<a class="btn btn-link btn-lg btn-icon" data-toggle="collapse" data-target=".breadcrumb-buttons"><i class="icon-menu2"></i></a>
	</div>

</div>

<div class="panel panel-default">
	<div class="panel-heading">
		<h6 class="panel-title"><i class="icon-copy"></i>Edit Data kecamatan</h6>
	</div>
	<form class="form-horizontal need_validation" action="" role="form" method="post" enctype="multipart/form-data">
		<div class="panel-body">
			<div class="form-horizontal">
				<div class="form-group">
					<label for="" class="col-sm-2 control-label text-right"> Nama Provinsi : </label>
					<div class="col-sm-4">
						<select class="form-control" id="provinsi" name="provinsi">
              				<option value="" <?php echo (($getDetail["province_code"]!=="")?"selected":"");?>><?php echo $getDetail["province_name"];?></option>
            			</select>
					</div>
				</div>
				<div class="form-group">
					<label for="" class="col-sm-2 control-label text-right"> Nama Kabupaten : </label>
					<div class="col-sm-4">
						<select class="form-control" id="kabupaten" name="kabupaten">
              				<option value="" <?php echo (($getDetail["regency_id"]!=="")?"selected":"");?>><?php echo $getDetail["regency_name"];?></option>
            			</select>
					</div>
				</div>
				<div class="form-group">
					<label for="" class="col-sm-2 control-label text-right">
						Kode Kabupaten <span class="mandatory">*</span> :  
					</label>
					<div class="col-sm-10">
						<input type="text" class="form-control input-sm wajib" id="kode_kabupaten" name="kode_kabupaten" readonly="true" value="<?php echo $getDetail["regency_code"];?>">
					</div>
				</div>
				<div class="form-group">
					<label for="add_code" class="col-sm-2 control-label text-right">
						Kode Kecamatan <span class="mandatory">*</span> : 
					</label>
					<div class="col-sm-10">
						<input type="text" class="form-control input-sm wajib" id="add_code" name="add_code" placeholder="Kode Kabupaten" value="<?php echo $getDetail["district_code"];?>">
					</div>
				</div>
				<div class="form-group">
					<label for="add_name" class="col-sm-2 control-label text-right">
						Nama Kecamatan <span class="mandatory">*</span> : 
					</label>
					<div class="col-sm-10">
						<input type="text" class="form-control input-sm wajib" id="add_name" name="add_name" placeholder="Nama Kabupaten" value="<?php echo $getDetail["district_name"];?>">
					</div>
				</div>
				<div class="form-group">
					<div class="col-sm-2">
					</div>
					<div class="col-sm-10">
						<button type="submit" class="btn btn-xs btn-primary">Simpan</button>
						<a href="<?php echo base_url();?>datamaster/kecamatan" class="btn btn-xs btn-danger">Kembali</a>
					</div>
					
				</div>
			</div>
		</div>
	</form>
</div>

<script type="text/javascript">

$(document).ready(function(){

		$.ajax({
		      url: "<?php echo site_url('datamaster/kecamatan/provinsi')?>",
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
		      url: "<?php echo site_url('datamaster/kecamatan/kabupaten') ?>/" + provinsi_id,
		      type: "GET",
		      dataType: "JSON",
		      success: function (data) {
		          var obj = new Object(data);
		          var select = document.querySelector('#kabupaten');
		          for (var i = 0; i < Object.keys(data).length; i++) {
		              select.innerHTML += "<option value='" + data[i]['regency_id'] + "'>" + data[i]['regency_name'] + "</option>";
		         	}
		    	}
		    });
	   });
    
    $("#kabupaten").change(function()
    {
	    var id = $("#kabupaten").val();
			$.ajax({
			      url: "<?php echo site_url('datamaster/kecamatan/place') ?>/" + id,
			      type: "GET",
			      dataType: "JSON",
			      success: function (data) {
			          $('[name="kode_kabupaten"]').val(data.regency_code);
			      	}
				});
			});
    });
   </script>