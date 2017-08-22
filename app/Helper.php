<?php

use Carbon\Carbon;

function getTime($diff=30){
	$day = new Carbon('yesterday');
	$end = new Carbon('today');
	$html='<option value="open24">Open 24 hours</option>';
	$html.='<option value="closed" hidden>Closed</option>';
	while($day < $end){
		$html.='<option>'.$day->format('H:i').'</option>';
		$day=$day->addMinutes($diff);
	}
	echo $html;
}