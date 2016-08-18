<?php

namespace Fernleaf\Wordpress\Plugin\Display;

use Fernleaf\Wordpress\Plugin\Configuration\Consumer;
use Fernleaf\Wordpress\Plugin\Configuration\Controller;
use Fernleaf\Wordpress\Plugin\Root\File as RootFile;

class RowMeta extends Consumer {

	/**
	 * @var RootFile
	 */
	private $oRootFile;

	/**
	 * @param Controller $oConfig
	 * @param RootFile   $oRoot
	 */
	public function __construct( $oConfig, $oRoot ) {
		parent::__construct( $oConfig );
		$this->oRootFile = $oRoot;
		add_filter( 'plugin_row_meta', array( $this, 'onPluginRowMeta' ), 50, 2 );
	}

	/**
	 * @param array $aPluginMeta
	 * @param string $sPluginFile
	 * @return array
	 */
	public function onPluginRowMeta( $aPluginMeta, $sPluginFile ) {

		if ( $sPluginFile == $this->oRootFile->getPluginBaseFile() ) {
			$aMeta = $this->getConfig()->getPluginMeta();

			$sLinkTemplate = '<strong><a href="%s" target="%s">%s</a></strong>';
			foreach( $aMeta as $aMetaLink ){
				$sSettingsLink = sprintf( $sLinkTemplate, $aMetaLink['href'], "_blank", $aMetaLink['name'] ); ;
				array_push( $aPluginMeta, $sSettingsLink );
			}
		}
		return $aPluginMeta;
	}
}