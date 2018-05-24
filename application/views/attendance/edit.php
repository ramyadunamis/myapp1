<?php echo validation_errors(); ?>
<?php echo form_open('attendance/edit/'.$attendance['at_id'],array("class"=>"form-horizontal")); ?>

	<div class="form-group">
		<label for="at_child_id" class="col-md-4 control-label">At Child Id</label>
		<div class="col-md-8">
			<input type="text" name="at_child_id" value="<?php echo ($this->input->post('at_child_id') ? $this->input->post('at_child_id') : $attendance['at_child_id']); ?>" class="form-control" id="at_child_id" />
		</div>
	</div>
	<div class="form-group">
		<label for="at_trip_id" class="col-md-4 control-label">At Trip Id</label>
		<div class="col-md-8">
			<input type="text" name="at_trip_id" value="<?php echo ($this->input->post('at_trip_id') ? $this->input->post('at_trip_id') : $attendance['at_trip_id']); ?>" class="form-control" id="at_trip_id" />
		</div>
	</div>
	<div class="form-group">
		<label for="at_time_stamp" class="col-md-4 control-label">At Time Stamp</label>
		<div class="col-md-8">
			<input type="text" name="at_time_stamp" value="<?php echo ($this->input->post('at_time_stamp') ? $this->input->post('at_time_stamp') : $attendance['at_time_stamp']); ?>" class="form-control" id="at_time_stamp" />
		</div>
	</div>
	<div class="form-group">
		<label for="at_time_stamp_device" class="col-md-4 control-label">At Time Stamp Device</label>
		<div class="col-md-8">
			<input type="text" name="at_time_stamp_device" value="<?php echo ($this->input->post('at_time_stamp_device') ? $this->input->post('at_time_stamp_device') : $attendance['at_time_stamp_device']); ?>" class="form-control" id="at_time_stamp_device" />
		</div>
	</div>
	<div class="form-group">
		<label for="at_loc_lati" class="col-md-4 control-label">At Loc Lati</label>
		<div class="col-md-8">
			<input type="text" name="at_loc_lati" value="<?php echo ($this->input->post('at_loc_lati') ? $this->input->post('at_loc_lati') : $attendance['at_loc_lati']); ?>" class="form-control" id="at_loc_lati" />
		</div>
	</div>
	<div class="form-group">
		<label for="at_loc_longi" class="col-md-4 control-label">At Loc Longi</label>
		<div class="col-md-8">
			<input type="text" name="at_loc_longi" value="<?php echo ($this->input->post('at_loc_longi') ? $this->input->post('at_loc_longi') : $attendance['at_loc_longi']); ?>" class="form-control" id="at_loc_longi" />
		</div>
	</div>
	<div class="form-group">
		<label for="at_loc_data_type" class="col-md-4 control-label">At Loc Data Type</label>
		<div class="col-md-8">
			<input type="text" name="at_loc_data_type" value="<?php echo ($this->input->post('at_loc_data_type') ? $this->input->post('at_loc_data_type') : $attendance['at_loc_data_type']); ?>" class="form-control" id="at_loc_data_type" />
		</div>
	</div>
	
	<div class="form-group">
		<div class="col-sm-offset-4 col-sm-8">
			<button type="submit" class="btn btn-success">Save</button>
        </div>
	</div>
	
<?php echo form_close(); ?>