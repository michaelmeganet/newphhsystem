<?php

class Dbh {

	private $servername;
	private $username;
	private $password;
	private $dbname;
	private $charset;

	public function connect() {
		$this->servername ="localhost";
                #$this->servername ='192.168.83.12';
		#$this->servername = '192.168.102.11';
                $this->username = "root";
		$this->password = "5105458";
		$this->dbname = "test-phhsystem";
		$this->charset = "utf8";

		try {
			$dsn = "mysql:host=".$this->servername.";dbname=".$this->dbname.";charset=".$this->charset;
                        #echo $dsn;
			$pdo = new PDO($dsn, $this->username, $this->password);
			// $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $pdo;
		} catch (PDOException $e) {
			echo "Connection failed: ".$e->getMessage();
		}
	}

}

