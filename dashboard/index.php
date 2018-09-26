<?php
	ob_start();
	session_start();
	include '../conn.php';
	$standardTime = "d-m-Y h:i:s";
?>
<!DOCTYPE html>
<html>
<head>
	<title>Smart Park</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<h1 class="display-4">Car entry</h1>
				<table class="table table-hover">
					<thead>						
						<tr>
							<th scope="col">#</th>
							<th scope="col">Plate</th>
							<th scope="col">Entry time</th>
							<th scope="col">Exit time</th>
						</tr>
					</thead>
					<tbody>
						<?php
							$query = $conn->query("SELECT * FROM movement WHERE type = 'entry' ") or trigger_error($conn->error);
							while ($data = $query->fetch_assoc()) {
								$carPlate = $data['car'];
								$time = $data['time'];
						?>
							<tr>
								<th scope="row">1</th>
								<td><?php echo $carPlate ?></td>
								<td><?php echo date($standardTime, strtotime($time)) ?></td>
								<td>-</td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>