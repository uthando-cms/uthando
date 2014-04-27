<?php

namespace Application;

use Zend\Json\Json;

class Version
{
	const VERSION = '2.0.0dev';
	
	protected static $latestVersion;
	
	public static function compareVersion($version)
	{
		$version = strtolower($version);
		$version = preg_replace('/(\d)pr(\d?)/', '$1a$2', $version);
		return version_compare($version, strtolower(self::VERSION));
	}
	
	public static function getLatest()
	{
		if (null === static::$latestVersion) {
			static::$latestVersion = 'not available';
			
			$url  = 'https://api.github.com/repos/charisma-beads/charisma-beads/git/refs/tags/release-';

			$apiResponse = Json::decode(file_get_contents($url), Json::TYPE_ARRAY);

			// Simplify the API response into a simple array of version numbers
			$tags = array_map(function ($tag) {
				return substr($tag['ref'], 18); // Reliable because we're filtering on 'refs/tags/release-'
			}, $apiResponse);

			// Fetch the latest version number from the array
			static::$latestVersion = array_reduce($tags, function ($a, $b) {
				return version_compare($a, $b, '>') ? $a : $b;
			});
			
		}
	
		return static::$latestVersion;
	}
	
	public static function isLatest()
	{
		return static::compareVersion(static::getLatest()) < 1;
	}
}
