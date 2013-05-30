<?php

/**
 * Ligação Base Dados
 *
 * @author Paulo Carvalho
 */
class DataBase {
    private $host;
    private $user;
    private $pass;
    private $database;
   
    /**
     * Ligação BD
     * 
     * @var object
     */
    private $connection;
    
    /**
     * Retorno valor Query
     * 
     * @var resource
     */
    private $queryID;
    public $sql;
    
    /**
     * Informação de erro do Mysql
     * 
     * @var string
     */
    public $error;
    public $errorNum;
    
    /**
     * Registos da Query
     * 
     * @var array
     */
    private $registos;
    
    /**
     * Construtor da classe
     * 
     * @param string Host da ligação
     * @param string User da ligação
     * @param string passaword da ligação
     * @param string Base de Dados
     * 
     * @return void
     */
	public function __construct($host, $user, $pass, $database){
		$this->host = $host;
		$this->user = $user;
		$this->pass = $pass;
		$this->database = $database;
	}

	/**
	 * Criar ligação
	 * 
	 * @return void
	 */
	private function makeConnection(){
		$this->connection = @mysql_connect($this->host, $this->user, $this->pass);
		if ($this->connection) {
			@mysql_select_db($this->database, $this->connection);
		} else {
			$this->error = mysql_error();
		}

	}
	
	/**
	 * Começar Transação
	 * 
	 * @return void
	 */
	public function BeginTransaction(){
		
		$this->query("SET AUTOCOMMIT=0");
		$this->query("BEGIN");
	}
	
	/**
	 * Commit Transação
	 * 
	 * @return void
	 */
	public function Commit() {
		
		$this->query("COMMIT");
		
	}
	/**
	 * rollback transação
	 * 
	 * @return void
	 */
	public function RollBack(){
		
		$this->query("ROLLBACK");
	}
	
	
	
	
	/**
	 * Execução da Query
	 * 
	 * @param string $query
	 * 
	 * @return Boolean
	 */
	public function query($query) {
		if (!$this->connection) {
			$this->makeConnection();
			if ($this->error){
				$this->errorNum = mysql_errno();

				return false;
			}
		}
		$this->sql = $query;
        $this->queryID = @mysql_query($query);
		$this->error = mysql_error();

		
		if ($this->error){ 
			$msg_erro = "Erro : " . $this->error . " \n Query: " . $this->sql;
			$this->errorNum = mysql_errno();
			mail('internet@manz.pt', 'ERRO BD', $msg_erro );
			return false;
		}

		return true;
	}

	/**
	 * Retorna número de linhas da Query
	 * 
	 * @return int
	 */
		public function nLinhas() {
		$num = mysql_num_rows($this->queryID);
		return $num;
	}
	
	/**
	 * Retorna número de linhas afectadas pela Query
	 * 
	 * @return int
	 */
		public function lAfectadas() {
		$num = mysql_affected_rows();
		return $num;
	}
        
        /**
	 * Retorna ultimo id inserido
	 * 
	 * @return int
	 */
	public function lastid() {
		return mysql_insert_id();
	}


	/**
	 * Proxima Linha de Registos da Query
	 * 
	 * @return mixed
	 */
	public function next(){
		$this->registos = mysql_fetch_array($this->queryID);
		if (count($this->registos) == 0){
			return false;
		}else{
			return $this->registos;
		}
	}

	/**
	 * Retorno do campo da linha da query
	 * 
	 * @para string $campo
	 * 
	 * @return string
	 */
	public function c($campo){
		return $this->registos[$campo];
	}

}