<?php


namespace GlueWork\glCache;


/**
 *
 * @author Machacek Milan <machcek76@gmil.com>
 * @version 0.7
 * @date 2016-09-21
 */

use Nette\Caching\Cache;



class glCacheExtension {
	
	
	private $storage	= NULL;
	private $cache		= NULL;
	private $tempDir;

	public $nocache		= false;
	public $time		= "30 minutes";
	public $name		= "glCache";

	/**
	 * 
	 * @param type $tempDir
	 * @param type $time = '30 minutes'
	 */
	function __construct($tempDir = '/tmp', $nocache = false) {
		$this->tempDir = $tempDir;
		$this->nocache = $nocache;
		if (!file_exists($tempDir)) {
			mkdir($tempDir, 0777, true);
		}
		$this->storage = new \Nette\Caching\Storages\FileStorage($this->tempDir);
		
		$this->cache = new \Nette\Caching\Cache($this->storage, $this->name);
		
	}

	
	
	
	
	
	
	
	
	
}
