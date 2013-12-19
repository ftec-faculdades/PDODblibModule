<?php

namespace PDODblibModule\Doctrine\DBAL\Driver\PDODblib;

/**
 * The PDO-based Dblib driver.
 *
 * @since 2.0
 */
class Driver implements \Doctrine\DBAL\Driver {
	public function connect(array $params, $username = null, $password = null, array $driverOptions = array()) {
		return new Connection(
			$this->_constructPdoDsn($params),
			$username,
			$password,
			$driverOptions
		);
	}

	/**
	 * Constructs the Dblib PDO DSN.
	 *
	 * @return string  The DSN.
	 */
	private function _constructPdoDsn(array $params) {
		$dsn = 'dblib:host=';

		if (isset($params['host'])) {
			$dsn .= $params['host'];
		}

		if (isset($params['port']) && !empty($params['port'])) {
			$portSeparator = (PATH_SEPARATOR === ';') ? ',' : ':';
			$dsn .= $portSeparator . $params['port'];
		}

		if (isset($params['dbname'])) {
			$dsn .= ';dbname=' . $params['dbname'];
		}
		return $dsn;
	}

	public function getDatabasePlatform() {
		
		if (class_exists('\\Doctrine\\DBAL\\Platforms\\SQLServer2008Platform')) {
			return new \Doctrine\DBAL\Platforms\SQLServer2008Platform();
		}
		
		if (class_exists('\\Doctrine\\DBAL\\Platforms\\SQLServer2005Platform')) {
			return new \Doctrine\DBAL\Platforms\SQLServer2005Platform();
		}

		if (class_exists('\\Doctrine\\DBAL\\Platforms\\MsSqlPlatform')) {
			return new \Doctrine\DBAL\Platforms\MsSqlPlatform();
		}
	}

	public function getSchemaManager(\Doctrine\DBAL\Connection $conn) {
		if (class_exists('\\Doctrine\\DBAL\\Schema\\SQLServerSchemaManager')) {
			return new \Doctrine\DBAL\Schema\SQLServerSchemaManager($conn);
		}

		if (class_exists('\\Doctrine\\DBAL\\Schema\\MsSqlSchemaManager')) {
			return new \PDODblibModule\Doctrine\DBAL\Schema\PDODblibSchemaManager($conn);
		}


	}

	public function getName() {
		return 'pdo_dblib';
	}

	public function getDatabase(\Doctrine\DBAL\Connection $conn) {
		$params = $conn->getParams();
		return $params['dbname'];
	}
}
