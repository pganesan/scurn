<?php

class DBUtil {
	// constants
	const HOST = "dbserver.engr.scu.edu:3306";
	const USER = "pganesan";
	const PASS = "sdb_password";
	const DB_NAME = "sdb_pganesan";

	private $link;
	
	/**
	 * connect to database
	 * @return resultset
	 */
	public function connect() {
		$this -> link = mysql_connect(DBUtil::HOST, DBUtil::USER, DBUtil::PASS) or die(mysql_error());
		mysql_select_db(DBUtil::DB_NAME, $this -> link) or die(mysql_error());
	}

	/**
	 * function for select sql
	 */
	public function select($query) {
		$result = mysql_query($query, $this -> link);
		if (!$result)
			die(mysql_error());

		return $result;
	}

	/**
	 * close a db connection
	 */
	public function close() {
		mysql_close($this -> link) or die(mysql_error());
	}

	/**
	 * function for insert sql
	 * @return the ID column of last inserted record or 0 if there was no ID
	 */
	public function insert($query) {
		mysql_query($query) or die(mysql_error());
		return mysql_insert_id($this -> link);
	}

	/**
	 * function for update sql
	 * @return the number of rows updated
	 */
	public function update($query) {
		mysql_query($query) or die(mysql_error());
		return mysql_affected_rows($this -> link);
	}
	
	/**
	 * function to delete rows
	 * @return number of records deleted by the sql
	 */
	public function delete($query) {
		mysql_query($query) or die(mysql_error());
		return mysql_affected_rows($this -> link);
	}

	/**
	 * function to check if a db connection is alive
	 * @return if the connection is active, false otherwise
	 */
	public function isConnected() {
		if (!empty($this -> link)) {
			return mysql_ping($this -> link);
		} else {
			return false;
		}
	}
	
	/**
	 * function to iterate over the resultset and return one row
	 */
	public function iterate($resultset) {
		$row = mysql_fetch_assoc($resultset);
		return $row;
	}

}
?>