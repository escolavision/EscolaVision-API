<?php
class Preguntas
{
	private $tabla = "pregunta";
	public $id;
	public $idtest;
	public $enunciado;
	private $conn;

	public function __construct($db)
	{
		$this->conn = $db;
	}

	// Método para leer registros de la base de datos
	function leer()
	{
		if (isset($this->id) && $this->id >= 0) {
			$stmt = $this->conn->prepare("SELECT * FROM " . $this->tabla . " WHERE id = ?");
			$stmt->bind_param("i", $this->id);
		} else { 
			$stmt = $this->conn->prepare("SELECT * FROM " . $this->tabla);
		}
		$stmt->execute();
		$result = $stmt->get_result();
		return $result;
	}

	// Método para insertar un nuevo registro en la tabla alumno
	function insertar()
	{
		$stmt = $this->conn->prepare("INSERT INTO " . $this->tabla . "(`idtest`, `enunciado`) VALUES(?,?)");

		$this->idtest = strip_tags($this->idtest);
		$this->enunciado = strip_tags($this->enunciado);

		$stmt->bind_param("ss", $this->idtest, $this->enunciado);

		return $stmt->execute();

	}
	

	// Método para actualizar un registro existente
	function actualizar()
	{
		$stmt = $this->conn->prepare("UPDATE " . $this->tabla . " SET idtest = ?, enunciado = ? WHERE id = ?");


		$this->idtest = strip_tags($this->idtest);
   		$this->enunciado = strip_tags($this->enunciado);
		$this->id = strip_tags($this->id);
		
		$stmt->bind_param("ssi", $this->idtest, $this->enunciado, $this->id);

		return $stmt->execute();
	}

	// Método para borrar un registro
	function borrar()
	{
		$stmt = $this->conn->prepare("DELETE FROM " . $this->tabla . " WHERE id = ?");
		$this->id = strip_tags($this->id);
		$stmt->bind_param("i", $this->id);
		return $stmt->execute();
	}
}
?>
