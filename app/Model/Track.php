<?php
App::uses('AppModel', 'Model');

/**
 * Track Model
 */
class Track extends AppModel {

	/**
	 * Add track
	 *
	 * @param array $data
	 * @return mixed
	 */
	public function add($data) {
		$this->create();
			return $this->save($data);
	}

	/**
	 * Update track
	 *
	 * @param array $data
	 * @param int $id
	 * @return mixed
	 */
	public function update($data, $id) {
		$this->id = $id;
		return $this->save($data);
	}

	/**
	 * Retrieve track
	 *
	 * @param int $id
	 * @return array
	 */
	public function findByIdWFields($id, $fields) {
    	if (is_null($fields)) {
    		return $this->find('first', array(
				'conditions' => array(
					'Track.id' => $id,
				)
			));
    	} else {
    		return $this->find('first', array(
				'fields' => $fields,
				'conditions' => array(
					'Track.id' => $id,
				)
			));
    	}
	}

	/**
	 * Retrieve all track
	 *
	 * @param int $id
	 * @return array
	 */
	public function all() {
    	return $this->find('all', array(
			'recursive' => -1
		));
	}

	/**
	 * Retrieve latest track
	 *
	 * @return array
	 */
	public function latest() {
    	return $this->find('all', array(
			'conditions' => array(
				'Track.created >=' => date('Y-m-d H:i:s', strtotime('-35 second')),
			)
		));
	}

	/**
	 * Check if exist in the last 3 mins
	 *
	 * @param string $action
	 * @param string $userip
	 * @return array
	 */
	public function isExist($action, $userip) {
    	return $this->find('count', array(
			'conditions' => array(
				'Track.action >=' => $action,
				'Track.userip >=' => $userip,
				'Track.created >=' => date('Y-m-d H:i:s', strtotime('-35 second')),
			)
		));
	}

}
