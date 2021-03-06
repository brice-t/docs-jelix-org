<?php
/* comments & extra-whitespaces have been removed by jBuildTools*/
/**
* @package    jelix
* @subpackage db_driver
* @author     Gérald Croes, Laurent Jouanneau
* @contributor Laurent Jouanneau
* @contributor Sylvain de Vathaire, Julien Issler
* @contributor Florian Lonqueu-Brochard
* @copyright  2001-2005 CopixTeam, 2005-2012 Laurent Jouanneau
* @copyright  2009 Julien Issler
* @copyright  2012 Florian Lonqueu-Brochard
* @link      http://www.jelix.org
* @licence  http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public Licence, see LICENCE file
*/
require_once(dirname(__FILE__).'/mysqli.dbresultset.php');
require_once(dirname(__FILE__).'/mysqli.dbstatement.php');
class mysqliDbConnection extends jDbConnection{
	protected $_charsets=array('UTF-8'=>'utf8','ISO-8859-1'=>'latin1');
	private $_usesMysqlnd=true;
	function __construct($profile){
		if(!function_exists('mysqli_connect')){
			throw new jException('jelix~db.error.nofunction','mysql');
		}
		parent::__construct($profile);
	}
	public function encloseName($fieldName){
		return '`'.$fieldName.'`';
	}
	public function beginTransaction(){
		$this->_autoCommitNotify(false);
	}
	public function commit(){
		$this->_connection->commit();
		$this->_autoCommitNotify(true);
	}
	public function rollback(){
		$this->_connection->rollback();
		$this->_autoCommitNotify(true);
	}
	public function prepare($query){
		$res=$this->_connection->prepare($query);
		if($res){
			$rs=new mysqliDbStatement($res,$this->_usesMysqlnd);
		}else{
			throw new jException('jelix~db.error.query.bad',$this->_connection->error.'('.$query.')');
		}
		return $rs;
	}
	public function errorInfo(){
		return array('HY000',$this->_connection->errno,$this->_connection->error);
	}
	public function errorCode(){
		return $this->_connection->errno;
	}
	protected function _connect(){
		$host=($this->profile['persistent'])? 'p:'.$this->profile['host'] : $this->profile['host'];
		$cnx=@new mysqli($host,$this->profile['user'],$this->profile['password'],$this->profile['database']);
		if($cnx->connect_errno){
			throw new jException('jelix~db.error.connection',$this->profile['host']);
		}
		else{
			if(isset($this->profile['force_encoding'])&&$this->profile['force_encoding']==true
			&&isset($this->_charsets[jApp::config()->charset])){
				$cnx->set_charset($this->_charsets[jApp::config()->charset]);
			}
			if(is_callable(array($cnx,'get_result'))){
				$this->_usesMysqlnd=true;
			}else{
				$this->_usesMysqlnd=false;
			}
			return $cnx;
		}
	}
	protected function _disconnect(){
		return $this->_connection->close();
	}
	protected function _doQuery($query){
		if($qI=$this->_connection->query($query)){
			return new mysqliDbResultSet($qI);
		}else{
			throw new jException('jelix~db.error.query.bad',$this->_connection->error.'('.$query.')');
		}
	}
	protected function _doExec($query){
		if($qI=$this->_connection->query($query)){
			return $this->_connection->affected_rows;
		}else{
			throw new jException('jelix~db.error.query.bad',$this->_connection->error.'('.$query.')');
		}
	}
	protected function _doLimitQuery($queryString,$offset,$number){
		$queryString.=' LIMIT '.$offset.','.$number;
		$this->lastQuery=$queryString;
		$result=$this->_doQuery($queryString);
		return $result;
	}
	public function lastInsertId($fromSequence=''){
		return $this->_connection->insert_id;
	}
	protected function _autoCommitNotify($state){
		$this->_connection->autocommit($state);
	}
	protected function _quote($text,$binary){
		return $this->_connection->real_escape_string($text);
	}
	public function getAttribute($id){
		switch($id){
			case self::ATTR_CLIENT_VERSION:
				return $this->_connection->get_client_info();
			case self::ATTR_SERVER_VERSION:
				return $this->_connection->server_info;
				break;
			case self::ATTR_SERVER_INFO:
				return $this->_connection->host_info;
		}
		return "";
	}
	public function setAttribute($id,$value){
	}
	public function execMulti($queries){
		$query_res=$this->_connection->multi_query($queries);
		while($this->_connection->more_results()){
			$this->_connection->next_result();
			if($discard=$this->_connection->store_result()){
				$discard->free();
			}
		}
		return $query_res;
	}
}
