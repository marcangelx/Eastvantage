<?php
namespace Utility;
class DB
{
	private $pdo;

	private static $instance = null;

	private function __construct()
	{
		$dsn = 'mysql:dbname=phptest;host=127.0.0.1';
		$user = 'root';
		$password = '';
		// Set options for PDO to throw error informations
		// This is useful for debugging
		$options = [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
        ];

		try {
            $this->pdo = new \PDO($dsn, $user, $password, $options);
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
		
	}

	public static function getInstance()
	{
		if (null === self::$instance) {
			$c = __CLASS__;
			self::$instance = new $c;
		}
		return self::$instance;
	}

	public function select(string $sql)
	{
		$sth = $this->pdo->query($sql);
		return $sth->fetchAll();
	}

	public function exec(string $sql)
	{
		return $this->pdo->exec($sql);
	}

	public function pdoStatement(string $sql, array $aParams = array())
	{

		foreach($aParams as $aParam) {
			$this->pdo->quote($aParam);
		}
	
		$sStatement = $this->pdo->query($sql);
		return $sStatement;
	}

	public function lastInsertId()
	{
		return $this->pdo->lastInsertId();
	}
}