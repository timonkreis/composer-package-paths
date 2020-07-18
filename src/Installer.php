<?php
/**
 * Copyright by Timon Kreis - All Rights Reserved
 * Visit https://www.timonkreis.de/
 */
declare(strict_types = 1);

namespace TimonKreis\Composer\PackagePaths;

use Composer;

/**
 * @package TimonKreis\Composer\PackagePaths
 */
class Installer extends Composer\Installers\Installer
{
	/**
	 * Get install path for package
	 *
	 * @param Composer\Package\PackageInterface $package
	 * @return string
	 */
	public function getInstallPath(Composer\Package\PackageInterface $package) : string
	{
		[$vendor, $name] = explode('/', $package->getName(), 2);

		if ($this->getPackagePaths()[$package->getName()] ?? false) {
			// Package is targeted directly
			$path = $this->getPackagePaths()[$package->getName()];
		} elseif ($this->getPackagePaths()[$vendor . '/*'] ?? false) {
			// Package is targeted by vendor + wildcard
			$path = $this->getPackagePaths()[$vendor . '/*'];
		} elseif ($this->getPackagePaths()[$package->getType()] ?? false) {
			// Package is targeted by package type
			$path = $this->getPackagePaths()[$package->getType()];
		} else {
			// Package is not targeted (choose default vendor directory)
			$path = $this->composer->getConfig()->get('vendor-dir') . '/{$vendor}/{$name}';
		}

		return strtr(
			$path,
			[
				'{$vendor}' => $vendor,
				'{$name}' => $name,
			]
		);
	}

	/**
	 * Check if the given package type is supported
	 *
	 * @param string $packageType
	 * @return bool
	 */
	public function supports($packageType) : bool
	{
		// Check if any package is potentially targeted directly
		foreach ($this->getPackagePaths() as $package => $path) {
			if (strpos($package, '/')) {
				return true;
			}
		}

		return array_key_exists($packageType, $this->getPackagePaths());
	}

	/**
	 * Get the list of configured paths from `composer.json`
	 *   Definition:
	 *   {
	 *       ...
	 * 	     "extra": {
	 *           "package-paths": {
	 *               "my-first-package-type": "my/custom/path",
	 *               "my-second-package-type": "another/custom/path/{$vendor}/{$name}",
	 *               "my-vendor/*": "my/wildcard/path"
	 *           }
	 *       }
	 *       ...
	 *   }
	 *
	 * @return array
	 */
	protected function getPackagePaths() : array
	{
		return $this->composer->getPackage()->getExtra()['package-paths'] ?? [];
	}
}
