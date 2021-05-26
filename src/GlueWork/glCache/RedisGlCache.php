<?php declare(strict_types=1);

/**
 * Caching data to redis
 */

namespace GlueWork\glCache;

class RedisGlCache
{
	
	/** @var \Redis  */
	public $redis;
	
	private string $prefix;
	
	private int $ttl;
	
	
	/**
	 * RedisCache constructor.
	 *
	 * @param string $prefix
	 * @param int $ttl
	 */
	public function __construct(string $prefix, int $ttl = 120)
	{
		$this->redis = new \Redis();
		$this->redis->connect('127.0.0.1');
		$this->ttl    = $ttl;
		$this->prefix = $prefix;
	}
	
	/**
	 * @param string $key
	 * @param mixed $data
	 */
	public function set(string $key, $data): void
	{
		$key = $this->getKey($key);
		$this->redis->setEx($key, $this->ttl, serialize($data));
	}
	
	/**
	 * @param string $key
	 * @return false|mixed
	 */
	public function get(string $key)
	{
		$key = $this->getKey($key);
		$data = $this->redis->get($key);
		
		return is_string($data) ? unserialize($data) : false;
	}
	
	/**
	 * @param string $key
	 * @return int
	 */
	public function unlink(string $key)
	{
		$key = $this->getKey($key);
		
		return $this->redis->unlink($key);
	}
	
	/**
	 * @param string $key
	 * @return string
	 */
	private function getKey(string $key)
	{
		return $this->prefix . ":" . $key;
	}
}
