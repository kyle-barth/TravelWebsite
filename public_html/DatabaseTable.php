<?php
	class DatabaseTable {
		private $table;
		private $pdo;

		public function __construct($pdo, $table) {
			$this->pdo = $pdo;
			$this->table = $table;
		}

		function search($field, $value) {
	    $stmt = $this->pdo->prepare("SELECT * FROM " . $this->table . " " . $field . " ". $value);

			if (isset($value)) {
				$criteria = [
					'value' => $value
				];

				$stmt->execute($criteria);
			}else{
				$stmt->execute();
			}

			return $stmt;
	  }

		function delete($field, $value) {
			$query = 'DELETE FROM ' . $this->table . ' WHERE ' . $field . ' = :value';
			$stmt = $this->pdo->prepare($query);
			$criteria = [
				'value' => $value
			];

			// v For PHPUnit Tests
			$bool = false;
			if($stmt->execute($criteria))
				$bool = true;

			return $bool;
			// ^ For PHPUnit Tests

			// For running website (not PHPUnit testing)
			// $stmt->execute($criteria);
			// return $stmt->fetch();
			// For running website (not PHPUnit testing)
		}

		function insert($record) {
			$keys = array_keys($record);
			$values = implode(', ', $keys);
			$valuesWithColon = implode(', :', $keys);
			$query = 'INSERT INTO ' . $this->table . ' (' . $values . ') VALUES (:' . $valuesWithColon . ')';
			$stmt = $this->pdo->prepare($query);

			// v For PHPUnit Tests
			$bool = false;
			if($stmt->execute($record))
				$bool = true;
			return $bool;
			// ^ For PHPUnit Tests

			if ($this->table=="articles")
				sendMail($this->table);
		}

		function update($record, $primaryKey) {
			$query = 'UPDATE ' . $this->table . ' SET ';
			$parameters = [];
			foreach ($record as $key => $value) {
				$parameters[] = $key . ' = :' .$key;
			}
			$query .= implode(', ', $parameters);
			$query .= ' WHERE ' . key($record) . ' = :primaryKey';
			$record['primaryKey'] = $primaryKey;
			$stmt = $this->pdo->prepare($query);

			// v For PHPUnit Tests
			$bool = false;
			if($stmt->execute($record))
				$bool = true;
			return $bool;
			// ^ For PHPUnit Tests
		}
	}
?>
