<?php
require_once('classes/User.php');

$user = new User("data.json");
?>
<!DOCTYPE html>
<html>

	<head>
		<title><?= $user->complete_name() ?></title>
		<meta charset="utf-8">
		<link href="css/stylesheet.css" rel="stylesheet" type="text/css" media="screen" >
		<link href="css/print.css" rel="stylesheet" type="text/css"  media="print">
		<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.3.0/Chart.bundle.min.js"></script>
	</head>


	<body>

		<header>
			<h1><?= $user->complete_name() ?></h1>
			<p>Web-developper</p>
		</header>


		<div id="contact" style="display:none">
			<p>Rousseau Alexandre</p>
			<div id="contact_icons">
				<a href="mailto:<?= $data["user"]["email"] ?>?subject=Votre%20CV"><img src="img/mai.png"></a>
				<?= $user->print_links() ?>
			</div>
		</div>


		<section>
			<h2>Compétences</h2>
			<div id="competencies_container"><canvas id="competencies" height="150"></></canvas></div>
		</section>


		

		<!--  professional experience in POO-->
		<section>
			<h2>Timeline</h2>
			<div id="timeline1" style="width:100%;"></div>
		</section>

		<section>


			<?php foreach( $user->professionalExperiences as $professionalExp)://loop on all professionalExperiences ?>
				<h2><?= $professionalExp->title() ?></h2>


					<ul class="experience" ><?php foreach($professionalExp->activities as $activity){//loop on all activities into this activity
								echo $activity->to_html() ;
							} // next activity ?>
						
					<?php endforeach // next activity ?></ul>
					
				
		</section>


		

		<!--  personal experience in POO-->
		<section>
			<h2>Experience personnelle</h2>

			<?php// foreach( $user->personalExperiences as $personalExp)://loop on all personalExperiences ?>
				<h3><?// = $personalExp->title() ?></h3>
				<ul class="experience" >
					<?php// foreach($personalExp->activities as $activity){//loop on all activities into this activity
						//echo $activity->to_html() ;
					//} // next activity ?>
				</ul>
			<?php //endforeach // next activity*/?>
		</section>



		<section>
			<h2>Etudes et formations</h2>

			<h3>Parcours scolaire</h3>
			<ul>
				<?php foreach($user->diplomas as $diploma): ?>
					<li><?= $diploma->title() ?></li>
				<?php endforeach ?>
			</ul>

			<h3>Formation et aptitudes</h3>
			<ul>
				<?php foreach($user->trainings as $training ): ?>
					<li><?= $training->title() ?></li>
				<?php endforeach ?>
			</ul>

			<h3>Langues</h3>
			<ul class="experience">
				<?php foreach( $user->langages as $langage){
					echo $langage->to_html();
				} ?>
			</ul>

		</section>


	<footer>
		<p><?= $user->birth_date->format('Y-m-d') ?> à <?= $user->town_birth ?></p>
		<p><adress><?= $user->adress ?></adress></p>
		<p><strong><?= $user->phone ?></strong></p>
		<p><a href="mailto:<?= $user->email ?>?subject=Votre%20CV"><?= $user->email ?></a></p>
		<hr/>
		<div>Icons made by <a href="http://www.flaticon.com/authors/freepik" title="Freepik">Freepik</a> from <a href="http://www.flaticon.com" title="Flaticon">www.flaticon.com</a> is licensed by <a href="http://creativecommons.org/licenses/by/3.0/" title="Creative Commons BY 3.0" target="_blank">CC 3.0 BY</a></div>
	</footer>

	<script type="text/javascript" src="js/d3_v2_min.js"></script>
	<script type="text/javascript" src="js/timeknots-min.js"></script>

	<script type="text/javascript" src="js/ribbon.js"></script>


	<script>
		// draw comptencies graph
		var experiences = <?= $user->professionalExperiences[0]->to_json() ?> ;

		var ctx = document.getElementById("competencies").getContext('2d');
		var data = <?= $user->compentencies_to_json()?>;
		var option = { maintainAspectRatio: false };
		var myRadarChart = new Chart(ctx , {  type: 'bar' , data: data , options: option });
	
		// draw timeknots

		TimeKnots.draw("#timeline1", experiences, {
			dateFormat: "%B %Y", 
			colorTimeline: "#2c3e50", colorTip: "#2c3e50",
			backgroundCircle: '#ecf0f1', backgroundTip: 'transparent',
			showLabels: true, labelFormat: "%Y",tipPosition: 'top', height: '100'});
	
	</script>

</body></html>
