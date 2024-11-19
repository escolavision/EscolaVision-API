<?php
class EscolaVision
{
	private $host = 'localhost';
	private $user = 'admin';
	private $password = "Fy1AE0nvvyLC";
	private $database = "EscolaVision";

	//Fy1AE0nvvyLC

	public function dameConexion()
	{
		$conn = new mysqli($this->host, $this->user, $this->password, $this->database);
		$conn->set_charset("utf8"); //Para evitar problemas con tildes, ñ y caracteres no estandar
		if ($conn->connect_error) {
			die("Error al conectar con MYSQL" . $conn->connect_error);
		} else {
			return $conn;
		}
	}
}
?>