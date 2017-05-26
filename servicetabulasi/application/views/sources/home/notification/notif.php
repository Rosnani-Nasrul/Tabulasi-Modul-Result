<div class="card">
	<div class="card-header">
		<h2>Notifikasi <?php echo $this->config->config['app_name']; ?><small>Daftar Notifikasi</small></h2>
	</div>
	<div class="card-body card-padding">
		<div>
			<table id="list-data" class="table table-bordered table-hover" style="width:100%;">
				<thead>
					<tr>
						<th width="60px">Status</th>
						<th>Notifikasi</th>
						<th width="60px" style="text-align:center;">Aksi</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach($notifies as $notify) { ?>
					<tr>
						<td style="text-align:center;">
							<label class="checkbox checkbox-inline disabled">
								<input type="checkbox" <?php echo $notify['NOTIF_IS_COUNT']==0?'checked':''; ?> disabled />
								<i class="input-helper"></i>
							</label>
						</td>
						<td>
							<div style="<?php echo $notify['NOTIF_IS_COUNT']==0?'color:#aaaaaa;':'font-weight:bold;'; ?>">
							<?php echo $notify['NOTIF_MESSAGE']; ?><br/><small style="color:#aaaaaa;"><?php echo texttime($notify['NOTIF_DATE_VIEW']); ?></small>
							</div>
						</td>
						<td style="text-align:center;">
							<?php if($notify['NOTIF_IS_COUNT']==1) { ?>
							<a href="<?php echo base_url().$notify['NOTIF_LINK']; ?>" class="btn btn-success btn-xs waves-effect" data-toggle="tooltip" data-placement="top" title="Lihat Detail">&nbsp;<i class="zmdi zmdi-long-arrow-right"></i>&nbsp;</a>
							<?php } ?>
						</td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<script src="<?php echo base_url(); ?>assets/vendors/bower_components/bootstrap-sweetalert/lib/sweet-alert.min.js"></script>  
<script src="<?php echo base_url(); ?>assets/vendors/DataTables-1.10.10/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendors/DataTables-1.10.10/js/dataTables.bootstrap.js"></script>

<script src="<?php echo base_url(); ?>assets/vendors/bower_components/moment/min/moment.min.js"></script>
<script src="<?php echo base_url(); ?>assets/vendors/bower_components/bootstrap-select/dist/js/bootstrap-select.js"></script>

<script type="text/javascript">
	var $ = jQuery;
	$(document).ready(function(){

	});
</script>