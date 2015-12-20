<?php

namespace PDO\Contracts;

interface DatabaseConnection
{
	public function connect();

	public function disconnect();

	public function getConnection();
}