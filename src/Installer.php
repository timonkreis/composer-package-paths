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

		return strtr(
			$this->getPackagePaths()[$package->getType()],
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
		return array_key_exists($packageType, $this->getPackagePaths());
	}

	/**
	 * Get the list of configured paths from `composer.json`
	 *
	 * @return array
	 */
	protected function getPackagePaths() : array
	{
		return $this->composer->getPackage()->getExtra()['package-paths'] ?? [];
	}
}
