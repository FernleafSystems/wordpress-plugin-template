<?php

namespace Fernleaf\Wordpress\Plugin\Utility;

use Fernleaf\Wordpress\Plugin\Config\SpecConsumer;
use Fernleaf\Wordpress\Plugin\Config\Specification;
use Fernleaf\Wordpress\Plugin\Root\Paths as RootPaths;

class Paths extends SpecConsumer {

	/**
	 * @var RootPaths
	 */
	private $oRootPaths;

	/**
	 * Paths constructor.
	 *
	 * @param RootPaths $oRootPaths
	 * @param Specification $oSpec
	 */
	public function __construct( $oRootPaths, $oSpec ) {
		parent::__construct( $oSpec );
		$this->oRootPaths = $oRootPaths;
	}

	/**
	 * @param string $sRelativePath
	 * @return string
	 */
	public function getAbsolutePath( $sRelativePath ) {
		$sRootDir = $this->oRootPaths->getRootDir();
		if ( strpos( $sRelativePath, $sRootDir ) === false ) {
			$sFullPath = path_join( $sRootDir, $sRelativePath );
		}
		else {
			$sFullPath = $sRelativePath;
		}
		return $sFullPath;
	}

	/**
	 * @param string $sBase
	 * @param string $sPath
	 * @return string
	 */
	public function getPluginPath( $sBase, $sPath = '' ) {
		return path_join( $this->getSpec()->getPath( $sBase ), $sPath );
	}

	/**
	 * @param string $sAsset
	 * @param bool   $bAbsolutePath
	 * @return string
	 */
	public function getPath_Assets( $sAsset = '', $bAbsolutePath = true ) {
		$sPath = $this->getPluginPath( 'assets', $sAsset );
		return $bAbsolutePath ? $this->getAbsolutePath( $sPath ) : $sPath;
	}

	/**
	 * @param string $sAsset
	 * @return string
	 */
	public function getPath_AssetCss( $sAsset = '' ) {
		return $this->getPath_Assets( 'css'.DIRECTORY_SEPARATOR.$sAsset );
	}

	/**
	 * @param string $sAsset
	 * @return string
	 */
	public function getPath_AssetJs( $sAsset = '' ) {
		return $this->getPath_Assets( 'js'.DIRECTORY_SEPARATOR.$sAsset );
	}

	/**
	 * @param string $sAsset
	 * @return string
	 */
	public function getPath_AssetImage( $sAsset = '' ) {
		return $this->getPath_Assets( 'images'.DIRECTORY_SEPARATOR.$sAsset );
	}

	/**
	 * @param string $sFlag
	 * @return string
	 */
	public function getPath_Flags( $sFlag = '' ) {
		return $this->getAbsolutePath( $this->getPluginPath( 'flags', $sFlag ) );
	}

	/**
	 * @return string
	 */
	public function getPath_Languages() {
		return $this->getAbsolutePath( $this->getPluginPath( 'languages' ) );
	}

	/**
	 * @param string $sRootFile
	 * @return string
	 */
	public function getPath_Root( $sRootFile = '' ) {
		return $this->getAbsolutePath( $sRootFile );
	}

	/**
	 * @param string $sFile
	 * @return string
	 */
	public function getPath_Source( $sFile ) {
		return $this->getAbsolutePath( $this->getPluginPath( 'source', $sFile ) );
	}

	/**
	 * @param string $sFile
	 * @return string
	 */
	public function getPath_Temp( $sFile = '' ) {
		return $this->getAbsolutePath( $this->getPluginPath( 'temp', $sFile ) );
	}

	/**
	 * @return string
	 */
	public function getPath_Templates() {
		return $this->getAbsolutePath( $this->getPluginPath( 'templates' ) );
	}

	/**
	 * @param string $sAsset
	 * @return string
	 */
	public function getPluginUrl_Asset( $sAsset ) {
		return $this->oRootPaths->getPluginUrl( $this->getPath_Assets( $sAsset, false ) );
	}

	/**
	 * @param string $sAsset
	 * @return string
	 */
	public function getPluginUrl_Css( $sAsset ) {
		return $this->getPluginUrl_Asset( 'css/'.$sAsset );
	}

	/**
	 * @param string $sAsset
	 * @return string
	 */
	public function getPluginUrl_Image( $sAsset ) {
		return $this->getPluginUrl_Asset( 'images/'.$sAsset );
	}

	/**
	 * @param string $sAsset
	 * @return string
	 */
	public function getPluginUrl_Js( $sAsset ) {
		return $this->getPluginUrl_Asset( 'js/'.$sAsset );
	}
}