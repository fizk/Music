<?php

namespace Music\Service;

use PDO;
use Music\Model\Music as MusicModel;

class Music{

	/**
	 * @var Music\Model\Music
	 */
	private $_model;

	/**
	 *
	 */
	public function __construct(PDO $pdo){
		$this->_model = new MusicModel($pdo);
	}

	/**
	 *  Fetch accumilated scores grouped by artist.	
	 */
	public function fetch( $from, $to = null ){
		$data = $this->_model->fetchRange($from, $to);
		foreach ($data as $item) {
			$item->score = (double)$item->score;
			$item->year = (int)$item->year;
		}
		return $data;
	}

	/**
	 *  Get profil eof one artist
	 */
	public function get( $name, $type = "both" ){
		$data = $this->_model->fetchProfile($name, $type);
		foreach ($data as $item) {
			$item->score = (double)$item->score;
			$item->year = (int)$item->year;
			$item->collection = $this->_model->fetchProfileByYear($name,$item->year, $type);
			foreach ($item->collection as $col) {
				$col->score = (double)$col->score;
			}			
		}
		return $data;
	}

	public function find( $name ){
		return $this->_model->find($name);
	}

	/**
	 *
	 */
	public function years(){
		return $this->_model->fetchYears();
	}
}