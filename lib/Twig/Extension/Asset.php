<?php

/**
 * Extension for twig template engine
 *
 * Used to automatically set paths to Assets static files for the frontend.
 * Used for long term caching static files for the frontend.
 *
 * @example
 *  {{ webpackAsset('vendor.js') }}
 *
 * @property string  $manifestFilepath  Path to the frontend asset description file.
 * @property string  $pathPrefix        Path prefix add befora.
 *
 * @package livemaster/webpackAssets
 * @author  Ilya Reshetnikov <ireshetnikov@livemaster.ru>
 * @version 1.0, 25.08.2017
 */
class Twig_Extensions_Extension_webpackAsset extends Twig_Extension {

	/** @var string  $manifestFilepath stores the path to the frontend asset description file */
	protected $manifestFilepath;

	/** @var string  $manifestData stores data from frontend asset description file */
	protected $manifestData = null;

	const EXTENSION_NAME = 'webpackAsset';

	/** class constructor define properties for class*/
	public function __construct($manifestFilepath, $pathPrefix) {
		$this->manifestFilepath = $manifestFilepath;
		$this->pathPrefix = $pathPrefix;
	}

	/**
	 * Return extension name
	 *
	 * @author  Ilya Reshetnikov <ireshetnikov@livemaster.ru>
 	 * @version 1.0, 25.08.2017
	 *
	 * @return string
	 */
	public function getName() {
		return sprintf('livemaster/%s', self::EXTENSION_NAME);
	}

	/**
	 * @ignore
	 *
	 * Callback for Twig
	 *
	 * @author  Ilya Reshetnikov <ireshetnikov@livemaster.ru>
	 * @version 1.0, 25.08.2017
	 *
	 * @return array
	 */
	public function getFunctions() {
		return [
			new Twig_SimpleFunction(self::EXTENSION_NAME, [$this, 'getWebpackAsset']),
		];
	}

	/**
	 * Loads and converts into an array a static description file for the frontend.
	 *
	 * @author  Ilya Reshetnikov <ireshetnikov@livemaster.ru>
	 * @version 1.0, 25.08.2017
	 *
	 * @param  string $manifestFilepath - Path to the frontend asset description file
	 *
	 * @return array
	 * @throws Exception - if the file in the specified path does not exist.
	 */
	protected function loadManifest($manifestFilepath) {
		if (!file_exists($manifestFilepath)) {
			throw new Exception("You need set right path to mannifest.json");
		}

		return json_decode(file_get_contents($manifestFilepath), true);
	}

	/**
	 * Reads from the array of asets and returns the path to the aset
	 * or the name passed in the parameter.
	 *
	 * @author  Ilya Reshetnikov <ireshetnikov@livemaster.ru>
	 * @version 1.0, 25.08.2017
	 *
	 * @return string
	 */
	public function getWebpackAsset($assetName) {
		if ($this->manifestData === null) {
			try {
				$this->manifestData = $this->loadManifest($this->manifestFilepath);
			} catch(Exception $error) {
				$errorMessage =  $error->getMessage().' in '.$error->getTraceAsString();
				trigger_error($errorMessage, E_USER_ERROR);
			}
		}

		$keyIsExist = array_key_exists($assetName, $this->manifestData);

		if ($keyIsExist) {
			$assetPath = $this->pathPrefix . $this->manifestData[$assetName];
		} else {
			$assetPath =  $assetName;
		}

		return $assetPath;
	}
}
