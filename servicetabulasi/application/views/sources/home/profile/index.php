<div class="row"> 
	<div class="col-md-12">
		<!-- start: FORM VALIDATION 2 PANEL -->
		<div class="panel panel-default">
			<div class="panel-heading">
				<i class="fa fa-external-link-square"></i>
				Profil
			</div>
			
			<div class="panel-body">
				<div class="row">
					<div class="col-sm-12">
						<div class="tabbable">
							<ul id="myTab" class="nav nav-tabs tab-bricky">
								<li class="active">
									<a href="#aktif" data-toggle="tab" data-id="1">
										Profil Pengguna
									</a>
								</li>
								<li>
									<a href="#nonaktif" data-toggle="tab" data-id="2">
										Edit Akun
									</a>
								</li>
								<li>
									<a href="#editpassword" data-toggle="tab" data-id="3">
										Edit Password
									</a>
								</li>
							</ul>
							<div class="tab-content">
								<div class="tab-pane in active" id="aktif">
									<div class="row">
										<div class="panel-body">
											<table class="table table-condensed table-hover">
												<thead>
													<tr>
														<th colspan="2">Informasi Pengguna</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td>Nama Hak Akses</td>
														<td><?php echo $pengguna["access_name"];?></td>
													</tr>
													<tr>
														<td>NIP</td>
														<td><?php echo $pengguna["employee_nip"];?></td>
													</tr>
													<tr>
														<td>Username</td>
														<td><?php echo $pengguna["user_name"];?></td>
													</tr>
													<tr>
														<td>Nama</td>
														<td><?php echo $pengguna["employee_fullname"];?></td>
													</tr>
													<tr>
														<td>Alamat</td>
														<td><?php echo $pengguna["employee_address"];?></td>
													</tr>
													<tr>
														<td>Email</td>
														<td><?php echo $pengguna["employee_email"];?></td>
													</tr>
													<tr>
														<td>No Telepon</td>
														<td><?php echo $pengguna["employee_phone"];?></td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
								</div>
								<div class="tab-pane" id="nonaktif">
									<form id="mki_form" method="post" enctype="multipart/form-data" action="<?php echo base_url()."home/profile/editprofile/".$this->session->userdata('user_id');?>">
										<div class="row">
											<div class="col-md-12">
												<h3>Form Edit</h3>
												<hr>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label for="add_username" class="control-label">
														Username
													</label>
													<input type="text" class="form-control wajib" id="add_username" name="add_username" value="<?php echo $pengguna["user_name"];?>">
												</div>
												<div class="form-group">
													<label for="add_name" class="control-label">
														Nama
													</label>
													<input type="text" class="form-control wajib" id="add_name" name="add_name" value="<?php echo $pengguna["employee_fullname"];?>">
												</div>
												<div class="form-group">
													<label for="add_address" class="control-label">
														Alamat
													</label>
													<input type="text" class="form-control wajib" id="add_address" name="add_address" value="<?php echo $pengguna["employee_address"];?>">
												</div>
												<div class="form-group">
													<label for="email2" class="control-label">
														Email
													</label>
													<input type="text" class="form-control wajib" id="email2" name="email2" value="<?php echo $pengguna["employee_email"];?>">
												</div>
												<div class="form-group">
													<label for="add_phone" class="control-label">
														No Telepon
													</label>
													<input type="text" class="form-control wajib" id="add_phone" name="add_phone" value="<?php echo $pengguna["employee_phone"];?>">
												</div>
											</div>
										</div>
										<hr>
										<div class="row">
											<div class="col-sm-12">
												<button class="btn btn-sm btn-green" type="submit">
													<i class="clip-checkbox"></i> Simpan
												</button>
											</div>
										</div>
									</form>
								</div>
								<div class="tab-pane" id="editpassword">
									<form id="mki_form_edit_password" method="post" enctype="multipart/form-data" action="<?php echo base_url()."home/profile/editpassword/".$this->session->userdata('user_id');?>">
										<div class="row">
											<div class="col-md-12">
												<h3>Form Edit Kata Sandi</h3>
												<hr>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label class="control-label">
														Kata Sandi Lama
													</label>
													<input type="password" placeholder="password" class="form-control wajib" name="oldpassword" id="oldpassword">
												</div>
												<div class="form-group">
													<label class="control-label">
														Kata Sandi
													</label>
													<input type="password" placeholder="password" class="form-control wajib" name="password" id="password">
												</div>
												<div class="form-group">
													<label class="control-label">
														Ulang Kata Sandi
													</label>
													<input type="password"  placeholder="password" class="form-control wajib" id="password_again" name="password_again">
												</div>
											</div>
										</div>
										<hr>
										<div class="row">
											<div class="col-sm-12">
												<button class="btn btn-sm btn-green" type="submit" onclick="cekpassword()">
													<i class="clip-checkbox"></i> Simpan
												</button>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
				
			</div>
		</div>
		<!-- end: FORM VALIDATION 2 PANEL -->
	</div>
	<div class="modal fade" id="konfirmasi_email" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Konfirmasi</h4>
				</div>
				<div class="modal-body">
					<p>
						Anda yakin mereset password user ini ?
					</p>
				</div>
				<div class="modal-footer">
					<button aria-hidden="true" data-dismiss="modal" class="btn btn-red">
						<i class="fa fa-times"></i> Batal
					</button>
					<button class="btn btn-green" id="yakin_konfirm_email" type="button">
						<i class="clip-checkbox"></i> Yakin
					</button>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		var $ = jQuery;
		$(document).ready(function() {
			$('#buttonclick').click(function(){
				$('#konfirmasi_email').modal('show');
			});
			
			$('#yakin_konfirm_email').click(function(){
				$.ajax({
					url: '<?php echo base_url(); ?>home/profile/reset_password',
					type: 'POST',
					dataType: 'html',
				})
				.done(function(result) {
					alert()
				});
			});
			$('#oldpassword').blur(function() {
				var thisval = $(this).val();

				$.ajax({
					url: '<?php echo base_url(); ?>home/profile/checkOldPass?oldpass='+thisval,
					type: 'POST',
					dataType: 'html',
				})
				.done(function(result) {
					if(result==0){
						$('#oldpassword').parents(".form-group").removeClass('has-success').find('.help-block').html('');
						$('#oldpassword').parents(".form-group").addClass('has-error').find('.help-block').html('Password incorect, please try again!');
					}else{
						$('#oldpassword').parents(".form-group").removeClass('has-error').find('.help-block').html('');
						$('#oldpassword').parents(".form-group").addClass('has-success').find('.help-block').html('');
					}
				});
			});	
		});

</script>