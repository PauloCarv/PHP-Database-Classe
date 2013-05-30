
<?php

/*
 * Alguns Exemplos para ligação a BD
 * 
 * 
 */


require("DataBase.php");
$config = include_once('config.php');




//Usa o primeiro indice do config.php
//Pode criar mais indices e efetuar a ligação em alturas distintas


$db = new DataBase($config["db1"]["host"], $config["db1"]["user"], $config["db1"]["pass"], $config["db1"]["database"]);

$qry = "SELECT nome, idade, morada 
	      FROM users";

$db->query($qry);


//Exemplo para contador de linhas

if ($db->nLinhas() != 0) {
	
	//fetch bd
	
	while($db->next()){
		
		echo $db->c('nome') . " - " . $db->c('idade');
	}
	
	
}


?>
