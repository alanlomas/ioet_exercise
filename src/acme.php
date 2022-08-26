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
				if ($inhr>"00:00" && $inhr<"09:00"){
					$salary=25;
				}elseif ($inhr>"09:00" && $inhr<"18:00") {
					$salary=15;
				}else{
					$salary=20;
				}
				/*00:01 - 09:00 25 USD
				09:01 - 18:00 15 USD
				18:01 - 00:00 20 USD*/
				break;
			case 'SA':
			case 'SU':
				echo " finecito entró a las ".$inhr;
				echo " y salió a las ".$outhr;
				echo " trabajó ".$workedhrs." hrs";
				if ($inhr>"00:00" && $inhr<"09:00"){
					$salary=30;
				}elseif ($inhr>"09:00" && $inhr<"18:00") {
					$salary=20;
				}else{
					$salary=25;
				}
				break;	
			default:
				echo "no existe dia";
				break;
		}
		$pay=$workedhrs*$salary;
		$amount=$amount+$pay;
		echo "El $day cobró $ $pay por $workedhrs trabajadas.";
	}
	echo "<br>The amount to pay ".$nm." is : ".$amount." USD.<br>";    
}

?>

