<?php


namespace GlueWork\glCache;


/**
 *
 * @author Machacek Milan <machcek76@gmil.com>
 * @version 0.7
 * @date 2016-09-21
 */

use Nette;
use Nette\DI;
use Nette\Caching\Cache;

class glCacheExtension extends DI\CompilerExtension {
	
	
	private $storage	= NULL;
	private $cache		= NULL;
	private $tempDir;

	public $nocache		= false;
	public $time		= "30 minutes";

	
	
	
	
	/**
	 * 
	 * @param type $config
	 */
	public function initCache($config){
		$this->tempDir = $config['tempDir'];
		if (!file_exists($this->tempDir)) {
			mkdir($tempDir, 0777, true);
		}
		$this->time = $config['time'];
		$this->storage = new \Nette\Caching\Storages\FileStorage($this->tempDir);
		$this->cache = new \Nette\Caching\Cache($this->storage, $config['name']);
	}


	
	/**
	 * 
	 * @param type $key
	 * @param type $data
	 */
	public function saveCache($key, $data) {
		$this->cache->save($key, $data, array(
		    Cache::EXPIRE => $this->time,
		));
	}

	/**
	 * 
	 * @param type $key
	 * @return NULL or DATA
	 */
	public function loadCache($key) {
		if ($this->nocache) {
			$this->cache->remove($key);
			return NULL;
		}
		return $this->cache->load($key);
	}
	
}
