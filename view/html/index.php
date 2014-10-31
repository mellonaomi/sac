<?php 
	require_once dirname(__FILE__).'/layout.php';
	
	layoutHeader('Start', View::baseUrl());
	
	$aData 			= View::data();
	$aEvents 		= $aData['events'];
	$aAttending 	= $aData['authenticated'] ? $aData['attending'] : array();

	echo '<div class="jumbotron">';
		echo '<div class="container">';
			echo '<h1>Semana Acadêmica Computação</h1>';
			echo '<p>20 a 26 de Novembro, 2014</p>';
		echo '</div>';
	echo '</div>';
	
	if($aData['authenticated']) {
		echo '<div class="container">';
			echo '<div class="row">';
				echo '<div class="col-md-12" id="payment-panel">';
				echo '</div>';
			echo '</div>';
		echo '</div>';
	}
	
	echo '<div class="container">';
		echo '<div class="row">';
			echo '<div class="col-md-12">';
				foreach($aEvents as $aDate => $aList) {
					echo '<div class="panel panel-default item-descriptor">';
						echo '<div class="panel-heading"><strong>'.$aDate.'</strong></div>';
						echo '<div class="panel-body">';
							echo '<table class="table table-hover">';
								echo '<thead>';
									echo '<th style="width: 10%;">Horário</th>';
									echo '<th style="width: 55%;">Atividade</th>';
									echo '<th style="width: 10%;">Local</th>';
									echo '<th style="width: 10%;">Custo</th>';
									echo '<th style="width: 5%;">Vagas</th>';
									
									if($aData['authenticated']) {
										echo '<th style="width: 10%;">Ações</th>';
									}
								echo '</thead>';
								echo '<tbody>';
									foreach($aList as $aIdEvent => $aInfo) {
										echo '<tr>';
											echo '<td>'.$aInfo['time'].'</td>';
											echo '<td><strong>'.$aInfo['title'].'</strong><br/>'.$aInfo['description'].'</td>';
											echo '<td>'.$aInfo['place'].'</td>';
											echo '<td>'.($aInfo['price'] > 0 ? 'R$ ' . $aInfo['price'] : '-').'</td>';
											echo '<td>'.($aInfo['capacity'] != 0 ? $aInfo['capacity'] : '-').'</td>';
											
											if ($aData['authenticated']) {
												echo '<td id="panel-event-'.$aIdEvent.'">';
													if (is_numeric($aInfo['fk_competition'])) {
														echo '<a href="competition.php?competition='.$aInfo['fk_competition'].'">Saber mais</a>';
														
													} else {
														if (isset($aAttending[$aIdEvent])) {
															echo '<span class="label label-success">Inscrito</span>';
															echo '<a href="#" onclick="SAC.unsubscribe('.$aIdEvent.')">[X]</a>';
														} else {
															echo '<a href="#" onclick="SAC.subscribe('.$aIdEvent.', '.($aInfo['capacity'] != 0 ? 'true' : 'false').')">[S]</a>';
														}
													}
												echo '</td>';
											}
										echo '</tr>';
									}
								echo '</tbody>';
							echo '</table>';
						echo '</div>';
					echo '</div>';
				}
			echo '</div>';
		echo '</div>';
	echo '</div>';
	
	echo "<script>SAC.loadPaymentInfo('payment-panel');</script>";
	
	layoutFooter(View::baseUrl());
?>