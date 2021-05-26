<?php

namespace GlueWork\glCache;

/**
 *
 * @author Machacek Milan <machcek76@gmil.com>
 * @version 0.7.1
 * @date 2016-09-21
 */

use Nette\DI;
use Nette\Caching\Cache;
use Nette\Caching\Storages\FileStorage;

class glCacheExtension extends DI\CompilerExtension {
	
	
	private FileStorage $storage;
	private Cache $cache;
	private string $tempDir;

	public bool $nocache = false;
	public string $time = "30 minutes";
	
	
	/**
	 * 
	 * @param mixed[] $config
	 */
	public function initCache($config){
		$this->tempDir = $config['tempDir'];
		if (!file_exists($this->tempDir)) {
			mkdir($this->tempDir, 0777, true);
		}
		$this->time = $config['time'];
		$this->storage = new FileStorage($this->tempDir);
		$this->cache = new Cache($this->storage, $config['name']);
	}
	
	/**
	 * 
	 * @param string $key
	 * @param mixed|mixed[] $data
	 */
	public function saveCache($key, $data) {
		$this->cache->save($key, $data, array(
		    Cache::EXPIRE => $this->time,
		));
	}

	/**
	 * 
	 * @param string $key
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
