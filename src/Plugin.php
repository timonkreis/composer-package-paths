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
class Plugin implements Composer\Plugin\PluginInterface
{
	/**
	 * Add the installer
	 *
	 * @param Composer\Composer $composer
	 * @param Composer\IO\IOInterface $io
	 */
	public function activate(Composer\Composer $composer, Composer\IO\IOInterface $io) : void
	{
		$installer = new Installer($io, $composer);

		$composer->getInstallationManager()->addInstaller($installer);
	}
}
