<?php
/**
 * Shark Framework
 *
 * @author wuqj <sunsky303@gmail.com>
 * @category SF
 * @package SF\Db
 * @copyright Copyright 2012-2013
 * @link https://mini-php-framework.googlecode.com/
 * @version $Id$
 */

namespace SF\Db\Connection;


/**
 * DB 
 * 
 * @author wuqj
 *
 */
abstract class AbstractDb {
	/**
	 * db name
	 * @var string
	 */
	protected $_dbName;
	/**
	 * data
	 * 
	 * @var mix
	 */
	protected $_data;
	protected static $_connection;
	
	abstract public function connect();
	abstract public function disconnect();
	
	/**
	 * create a model
	 *
	 * @return Model instance
	 */
	public static function factory(array $params = array()){
		return call_user_func(array($this, '__construct'), $params);
	}	
	
	
	abstract public function insert(array $data);
	/**
	 * delete 
	 * @param mix $data array | string 
	 * @param mix $where 
	 */
	abstract public function delete($data, $where = '');
	/**
	 * update 
	 * @param mix $data array | string 
	 * @param mix $where 
	 */
	abstract public function update($data, $where = '');
	/**
	 * update
	 * @param mix $where 
	 */	
	abstract public function select($where);
	
	

	
}