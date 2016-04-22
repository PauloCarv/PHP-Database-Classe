# PHP-Database-Classe
PHP Classes

Um simples Classe PHP que permite parameterizar ligações a diferentes bases dados e com funções ja definidas para as 
operações de bases de dados habitualmente utilizadas en formulários / consultas PHP.

O exemplo disponibizado permite parameterizar no config.php (array) uma ou mais ligações a uma bases de dados MySql.

<strong>Exemplo:</strong>

<code>


$db = new DataBase($config["db1"]["host"], $config["db1"]["user"], $config["db1"]["pass"], $config["db1"]["database"]);

$qry = "SELECT nome, idade, morada 
	      FROM users";
$db->query($qry);

if ($db->nLinhas() != 0) {
	
	while($db->next()){
		
		echo $db->c('nome') . " - " . $db->c('idade');
		
	}
	
}

</code>
