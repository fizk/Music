<?php


	$pdo = new PDO("mysql:dbname=music;host=127.0.0.1","root","");
	$statement = $pdo->prepare("INSERT INTO `Tsort` 
		(`artist`,`name`,`type`,`year`,`score`,`songentry_pos`,`songyear_pos`,`songartist_pos`,`songtitle_pos`,`songdecade_pos`,`namsong_pos`,`eursong_pos`,`albumentry_pos`,`albumyear_pos`,`albumartist_pos`,`albumdecade_pos`,`notes`) VALUES 
		(:artist, :name, :type, :year, :score, :songentry_pos, :songyear_pos, :songartist_pos, :songtitle_pos, :songdecade_pos, :namsong_pos, :eursong_pos, :albumentry_pos, :albumyear_pos, :albumartist_pos, :albumdecade_pos, :notes)");

if (($handle = fopen($argv[1], "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
		$statement->execute(array(
				"artist" 			=> $data[0],
				"name" 				=> $data[1],
				"type" 				=> $data[2],
				"year" 				=> (int)$data[3],
				"score" 			=> (real)$data[4],
				"songentry_pos" 	=> (is_numeric($data[5])) ? $data[5] : null ,
				"songyear_pos" 		=> (is_numeric($data[6])) ? $data[6] : null ,
				"songartist_pos" 	=> (is_numeric($data[7])) ? $data[7] : null ,
				"songtitle_pos" 	=> (is_numeric($data[8])) ? $data[8] : null ,
				"songdecade_pos" 	=> (is_numeric($data[9])) ? $data[9] : null ,
				"namsong_pos" 		=> (is_numeric($data[10])) ? $data[10] : null ,
				"eursong_pos" 		=> (is_numeric($data[11])) ? $data[11] : null ,
				"albumentry_pos" 	=> (is_numeric($data[12])) ? $data[12] : null ,
				"albumyear_pos" 	=> (is_numeric($data[13])) ? $data[13] : null ,
				"albumartist_pos" 	=> (is_numeric($data[14])) ? $data[14] : null ,
				"albumdecade_pos" 	=> (is_numeric($data[15])) ? $data[15] : null ,
				"notes" 			=> $data[16]
	    	)
		);
    }
    fclose($handle);
}
