<?php
/**
 * Shark Framework
 *
 * @author wuqj <sunsky303@gmail.com>
 * @category System
 * @package System\Db
 * @copyright Copyright 2012-2013
 * @link https://mini-php-framework.googlecode.com/
 * @version $Id$
 */

namespace System\Db;


/**
 * DB 
 * 
 * @author wuqj
 *
 */
abstract class Db {
	/**
	 * table name
	 * @var unknown
	 */
	protected $_tableName;
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
	 * @param mix $where array | string 
	 */
	abstract public function delete($data, $where = '');
	/**
	 * update 
	 * @param mix $data array | string 
	 * @param mix $where array | string 
	 */
	abstract public function update($data, $where = '');
	/**
	 * update
	 * @param mix $where array | string 
	 */	
	abstract public function select($where);

	
}