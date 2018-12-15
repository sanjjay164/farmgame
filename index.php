<?php
session_start();
session_destroy();
require_once("functions.php");
?>
<html>
<head>
<title>Farm Game</title>
<link rel="stylesheet" type="text/css" href="./css/bootstrap.min.css">
<link href="./css/bootstrap-theme.min.css" rel="stylesheet">
<script src="./js/jquery.min.js"></script>
<script src="./js/bootstrap.min.js"></script>
<script type="text/javascript">
var SITE_URL = "<?php echo base_url() ?>";
var TOTAL_TURNS = "<?php echo TOTAL_TURNS ?>";
</script>
</head>
<body>
	<div class="container">
		<div class="row col-md-12">
			<h1>Farm Game</h1>
		</div>
		<div class="row">
			<div class="col-md-2">
				<input type="button" onClick="play()"  id="sub_play" value="Play" class="btn btn-success">
				<button type="button" id="restart" class="btn btn-danger" onClick="location.reload();">Restart</button>
			</div>
			<div class="col-md-2">
			</div>
			<div class="col-md-2">
			</div>
		</div>
		<div class="row">
			<div class="col-md-3">
				Total Turn : <span><?php echo TOTAL_TURNS ?></span>
			</div>
			<div class="col-md-3">
				Total Turn Left : <span id="total_turn_left"><?php echo TOTAL_TURNS ?></span>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 table-responsive-md">
				<table class="table table-responsive table-bordered">
				<thead>
				<tr>
					<th>Sr no.</th>
					<?php
					$counter_headings = 0;
					foreach ($farm_data as $key => $value) {
						
						for ($members=0; $members <count($value["members"]) ; $members++) { 
							?>
							<th><?php echo $key; ?></th>
							<?php
							$counter_headings++;
						}
					}
					 ?>
				</tr>
				</thead>
				<tbody>
					<tr>
						<?php
						for ($table_rows=0; $table_rows <TOTAL_TURNS ; $table_rows++) { 
							$counter_headings_feed = 0;
							echo "<tr><td>".($table_rows+1)."</td>";
							foreach ($farm_data as $key => $value) {
								for ($members=0; $members <count($value["members"]) ; $members++) { 
									?>
									<td data-member="<?php echo ($table_rows+1).'-'.$key.'-'.($members+1); ?>"></td>
									<?php
									$counter_headings_feed++;
								}
							}
					 	echo "</tr>";
						}
						?>
					</tr>
				</tbody>
				</table>
			</div>
		</div>
	</div>
 <script src="./js/farmgame.js"></script>
</body>
</html>
<?php


?>
