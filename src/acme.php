<?php

$filename = '../files/jobhours.txt';
$handle = fopen($filename, "r");

if ($handle) {
    while (($line = fgets($handle)) !== false) {
        validateLine($line);
    }
    fclose($handle);
}

function validateLine($a)
{
	$wordsize=strlen(chop($a));
	$namesize=0;

    for($i=0;$i<=$wordsize;$i++)
    {
    	$cad=substr($a,$i,1);
    	if($cad=='='){
    		$name=substr($a, 0,$i);
    		$namesize=$i;
    	}
    }
    if($namesize>0)
    {
        validateHours($name,$a,$wordsize,$namesize);
    }
}

function validateHours($nm,$cl,$ws,$ns)
{   
	$ranksize=14;
	$daysize=2;
	$hrsize=5;
	$workeddays=($ws-$ns)/$ranksize;
	$amount=0;
	$ns++;
	for($j=$workeddays;$j>0;$j--)
	{
		//Days
		$day=substr($cl, $ns,$daysize);
		$inhr=substr($cl, ($ns+$daysize),$hrsize);
		$outhr=substr($cl, ($ns+$daysize+$hrsize+1),$hrsize);
		$ns=$ns+$ranksize;

		//Hours
		$hr2 = new DateTime($outhr);
		$hr1 = new DateTime($inhr);
		$difhr = date_diff($hr2, $hr1);
		$workedhrs = $difhr->format('%H');

		switch ($day) {
			case 'MO':
			case 'TU':
			case 'WE':
			case 'TH':
			case 'FR':
				if ($inhr>"00:00" && $inhr<"09:00"){
					$salary=25;
				}elseif ($inhr>="09:00" && $inhr<"18:00") {
					$salary=15;
				}else{
					$salary=20;
				}
				break;
			case 'SA':
			case 'SU':
				if ($inhr>"00:00" && $inhr<"09:00"){
					$salary=30;
				}elseif ($inhr>="09:00" && $inhr<"18:00") {
					$salary=20;
				}else{
					$salary=25;
				}
				break;	
			default:
				echo "Error. Please check the days abbreviations.";
				break;
		}
		$pay=$workedhrs*$salary;
		$amount=$amount+$pay;
	}
	echo "The amount to pay ".$nm." is : ".$amount." USD.<br>";    
}

?>

