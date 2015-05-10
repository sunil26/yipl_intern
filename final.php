<?php
// This portion of the code opens award.csv and contract.csv and put the contents in an array $award[] and $contract[] in our case
  $fh = fopen('awards.csv', 'r');
        $fhg = fopen('contracts.csv', 'r');
         while (($data = fgetcsv($fh, 0, ",")) !== FALSE) {
            $awards[]=$data;
        }
        while (($data = fgetcsv($fhg, 0, ",")) !== FALSE) {
                $contracts[]=$data;
        }
 // First word of every array is compared, if strings are matched then lines are merged
        for($x=0;$x< count($contracts);$x++)
        {
            if($x==0){
                unset($awards[0][0]);
                $line[$x]=array_merge($contracts[0],$awards[0]); //header
            }
            else{
                $deadlook=0;
                for($y=0;$y <= count($awards);$y++)
                {
                    if($awards[$y][0] == $contracts[$x][0]){
                        unset($awards[$y][0]);
                        $line[$x]=array_merge($contracts[$x],$awards[$y]);
                        $deadlook=1;
                    }           
                }
                if($deadlook==0)
                    $line[$x]=$contracts[$x];
            }
        }
  // final.csv file is created from this portion 
        $fp = fopen('final.csv', 'w');//output file set here

        foreach ($line as $fields) {
            fputcsv($fp, $fields);
        }
        fclose($fp);


// 
	$sum = 0;
	foreach ($line as $field)
	{
		
		if($field[1]=="Current" && $field[12])
		{
		$sum = $sum+$field[12];
		}
	}
	echo "Total Amount of current contracts: ".$sum;

?>