
<?php echo form_open('notification/add',array("class"=>"form-horizontal")); ?>

	<div class="form-group">
		<label for="n_title" class="col-md-4 control-label">N Title</label>
		<div class="col-md-8">
			<input type="text" name="n_title" value="<?php echo $this->input->post('n_title'); ?>" class="form-control" id="n_title" />
		</div>
	</div>
	<div class="form-group">
		<label for="n_msg" class="col-md-4 control-label">N Msg</label>
		<div class="col-md-8">
			<textarea name="n_msg" class="form-control" id="n_msg"><?php echo $this->input->post('n_msg'); ?></textarea>
		</div>
	</div>
	<div class="form-group">
		<label for="n_time_stamp" class="col-md-4 control-label">N Time Stamp</label>
		<div class="col-md-8">
			<input type="text" name="n_time_stamp" value="<?php echo $this->input->post('n_time_stamp'); ?>" class="form-control" id="n_time_stamp" />
		</div>
	</div>
	<div class="form-group">
		<label for="n_send_type" class="col-md-4 control-label">N Send Type</label>
		<div class="col-md-8">
			<input type="text" name="n_send_type" value="<?php echo $this->input->post('n_send_type'); ?>" class="form-control" id="n_send_type" />
		</div>
	</div>
	<div class="form-group">
		<label for="n_type" class="col-md-4 control-label">N Type</label>
		<div class="col-md-8">
			<input type="text" name="n_type" value="<?php echo $this->input->post('n_type'); ?>" class="form-control" id="n_type" />
		</div>
	</div>
	<div class="form-group">
		<label for="n_child_id" class="col-md-4 control-label">N Child Id</label>
		<div class="col-md-8">
			<input type="text" name="n_child_id" value="<?php echo $this->input->post('n_child_id'); ?>" class="form-control" id="n_child_id" />
		</div>
	</div>
	<div class="form-group">
		<label for="n_status" class="col-md-4 control-label">N Status</label>
		<div class="col-md-8">
			<input type="text" name="n_status" value="<?php echo $this->input->post('n_status'); ?>" class="form-control" id="n_status" />
		</div>
	</div>
	
	<div class="form-group">
		<div class="col-sm-offset-4 col-sm-8">
			<button type="submit" class="btn btn-success">Save</button>
        </div>
	</div>

<?php echo form_close(); ?>