<?php
class Test
{
	private $tabla = "test";
	public $id;
	public $nombretest;
	private $conn;

	public function __construct($db)
	{
		$this->conn = $db;
	}

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

	function insertar()
	{
		$stmt = $this->conn->prepare("INSERT INTO " . $this->tabla . "(`nombretest`) VALUES(?)");

		$this->nombretest = strip_tags($this->nombretest);

		$stmt->bind_param("s", $this->nombretest);

		return $stmt->execute();

	}
	

	function actualizar()
	{
		$stmt = $this->conn->prepare(" UPDATE " . $this->tabla . " SET nombretest= ? WHERE id = ?");

		$this->nombretest = strip_tags($this->nombretest);
		$this->id = strip_tags($this->id);
		$stmt->bind_param("si", $this->nombretest, $this->id);

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
