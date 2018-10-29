<div class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="card">                
				<div class="card-header">
					<h4 class="card-title"> Users</h4>					
				</div>
				<div class="card-body">
					<div class="toolbar">

						<?php
							if($User->can($currentUserId, 'addUser')){
						?>
							<!--Here you can write extra buttons/actions for the toolbar-->
							<button class="btn btn-info" data-toggle="modal" data-target="#addUser"><i class="now-ui-icons ui-1_simple-add"></i> Add</button>
							<!-- Modal -->
							<div class="modal fade" id="addUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<form id='addUserForm'>
											<div class="modal-header">
												<h5 class="modal-title" id="exampleModalLabel">New user</h5>
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">&times;</span>
												</button>
											</div>
											<div class="modal-body">
												<div id="feedBack"></div> 										
												<div class="form-group">
													<label for="nameInput">Name</label>
													<input type="text" class="form-control" id="nameInput" aria-describedby="emailHelp" placeholder="Enter user names">
												</div>
												<div class="form-group">
													<label for="InputEmail">Email</label>
													<input type="email" class="form-control" id="InputEmail" aria-describedby="emailHelp" placeholder="Enter email">
												</div>
												<div class="form-group">
													<label for="InputPhone">Phone number</label>
													<input type="number" class="form-control" id="InputPhone" placeholder="User's phone">
												</div>

												<div class="form-group">
													<label class="display-5" for="selectRole">UserType</label>
													<select class="selectpicker form-control" data-size="7" data-style="btn-default btn-round" title="Role" id="selectRole">
														<?php
															//getting roles one can create
															$roles = $User->creatableRoles();
															foreach ($roles as $name => $printname) {
																?>
																	<option value="<?=$name?>"><?=$printname?></option>
																<?php
															}
														?>
													</select>
												</div>

												<div class="form-group">
													<label class="display-5" for="selectRole">Parking</label>
													<?php
														$parkings = $Parking->userList($currentUserId);
													?>
													<select class="selectpicker form-control" data-size="7" data-style="btn-default btn-round" title="Select " id="selectParking">
														<?php
															//getting user's parkings one can create
															$parkings = $Parking->userList($currentUserId);
															
															foreach ($parkings as $key => $parking) {
																?>
																	<option value="<?=$parking['id']?>"><?=$parking['name']?></option>
																<?php
															}
														?>
													</select>
												</div>

												<div class="form-row m-b-10">
													<div class="col-12">
														<label>Gender</label>
													</div>
													<div class="col">
														<div class="form-check-radio position-relative form-check">
															<label class="form-check-label">
																<input name="gender" type="radio" class="form-check-input" value="m">
																<span class="form-check-sign"></span>Male</label>
														</div>
													</div>
													<div class="col">
														<div class="form-check-radio position-relative form-check">
															<label class="form-check-label">
																<input name="gender" type="radio" class="form-check-input" value="f">
																<span class="form-check-sign"></span>Female</label>
														</div>
													</div>
												</div>


												<div class="form-group">
													<label for="InputPassword">Password</label>
													<input type="password" class="form-control" id="InputPassword" placeholder="Password">
												</div>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
												<button type="submit" class="btn btn-primary">Create</button>
											</div>
										</form>
									</div>
								</div>
							</div>
						<?php } ?>
					</div>
					<table id="datatable" class="table table-striped table-bordered" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th>Name</th>
								<th>Phone</th>
								<th>Email</th>
								<th>Role</th>
								<th>Gender</th>
								<!-- <th class="disabled-sorting text-right">Actions</th> -->
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th>Name</th>
								<th>Phone</th>
								<th>Email</th>
								<th>Role</th>
								<th>Gender</th>
								<!-- <th class="disabled-sorting text-right">Actions</th> -->
							</tr>
						</tfoot>
						<tbody>
							<?php
								$users = $User->list();
								foreach ($users as $key => $user) {
									$userId = $user['id'];
									$roles = $User->types($userId);
									?>
										<tr>
											<td><?php echo $user['name']; ?></td>
											<td><?php echo $user['phoneNumber']; ?></td>
											<td><?php echo $user['email']; ?></td>
											<td><?php echo implode($roles, ", "); ?></td>
											<td><?php echo WEB::gendername($user['gender']); ?></td>
											<!-- <td class="text-right">
												<a href="#" class="btn btn-round btn-info btn-icon btn-sm like"><i class="fas fa-angle-right"></i></a>
												<a href="#" class="btn btn-round btn-warning btn-icon btn-sm edit"><i class="fas fa-plus"></i></a>
											</td> -->
										</tr>
									<?php
								}
							?>
						</tbody>
					</table>
				</div><!-- end content-->
			</div><!--  end card  -->
		</div>
	</div>
</div>
<?php
	$jsFiles = array_merge($jsFiles, array('assets/js/users.js'));
?>