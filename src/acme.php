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
	$name="xxxxx";
	$namesize=0;
    //echo nl2br($a);
    for($i=0;$i<=$wordsize;$i++)
    {
    	//echo "i=".$i;
    	//echo "wordsize:".$wordsize;
    	$cad=substr($a,$i,1);
    	//echo "cad=".$cad;
    	if($cad=='='){
    		$name=substr($a, 0,$i);
    		$namesize=$i;
    		//echo $name;
    	}
    }
    if($namesize>0)
    {
       	echo nl2br($name);
        validateHours($a,$wordsize,$namesize);
    }
}

function validateHours($cl,$ws,$ns)
{   
	$ranksize=14;
	$daysize=2;
	$hrsize=5;
	$workeddays=($ws-$ns)/$ranksize;
	$ns++;
	echo "workeddays=".$workeddays;
	echo "ws = ".$ws;
	echo "ns = ".$ns;
	echo " primerdia=".substr($cl, $ns,$ranksize);
	for($j=$workeddays;$j>0;$j--)
	{
		//Días
		//echo "dd=".substr($cl, $ns,$daysize);
		$day=substr($cl, $ns,$daysize);
		$inhr=substr($cl, ($ns+$daysize),$hrsize);
		$outhr=substr($cl, ($ns+$daysize+$hrsize+1),$hrsize);
		echo "<br>"."dd=".$day;
		$ns=$ns+$ranksize;

		//Horas
		$datex7 = new DateTime($outhr);
		$datex77 = new DateTime($inhr);
		$horax7 = date_diff($datex7, $datex77);
		echo "<br>";
		echo $workedhrs = $horax7->format('%H');

		switch ($day) {
			case 'MO':
			case 'TU':
			case 'WE':
			case 'TH':
			case 'FR':
				echo " entresemana entró a las ".$inhr;
				echo " y salió a las ".$outhr;
				echo " trabajó ".$workedhrs." hrs";
				break;
			case 'SA':
			case 'SU':
				echo " finecito entró a las ".$inhr;
				echo " y salió a las ".$outhr;
				echo " trabajó ".$workedhrs." hrs";
				break;	
			default:
				echo "no existe dia";
				break;
		}
	}
	echo "<br>";    
}

?>

