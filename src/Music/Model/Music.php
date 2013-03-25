<?php

namespace Music\Model;

use PDO;
use DateTime;

class Music{

	private $_datasource = null;

	public function __construct( PDO $datasource ){
		$this->_datasource = $datasource;
	}

	/**
	 * Fetch accumilated results over a timeperiod
	 * grouped by artist.
	 *
	 * @param {int} $from
	 * @param {int} $to
	 * @param {int} $limit
	 * @return array
	 */
	public function fetchRange( $from, $to = null ){
		$statement = $this->_datasource->prepare(
			"SELECT t.`artist`, NULL AS `name`, NULL AS `type`, t.`year`, SUM(score) AS `score` 
			FROM Tsort t WHERE `year` BETWEEN :from AND :to GROUP BY `artist`
			ORDER BY `score` DESC"
		);
		$statement->execute(array(
			'from' => (int)$from,
			'to' => ($to)
				? (int)$to
				: (int)$from
		));
		return $statement->fetchAll();
	}

	public function find($name){
		$statement = $this->_datasource->prepare(
			"SELECT DISTINCT t.artist FROM Tsort t 
			WHERE t.artist LIKE :name");
		$statement->execute(array(
			'name' => "%{$name}%"
		));
		return $statement->fetchAll();
	}

	/**
	 * Get 
	 */
	public function fetchProfile( $name, $type = "both" ){
		$statement = null;
		if( $type == "albums" ){ 
			$statement = $this->_datasource->prepare(
				"SELECT t.artist, NULL AS `name`, t.`type`, t.year, SUM(score) AS score 
				FROM Tsort t WHERE artist = :name AND t.type = :type GROUP BY artist, `year`
				ORDER BY `year` ASC"
			);
			$statement->execute(array(
				'name' => $name,
				'type' => "album"
			));
		}else if( $type == "songs" ){
			$statement = $this->_datasource->prepare(
				"SELECT t.artist, NULL AS `name`, t.`type`, t.year, SUM(score) AS score 
				FROM Tsort t WHERE artist = :name AND t.type = :type GROUP BY artist, `year`
				ORDER BY `year` ASC"
			);
			$statement->execute(array(
				'name' => $name,
				'type' => "song"
			));
		}else{
			$statement = $this->_datasource->prepare(
				"SELECT t.artist, NULL AS `name`, NULL AS `type`, t.year, SUM(score) AS score 
				FROM Tsort t WHERE artist = :name GROUP BY artist, `year`
				ORDER BY `year` ASC"
			);
			$statement->execute(array(
				'name' => $name
			));			
		}


		return $statement->fetchAll();
	}

	public function fetchProfileByYear( $name, $year, $type = "both" ){
		$statement = null;
		if( $type=="albums" ){
			$statement = $this->_datasource->prepare(
				"SELECT t.name, t.type, t.score, t.notes FROM Tsort t 
				WHERE t.artist = :artist AND t.year = :year AND t.type = :type
				ORDER BY t.name"
			);
			$statement->execute(array(
				'artist' => $name,
				'year' => $year,
				'type' => "album"
			));

		}else if( $type=="songs" ){
			$statement = $this->_datasource->prepare(
				"SELECT t.name, t.type, t.score, t.notes FROM Tsort t 
				WHERE t.artist = :artist AND t.year = :year AND t.type = :type
				ORDER BY t.name"
			);
			$statement->execute(array(
				'artist' => $name,
				'year' => $year,
				'type' => "song"
			));
		}else{
			$statement = $this->_datasource->prepare(
				"SELECT t.name, t.type, t.score, t.notes FROM Tsort t 
				WHERE t.artist = :artist AND t.year = :year"
			);
			$statement->execute(array(
				'artist' => $name,
				'year' => $year
			));
		}
		return $statement->fetchAll();
	}

	/**
	 * Fetch a list of all years in the database
	 * 
	 * @return array
	 */
	public function fetchYears(){
		$statement = $this->_datasource->prepare(
			"SELECT t.`year` FROM Tsort t GROUP BY `year` ORDER BY `year`"
		);
		$statement->execute();
		return $statement->fetchAll();		
	}




}