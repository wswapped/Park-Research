<div class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="card">                
				<div class="card-header">
					<h4 class="card-title"> Movements</h4>
					<?php
						
					?>
				</div>
				<div class="card-body">
					<div class="toolbar">
						<!--Here you can write extra buttons/actions for the toolbar-->
					</div>
					<table id="datatable" class="table table-striped table-bordered" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th>Car</th>
								<th>Entry</th>
								<th>Exit</th>
								<th>Fees</th>
								<th class="disabled-sorting text-right">Actions</th>
							</tr>
						</thead>
						<tfoot>
							<tr>
								<th>Car</th>
								<th>Entry</th>
								<th>Exit</th>
								<th>Fees</th>
								<th class="disabled-sorting text-right">Actions</th>
							</tr>
						</tfoot>
						<tbody>
							<?php
								$parkings = $Parking->userList($currentUserId);
								$parksId = array(3);
								for ($n=0; $n < count($parkings); $n++) { 
									$parksId[] = $parkings[$n]['id'];
								}
								$mvt = $Movement->parkList($parksId);
								$userParking = $Parking->userList($currentUserId);
								foreach ($mvt as $key => $move) {
									$exitTime = '-';
									$fees = '0';
									if($move['exitMovement']){
										$exitM = $move['exitMovement'];
										$exitTime = date(STANDARD_TIMETEXT_FORMAT, strtotime($exitM['time']));
										$fees = 200;
									}
									?>
										<tr>
											<td><?php echo $move['car']; ?></td>
											<td><?php echo date(STANDARD_TIMETEXT_FORMAT, strtotime($move['time'])); ?></td>
											<td><?php echo $exitTime; ?></td>
											<td><?php echo $fees; ?> Frw</td>
											<td class="text-right">
												<a href="#" class="btn btn-round btn-info btn-icon btn-sm like"><i class="fas fa-angle-right"></i></a>
												<a href="#" class="btn btn-round btn-warning btn-icon btn-sm edit"><i class="fas fa-plus"></i></a>
											</td>
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
	$jsFiles = array_merge($jsFiles, array('assets/js/parking.js'));
?>