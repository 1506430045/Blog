<?php
class MemcachedTool {
	
	protected $mc;
	protected $host;
	protected $port;
	protected $weight;
	private static $_instance;
	protected $errorMsg;

	private function __construct($host, $port, $weight) {
		$this->mc = new Memcached();
		$this->host = $host;
		$this->port = $port;
		$this->weight = $weight;
		$this->mc->addServer($this->host, $this->port, $weight);
	}

	public static function getInstance($host, $port, $weight) {
		if(!self::$_instance instanceof self) {
			self::$_instance = new self($host, $port, $weight);
		}
		return self::$_instance;
	}

	private function __clone() {
	
	}

	//向一个新的key下增加元素
	public function add($key, $value, $time) {
		$result = $this->mc->add($key, $value, $time);
		if($result) {
			return true;
		}else {
			if($this->mc->getResultCode() == Memcached::RES_NOTSTORED) {
				$this->errorMsg = 'key['.$key.']已经存在，不可重复定义。';
			}
			return false;
		}
	}

	//存储一个值
	public function set($key, $value, $time) {
		$result = $this->mc->set($key, $value, $time);
		if($result) {
			return true;
		}else {
			$this->errorMsg =  $this->mc->getResultCode();
			return false;
		}
	}

	//替换一个值
	public function replace($key, $value, $time) {
		$result = $this->mc->replace($key, $value, $time);
		if($result) {
			return true;
		}else {
			$this->errorMsg =  $this->mc->getResultCode();
			return false;
		}
	}

	//追加值
	public function append($key, $value) {
		$this->mc->setOption(Memcached::OPT_COMPRESSION, false);
		$result = $this->mc->append($key, $value);
		if($result) {
			return true;
		}else {
			$this->errorMsg =  $this->mc->getResultCode();
			return false;
		}
	}

	//前面追加值
	public function prepend($key, $value) {	
		$this->mc->setOption(Memcached::OPT_COMPRESSION, false);
		$result = $this->mc->prepend($key, $value);
		if($result) {
			return true;
		}else {
			$this->errorMsg =  $this->mc->getResultCode();
			return false;
		}
	}

	//减小数值的值
	public function decrement($key, $offset=1) {
		$result = $this->mc->decrement($key, $offset);
		if($result) {
			return true;
		}else {
			$this->errorMsg =  $this->mc->getResultCode();
			return false;
		}
	}

	//增加数值的值
	public function increment($key, $offset=1) {
		$result = $this->mc->increment($key, $offset);
		if($result) {
			return true;
		}else {
			$this->errorMsg =  $this->mc->getResultCode();
			return false;
		}
	}

	//删除值
	public function delete($key, $time) {
		$result = $this->mc->delete($key, $time);
		if($result) {
			return true;
		}else {
			$this->errorMsg =  $this->mc->getResultCode();
			return false;
		}
	}

	//获取值
	public function get($key) {
		$result = $this->mc->get($key);
		if($result) {
			return $result;
		}else {
			$this->errorMsg =  $this->mc->getResultCode();
			return false;
		}
	}

	//清空缓存
	public function flush($time) {
		$this->mc->flush($time);
	}

	//获取多个值
	public function getDelayed($keys, $with_cas=true) {
		$this->mc->getDelayed($keys, $with_cas);
		return $this->mc->fetchAll();
	}

	//设置多个值
	public function setMulti($keys, $time) {
		$result = $this->mc->setMulti($keys, $time);
		return $result;
	}
	//获取多个值
	public function getMulti($keys) {
		return $this->mc->getMulti($keys);
	}
	//获取Memcached的选项值
	public function getOption($name) {
		return $this->mc->getOption($name);
	}

	//关闭连接
	public function quit() {
		$this->mc->quit();
	}
}
?>
