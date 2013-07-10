<?php
/**
 * Shark Framework
 *
 * @author wuqj <sunsky303@gmail.com>
 * @copyright Copyright 2012-2013
 * @link https://mini-php-framework.googlecode.com/
 * @version $Id$
 */
namespace SF\Db\Connection;
/**
 * @author wuqj
 */
Interface DbInterface{
	public function connect();
	public function disconnect();
	
	public function insert($data);
	public function delete($data, $where);
	public function update($data, $where);
	public function select($where);
	
}