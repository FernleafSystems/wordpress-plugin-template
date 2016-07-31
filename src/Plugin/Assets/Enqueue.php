<?php

namespace Fernleaf\Wordpress\Plugin\Assets;

use Fernleaf\Wordpress\Plugin\Config\SpecConsumer;
use Fernleaf\Wordpress\Plugin\Config\Specification;
use Fernleaf\Wordpress\Plugin\Utility\Paths;
use Fernleaf\Wordpress\Plugin\Utility\Prefix;

class Enqueue extends SpecConsumer{

	protected $oPrefix;

	protected $oPluginPaths;

	/**
	 * @param Specification $oSpec
	 * @param Prefix $oPrefix
	 * @param Paths $oPluginPaths
	 */
	public function __construct( $oSpec, $oPrefix, $oPluginPaths ) {
		parent::__construct( $oSpec );
		$this->oPrefix = $oPrefix;
		$this->oPluginPaths = $oPluginPaths;
		$this->run();
	}

	protected function run() {
		add_action( 'wp_enqueue_scripts', 		array( $this, 'onWpEnqueueFrontendCss' ), 99 );
		add_action( 'admin_enqueue_scripts', 	array( $this, 'onWpEnqueueAdminCss' ), 99 );
		add_action( 'admin_enqueue_scripts', 	array( $this, 'onWpEnqueueAdminJs' ), 99 );
	}

	public function onWpEnqueueAdminJs() {
		/* TODO: apply this guard
		if ( $this->getIsPage_PluginAdmin() ) {

		} */

		$oSpec = $this->getSpec();
		$aAdminJs = $oSpec->getInclude( 'plugin_admin' );
		if ( isset( $aAdminJs['js'] ) && !empty( $aAdminJs['js'] ) && is_array( $aAdminJs['js'] ) ) {
			$sDependent = false;
			foreach( $aAdminJs['js'] as $sJsAsset ) {
				$sUrl = $this->oPluginPaths->getPluginUrl_Js( $sJsAsset . '.js' );
				if ( !empty( $sUrl ) ) {
					$sUnique = $this->oPrefix->doPluginPrefix( $sJsAsset );
					wp_register_script( $sUnique, $sUrl, $sDependent, $oSpec->getVersion() );
					wp_enqueue_script( $sUnique );
					$sDependent = $sUnique;
				}
			}
		}
	}

	public function onWpEnqueueAdminCss() {

		$oSpec = $this->getSpec();
		$aAdminCss = $oSpec->getInclude( 'admin' );
		if ( isset( $aAdminCss['css'] ) && !empty( $aAdminCss['css'] ) && is_array( $aAdminCss['css'] ) ) {
			$sDependent = false;
			foreach( $aAdminCss['css'] as $sCssAsset ) {
				$sUrl = $this->oPluginPaths->getPluginUrl_Css( $sCssAsset . '.css' );
				if ( !empty( $sUrl ) ) {
					$sUnique = $this->oPrefix->doPluginPrefix( $sCssAsset );
					wp_register_style( $sUnique, $sUrl, $sDependent, $oSpec->getVersion() );
					wp_enqueue_style( $sUnique );
					$sDependent = $sUnique;
				}
			}
		}

		// TODO: if ( $this->getIsPage_PluginAdmin() ) {
			$aAdminCss = $oSpec->getInclude( 'plugin_admin' );
			if ( isset( $aAdminCss['css'] ) && !empty( $aAdminCss['css'] ) && is_array( $aAdminCss['css'] ) ) {
				$sDependent = false;
				foreach( $aAdminCss['css'] as $sCssAsset ) {
					$sUrl = $this->oPluginPaths->getPluginUrl_Css( $sCssAsset . '.css' );
					if ( !empty( $sUrl ) ) {
						$sUnique = $this->oPrefix->doPluginPrefix( $sCssAsset );
						wp_register_style( $sUnique, $sUrl, $sDependent, $oSpec->getVersion().rand() );
						wp_enqueue_style( $sUnique );
						$sDependent = $sUnique;
					}
				}
			}
//		}
	}

	public function onWpEnqueueFrontendCss() {

		$oSpec = $this->getSpec();
		$aFrontendIncludes = $oSpec->getInclude( 'frontend' );
		if ( isset( $aFrontendIncludes['css'] ) && !empty( $aFrontendIncludes['css'] ) && is_array( $aFrontendIncludes['css'] ) ) {
			foreach( $aFrontendIncludes['css'] as $sCssAsset ) {
				$sUnique = $this->oPrefix->doPluginPrefix( $sCssAsset );
				wp_register_style( $sUnique, $this->oPluginPaths->getPluginUrl_Css( $sCssAsset.'.css' ), ( empty( $sDependent ) ? false : $sDependent ), $oSpec->getVersion() );
				wp_enqueue_style( $sUnique );
				$sDependent = $sUnique;
			}
		}
	}

}