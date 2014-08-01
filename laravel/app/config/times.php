<?php

$d = new DateTime('00:00'); // Initialise DateTime object .
$i = new DateInterval('PT5M'); // New 45 minute date interval.
$temp = [];

while (	true) 
{
	$v = $d->format('Hi');
	
	$temp[$v] = $d->format('H:i');

	if ( $v == 2355)
		break;

	$d->add($i);
}
return $temp;