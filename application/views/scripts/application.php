<div class="row mb-20">
	
	<div class="col-sm-12 col-md-6 col-md-6">
		
		<div class="panel panel-default">
			<!-- Default panel contents -->
			<div class="panel-heading"><i class="fa fa-plus" aria-hidden="true"></i> New Customer</div>
			<div class="panel-body">
				
				<?php echo validation_errors(); ?>
				
				<?php echo form_open('', 'id="myform"'); ?>

					<label>Services</label>
					<div class="mb-20">
					<?php for ( $i=0; $i<count($service_list); $i++ ) : ?>
						<?php $checked = (0 === $i) ? ' checked' : ''; ?>
						<div class="radio">
							<label>
								<input type="radio" name="service_option" id="optionsRadios_<?php echo $i; ?>" value="<?php echo $service_list[$i]; ?>"<?php echo $checked; ?>>
								<?php echo $service_list[$i]; ?>
							</label>
						</div>
					<?php endfor; ?>
					</div>
					
					<ul class="nav nav-pills mb-20">
						<li id="type_1" role="presentation" class="active"><a href="#">Citizen</a></li>
						<li id="type_2" role="presentation"><a href="#">Organisation</a></li>
						<li id="type_3" role="presentation"><a href="#">Anonymous</a></li>
					</ul>
					
					<div id="form_org" class="mb-10">
						<label>First name</label>
						<input type="text" class="form-control" placeholder="Organisation" name="organisation">
					</div>
					
					<div id="form_title" class="mb-10">
						<label>Title</label>
						<select class="form-control" name="title">
							<option></option>
							<option>Mr.</option>
							<option>Mrs.</option>
							<option>Miss</option>
						</select>
					</div>
					
					<div id="form_name" class="mb-10">
						<label>First name</label>
						<input type="text" class="form-control" placeholder="First name" name="first_name">
					</div>
					
					<div id="form_surname" class="mb-20">
						<label>Last name</label>
						<input type="text" class="form-control" placeholder="Last name" name="last_name">
					</div>
					
					<input type="submit" class="btn btn-primary" value="Submit" name="save_customer" />
					
				</form>
				
			</div>
		</div>
		
	</div>
	
	<div class="col-sm-12 col-md-6 col-md-6">
		
		<div class="panel panel-default">
			<!-- Default panel contents -->
			<div class="panel-heading"><i class="fa fa-users" aria-hidden="true"></i> Queue</div>
			<div class="panel-body">
				<p>List of the customers being queued</p>
			</div>

			<!-- Table -->
			<table class="table">
				<thead>
					<tr>
						<td>#</td>
						<td>Type</td>
						<td>Name</td>
						<td>Service</td>
						<td>Queued at</td>
					</tr>
				</thead>
				<tbody>
					<?php $j=1; foreach ( $queue_list as $line ) : ?>
						<?php foreach ( $line as $customer ) : ?>
						<tr>
							<td><?php echo $j; ?></td>
							<td><?php echo ucfirst($customer['customer_type']); ?></td>
							<td><?php echo $customer['name']; ?></td>
							<td><?php echo ucfirst($customer['service_option']); ?></td>
							<td><?php echo $customer['time']; ?></td>
						</tr>
						<?php endforeach; ?>
					<?php $j++; endforeach; ?>
				</tbody>
			</table>
		</div>
		
	</div>
	
</div>

<div class="row">
	<div class="col-sm-12 col-md-12 col-lg-12">
		<?php echo form_open('', 'id="delete_form"'); ?>
			<input class="btn btn-danger" type="submit" value="Clear Queue" name="clear_queue" />
		</form>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		
		var $type_1 = $('ul li#type_1');
		var $type_2 = $('ul li#type_2');
		var $type_3 = $('ul li#type_3');
		
		var $form_org = $('div#form_org').toggle();
		var $form_title = $('div#form_title').toggle();
		var $form_name = $('div#form_name').toggle();
		var $form_surname = $('div#form_surname').toggle();
		
		// Citizen: title, first name and last name fields should be displayed
		function activate_citizen()
		{
			$form_org.hide();
			$form_title.show();
			$form_name.show();
			$form_surname.show();
		}
		
		// Organisation: organisation name field should be visible
		function activate_organisation()
		{
			$form_org.show();
			$form_title.hide();
			$form_name.hide();
			$form_surname.hide();
		}
		
		// Anonymous: no input fields should be visible
		function activate_anonymous()
		{
			$form_org.hide();
			$form_title.hide();
			$form_name.hide();
			$form_surname.hide();
		}
		
		function setType(type)
		{
			$('input#form_type').remove();
			$('<input>').attr('type', 'hidden').attr('id', 'form_type').attr('name', 'customer_type').attr('value', type).appendTo('form');
		}
		
		activate_citizen();
		setType('citizen');
		
		$type_1.on('click', function(e) {
			$this = $(this);
			$type_2.removeClass('active');
			$type_3.removeClass('active');
			$this.removeClass('active').addClass('active');
			
			$('input#form_type');
			
			activate_citizen();
			setType('citizen');
		});
		
		$type_2.on('click', function(e) {
			$this = $(this);
			$this.removeClass('active').addClass('active');
			$type_1.removeClass('active');
			$type_3.removeClass('active');
			
			activate_organisation();
			setType('organisation');
		});
		
		$type_3.on('click', function(e) {
			$this = $(this);
			$this.removeClass('active').addClass('active');
			$type_1.removeClass('active');
			$type_2.removeClass('active');
			
			activate_anonymous();
			setType('anonymous');
		});
		
	});
</script>