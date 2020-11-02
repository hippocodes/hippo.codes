<?php include('inc/header.php');?>

<?php
	if($_SERVER['REQUEST_METHOD'] == 'POST'){
		
		$message = '';
		
		if($_POST['game_type'] != ''){
			$game_type = $_POST['game_type'];
		}else{
			$game_type = 'select_powerball';
		}
		
		if($_POST['sets'] != ''){
			$num_tickets = $_POST['sets'];
		}else{
			$num_tickets = 1;
		}
		
		if($_POST['radioPowerball'] == 'yes'){
			$userPowerball = true;
		}else{
			$userPowerball = false;
		}
		
		if($_POST['radioUnique'] == 'yes'){
			$unique = true;
		}else{
			$unique = false;
		}
		
		
		if(!isset($errors)){
			// form submission is good to go
			$message = 'Good luck with your numbers!';
			$success = true;
			
			if($game_type == 'select_powerball'){
				$num_balls = 69; // The number of balls to draw numbers from
				$num_pballs = 26; // The number of balls to draw powerballs from
				$num_numbers = 5; // The number of numbers to draw
			}elseif($game_type == 'select_megamillions'){
				$num_balls = 75;
				$num_pballs = 15;
				$num_numbers = 5;
			}else{
				$num_balls = 100;
				$num_pballs = 0;
				$num_numbers = 3;
			}
			
			$powerballs = array();
			if($userPowerball == true){
				for($n = 1; $n <= $num_tickets; $n++){
					$powerballs[$n] = $_POST['powerball_choice_'.$n];
				}
			}else{
				function getPowerBalls($min, $max, $quantity){
					$balls = range($min, $max);			
					shuffle($balls);
					return $balls[0];
				}
				for($m = 1; $m <= $num_tickets; $m++){
					$powerballs[$m] = getPowerBalls(1, $num_pballs, 1);
				}
			}			
			
			function randomGen($min, $max, $quantity, $exclusions) {
				$balls = range($min, $max);
				$balls = array_diff($balls, $exclusions);		
				shuffle($balls);
				return array_slice($balls, 0, $quantity);
			}
			
			$tixArray = array();
			if($unique == true){
				for($j = 1; $j <= $num_tickets; $j++){
					$tixArray[$j] = randomGen(1, $num_balls, $num_numbers, $powerballs);
				}
			}else{
				$tixArray[] = randomGen(1, $num_balls, $num_numbers, $powerballs);
			}
			
			
			// in case of unique, probably need to loop through num_tickets...
			// you left off working on the unique array...keep working
			$the_numbers = '';		
			for($tix = 1; $tix <= $num_tickets; $tix++){
				$the_numbers .= '<div class="ticket row">';
					if($unique == true){
						$ticket = $tixArray[$tix];
					}else{
						$ticket = $tixArray[0];
					}
					foreach($ticket as $number){
						$the_numbers .= '<div class="ball-box col-xs-2">
							<div class="ball">
								<span>'.$number.'</span>
							</div>
						</div>';
					}
					$the_numbers .= '<div class="col-xs-2">
						<div class="ball powerball"><span>'.$powerballs[$tix].'</span></div>
					</div>';
				$the_numbers .= '</div>';
			}
			
		}else{
			// something is wrong with the form submission, so throw the error message
			$errors_count = count($errors);
			$message = '<p>Please correct the following <strong>ERROR';
			if($errors_count > 1){
				$message .= 'S';
			}
			$message .= ':</strong></p>
			<ol>';
				foreach($errors as $error){
					$message .= '<li>'.$error.'</li>';
				}
			$message .= '</ol>';
			}
	}
?>

	<section id="powerball">
		<div class="container">
			<div class="row">
				<div class="col-xs-12 col-md-6 col-md-offset-3">
					<h2>Auto Lotto</h2>
					<p>Welcome to the <span class="ff-serif hippo">hippo</span> Auto Lotto numbers generator! Use the form below to generate your numbers.</p>
					<p><small>Obviously, this generator is simply meant to save you some time. There is absolutely zero implication that it will improve your chances of winning in any way. Play responsibly and at your own risk.</small></p>
					<p><strong> Good luck!</strong></p>
					
					<?php if(isset($message)){
						echo '<div class="form_message';
						if($success != true){
							echo ' bg-danger';
						}else{
							echo ' bg-success';
						}
						echo '">'.$message.'</div>
						<hr>';
						if(isset($the_numbers) && $success == true){
							echo $the_numbers;
						}
					}
					
					if($success != true){/* show the form */?>
				
						<form id="lotto_form" class="form" method="post">
							<h4>What game are you playing?</h4>
							<select class="form-control" name="game_type" id="game_type">
								<option value="select_powerball" selected>Powerball</option>
								<option value="select_megamillions">Mega Millions</option>
								<option value="select_test">Test</option>
							</select>
							<h4>How many sets of numbers would you like?</h4>
							<select class="form-control" name="sets" id="sets">
								<option value="1" selected>One</option>
								<option value="2">Two</option>
								<option value="3">Three</option>
								<option value="4">Four</option>
								<option value="5">Five</option>
							</select>
							<div id="choose_powerballs_wrap">
								<div class="radio">
									<h4>Would you like to enter your own <span class="ball-type">Powerball</span> numbers?</h4>
									<label>
										<input type="radio" id="radio_powerball_yes" name="radioPowerball" value="yes" readonly="true">
										Yes, please.
									</label>
									<label>
										<input type="radio" id="radio_powerball_no" name="radioPowerball" value="no" checked>
										No, thanks.
									</label>
								</div>
								<div id="powerball_choice_wrap" style="display:none;">
									<div id="powerball_choice_1_wrap" class="powerball_choice_wrap">
										<h4>Enter <span class="ball-type">Powerball</span> Number:</h4>
										<select class="powerball_select form-control" id="powerball_choice_1" name="powerball_choice_1" placeholder="[enter range here]" readonly="true"></select>
									</div>
								</div>
							</div>
							<div class="choose_random_wrap">
								<div class="radio">
									<h4>Would you like unique numbers for each ticket, or only unique <span class="ball-type">Powerball</span> numbers?</h4>
									<label>
										<input type="radio" id="unique_yes" name="radioUnique" value="yes" readonly="true">
										All numbers.
									</label>
									<label>
										<input type="radio" id="unique_no" name="radioUnique" value="no" checked>
										<span class="ball-type">Powerball</span>s only.
									</label>
								</div>
							</div>
							<button class="btn btn-red" type="submit">Go!</button>
						</form>
						
						<script>
							// Show or Hide #choose_powerballs_wrap based on game_type
							function toggleChooseNumbers(){
								$('#radio_powerball_yes, #radio_powerball_no').attr('readonly', true);
								var gameSelection = $('#game_type').val();
								if(gameSelection == 'select_powerball' || gameSelection == 'select_megamillions'){
									$('#choose_numbers').show();
									$('#radio_powerball_yes, #radio_powerball_no').removeAttr('readonly');
									// Change text of .ball-type based on choice
									if(gameSelection == 'select_powerball'){
										$('.ball-type').text('Powerball');
									}else if(gameSelection == 'select_megamillions'){
										$('.ball-type').text('Mega Ball');
									}
								}else{
									$('#choose_numbers').hide();
									$('#radio_powerball_yes, #radio_powerball_no').attr('readonly', true);
								}
							}
							
							$(document).ready(function(){
								toggleChooseNumbers();
							});
							
							$('#game_type').on('change', function(){
								toggleChooseNumbers();
							});
						</script>
						
						<script>
							// Show or Hide .powerball_choice based on radioPowerball
							$(document).ready(function(){
								$('select.powerball_select').attr('readonly', true);
								$('input[name$="radioPowerball"]').on('change', function(){
									var powerballYesNo = $(this).val();
									if(powerballYesNo == 'yes'){
										$('#powerball_choice_wrap').show();
										$('select.powerball_select').removeAttr('readonly');
									}else{
										$('#powerball_choice_wrap').hide();
										$('select.powerball_select').attr('readonly', true);
									}
								});
							});
						</script>
						
						<script>
							// Display correct number of powerball_choices based on number of sets
							function updatePowerballChoiceWrapHTML(){
								var numSets = $('#sets').val();
								console.log(numSets);
								var choiceDiv = [];
								for(var s = 1; s <= numSets; s++){
									choiceDiv[s] = '<div id="powerball_choice_' + s + '_wrap" class="powerball_choice_wrap">' +
										'<h4>Enter <span class="ball-type">Powerball</span> Number:</h4>' +
										'<select class="powerball_select form-control" id="powerball_choice_' + s + '" name="powerball_choice_' + s + '" placeholder="[enter range here]"></select>' +
									'</div>';
								}
								$('#powerball_choice_wrap').html(choiceDiv);
							}
							
							$(document).ready(function(){
								updatePowerballChoiceWrapHTML();
							});
							
							$('#sets').on('change', function(){
								updatePowerballChoiceWrapHTML();
							});
						</script>
						
						<script>
							// Display correct number of balls to choose from based on game_type
							function updatePowerballSelectHTML(){
								var pballs = 0;
								var gameSelection = $('#game_type').val();
								var ballOption = [];
								if(gameSelection == 'select_powerball'){
									pballs = 26;
								}else if(gameSelection == 'select_megamillions'){
									pballs = 15;
								}else{
									pballs = 0;										
								}
								for( var i = 1; i <= pballs; i++){
									ballOption[i] = '<option value="' + i + '">' + i + '</option>';
								}
								$('.powerball_select').html(ballOption);
							}
							
							$(document).ready(function(){
								updatePowerballSelectHTML();
							});
							
							$('#game_type').on('change', function(){
								updatePowerballSelectHTML();
							});
						</script>
							
					<?php } /* endif */?>					
				</div>
			</div><!-- .row -->
		</div><!-- .container -->
	</section>
			
<?php include('inc/footer.php');?>
