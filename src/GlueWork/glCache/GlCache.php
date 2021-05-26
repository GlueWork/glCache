<?php declare(strict_types=1);

/**
 * Static class for caching
 */

namespace GlueWork\glCache;

class Cache
{
	
	/** @var FilesGlCache|RedisGlCache */
	public $service = null;
	public int $ttl = 120;
	public string $prefix;
	
	/**
	 * @param string $type
	 * @param string $prefix
	 * @param int $ttl
	 */
	public function setService(string $type, string $prefix, int $ttl, string $tmpPath = '/tmp'): void
	{
		
		$this->ttl = $ttl;
		
		$this->prefix = $prefix;
		
		if ($type === 'redis') {
			$this->service = new RedisGlCache($this->prefix, $this->ttl);
		} else {
			$this->service = new FilesGlCache($this->prefix, $this->ttl, $tmpPath);
		}
	}
	
	/**
	 * @param string $key
	 * @param mixed $data
	 * @return mixed
	 */
	public function set(string $key, $data)
	{
		$this->service->set($key, $data);
	}
	
	/**
	 * @param string $key
	 * @return mixed
	 */
	public function get(string $key)
	{
		return $this->service->get($key);
	}
	
	/**
	 * @param string $key
	 */
	public function unlink(string $key): void
	{
		$this->service->unlink($key);
	}
}
