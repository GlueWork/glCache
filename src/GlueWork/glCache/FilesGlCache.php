<?php declare(strict_types=1);

/**
 * Caching data to files
 */

namespace GlueWork\glCache;

class FilesGlCache
{
	
	private string $prefix;
	private int $ttl;
	private string $tmp;
	
	
	/**
	 * FileCache constructor.
	 *
	 * @param string $prefix
	 * @param int $ttl
	 */
	public function __construct(string $prefix, int $ttl = 120, string $tmpFolder = '/tmp')
	{
		$this->prefix = $prefix;
		$this->tmp = $tmpFolder;
		$this->ttl = $ttl;
		
		$this->setDir();
	}
	
	/**
	 * @param string $key
	 * @param mixed $data
	 */
	public function set(string $key, $data): void
	{
		$file = $this->getKey($key);
		$data = [
			'saved' => (time() + $this->ttl),
			'data'  => $data,
		];
		
		@file_put_contents($file, serialize($data));
	}
	
	/**
	 * @param string $key
	 * @return mixed|null
	 */
	public function get(string $key)
	{
		$file = $this->getKey($key);
		$data = @file_get_contents($file);
		
		if (is_string($data) === false) {
			return null;
		}
		
		$data = unserialize($data);
		
		if ((int) $data['saved'] > time()) {
			return $data['data'];
		}
		
		$this->unlink($key);
		
		return null;
	}
	
	/**
	 * @param string $key
	 */
	public function unlink(string $key): void
	{
		$file = $this->getKey($key);
		
		if (file_exists($file) === true) {
			@unlink($file);
		}
	}
	
	/**
	 * @param string $key
	 * @return string
	 */
	private function getKey(string $key)
	{
		return $this->tmp . '/' . $this->prefix . '/' . $key;
	}
	
	private function setDir(): void
	{
		$dir = $this->tmp . '/' . $this->prefix;
		
		if (is_dir($dir) === false) {
			mkdir($dir, 755);
		}
	}
}
