<?php 

class Sql extends PDO{
	
	private $conn;

	//Criando a conexão com o Banco de Dados
	public function __construct(){
		//Mudei de SQLServer para MySQL pq o Management está com problemas
		//$this->conn = new PDO("sqlsrv:Database=hcode; server=localhost\SQL2017;ConnectionPooling=0", "sa","root");
		$this->conn = new PDO("mysql:dbname=dbphp7;host=localhost","root","");
	}

	//Método para receber os dados para fazer o bindParam
	private function setParams($stmt, $parametros=array()){

		foreach ($parametros as $key => $value) {
			
			$this->setParam($stmt, $key, $value);
		}
	}

	//Método para setar o bindParam dinamicamente
	private function setParam($stmt, $key, $value){

		$stmt->bindParam($key, $value);
	}

	//Método para PREPARAR o Banco de Dados
	public function query($rawQuery, $parametros = array()){

		//$stmt é uma variável só acessada dentro do método
		$stmt = $this->conn->prepare($rawQuery);

		$this->setParams($stmt, $parametros);

		//Executando a query
		$stmt->execute();

		//Retornando o objeto
		return $stmt;
		
	}

	//Criando o método SELECT
	public function select($rawQuery, $parametros=array()):array
	{

		//executando o método chamando a função query() que já contém tudo o que preciso
		$stmt = $this->query($rawQuery, $parametros);

		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}


}


