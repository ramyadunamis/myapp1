<?php echo form_open('access_log/edit/'.$access_log['alog_id'],array("class"=>"form-horizontal")); ?>

	<div class="form-group">
		<label for="alog_parent_id" class="col-md-4 control-label">Alog Parent Id</label>
		<div class="col-md-8">
			<input type="text" name="alog_parent_id" value="<?php echo ($this->input->post('alog_parent_id') ? $this->input->post('alog_parent_id') : $access_log['alog_parent_id']); ?>" class="form-control" id="alog_parent_id" />
		</div>
	</div>
	<div class="form-group">
		<label for="alog_device" class="col-md-4 control-label">Alog Device</label>
		<div class="col-md-8">
			<input type="text" name="alog_device" value="<?php echo ($this->input->post('alog_device') ? $this->input->post('alog_device') : $access_log['alog_device']); ?>" class="form-control" id="alog_device" />
		</div>
	</div>
	<div class="form-group">
		<label for="alog_model" class="col-md-4 control-label">Alog Model</label>
		<div class="col-md-8">
			<input type="text" name="alog_model" value="<?php echo ($this->input->post('alog_model') ? $this->input->post('alog_model') : $access_log['alog_model']); ?>" class="form-control" id="alog_model" />
		</div>
	</div>
	<div class="form-group">
		<label for="alog_os_version" class="col-md-4 control-label">Alog Os Version</label>
		<div class="col-md-8">
			<input type="text" name="alog_os_version" value="<?php echo ($this->input->post('alog_os_version') ? $this->input->post('alog_os_version') : $access_log['alog_os_version']); ?>" class="form-control" id="alog_os_version" />
		</div>
	</div>
	<div class="form-group">
		<label for="alog_ip_address" class="col-md-4 control-label">Alog Ip Address</label>
		<div class="col-md-8">
			<input type="text" name="alog_ip_address" value="<?php echo ($this->input->post('alog_ip_address') ? $this->input->post('alog_ip_address') : $access_log['alog_ip_address']); ?>" class="form-control" id="alog_ip_address" />
		</div>
	</div>
	<div class="form-group">
		<label for="alog_country" class="col-md-4 control-label">Alog Country</label>
		<div class="col-md-8">
			<input type="text" name="alog_country" value="<?php echo ($this->input->post('alog_country') ? $this->input->post('alog_country') : $access_log['alog_country']); ?>" class="form-control" id="alog_country" />
		</div>
	</div>
	<div class="form-group">
		<label for="alog_time_zone" class="col-md-4 control-label">Alog Time Zone</label>
		<div class="col-md-8">
			<input type="text" name="alog_time_zone" value="<?php echo ($this->input->post('alog_time_zone') ? $this->input->post('alog_time_zone') : $access_log['alog_time_zone']); ?>" class="form-control" id="alog_time_zone" />
		</div>
	</div>
	<div class="form-group">
		<label for="alog_updated_time" class="col-md-4 control-label">Alog Updated Time</label>
		<div class="col-md-8">
			<input type="text" name="alog_updated_time" value="<?php echo ($this->input->post('alog_updated_time') ? $this->input->post('alog_updated_time') : $access_log['alog_updated_time']); ?>" class="form-control" id="alog_updated_time" />
		</div>
	</div>
	<div class="form-group">
		<label for="alog_status" class="col-md-4 control-label">Alog Status</label>
		<div class="col-md-8">
			<input type="text" name="alog_status" value="<?php echo ($this->input->post('alog_status') ? $this->input->post('alog_status') : $access_log['alog_status']); ?>" class="form-control" id="alog_status" />
		</div>
	</div>
	<div class="form-group">
		<label for="alog_delete" class="col-md-4 control-label">Alog Delete</label>
		<div class="col-md-8">
			<input type="text" name="alog_delete" value="<?php echo ($this->input->post('alog_delete') ? $this->input->post('alog_delete') : $access_log['alog_delete']); ?>" class="form-control" id="alog_delete" />
		</div>
	</div>
	
	<div class="form-group">
		<div class="col-sm-offset-4 col-sm-8">
			<button type="submit" class="btn btn-success">Save</button>
        </div>
	</div>
	
<?php echo form_close(); ?>