<?php

/**
 * cObj cache
 *
 * @author Fabrizio Branca
 * @since 2012-02-19
 */
class tx_cobjcache implements tslib_content_stdWrapHook {

	/**
	 * @var bool
	 */
	protected $useCachingFramework;

	/**
	 * @var t3lib_cache_frontend_VariableFrontend Frontend cache object to table cache_hash.
	 */
	protected $cacheFrontend;

	/**
	 * Creates this object.
	 */
	public function __construct() {
		$this->useCachingFramework = (defined('TYPO3_UseCachingFramework') && TYPO3_UseCachingFramework);
	}

	/**
	 * Gets the pages cache object (if caching framework is enabled).
	 *
	 * @return t3lib_cache_frontend_VariableFrontend
	 */
	protected function getCacheFrontend() {
		if (!$this->useCachingFramework) {
			throw new RuntimeException('Caching framework is not enabled.');
		}

		if (!isset($this->cacheFrontend)) {
			$this->cacheFrontend = $GLOBALS['typo3CacheManager']->getCache('cache_hash');
		}

		return $this->cacheFrontend;
	}

	/**
	 * Hook for modifying $content before core's stdWrap does anything
	 *
	 * @param	string		input value undergoing processing in this function. Possibly substituted by other values fetched from another source.
	 * @param	array		TypoScript stdWrap properties
	 * @param	tslib_cObj	parent content object
	 * @return	string		further processed $content
	 */
	public function stdWrapPreProcess($content, array $configuration, tslib_cObj &$parentObject) {
		if ($this->useCachingFramework && !empty($configuration['cache.'])) {
			$key = $parentObject->stdWrap($configuration['cache.']['key'], $configuration['cache.']['key.']);
			if ($this->getCacheFrontend()->has($key)) {
				$content = $this->getCacheFrontend()->get($key);
				$parentObject->stopRendering[$parentObject->stdWrapRecursionLevel] = TRUE;
			}
		}
		return $content;
	}

	/**
	 * Hook for modifying $content after core's stdWrap has processed setContentToCurrent, setCurrent, lang, data, field, current, cObject, numRows, filelist and/or preUserFunc
	 *
	 * @param	string		input value undergoing processing in this function. Possibly substituted by other values fetched from another source.
	 * @param	array		TypoScript stdWrap properties
	 * @param	tslib_cObj	parent content object
	 * @return	string		further processed $content
	 */
	public function stdWrapOverride($content, array $configuration, tslib_cObj &$parentObject) {
		return $content;
	}

	/**
	 * Hook for modifying $content after core's stdWrap has processed override, preIfEmptyListNum, ifEmpty, ifBlank, listNum, trim and/or more (nested) stdWraps
	 *
	 * @param	string		input value undergoing processing in this function. Possibly substituted by other values fetched from another source.
	 * @param	array		TypoScript "stdWrap properties".
	 * @param	tslib_cObj	parent content object
	 * @return	string		further processed $content
	 */
	public function stdWrapProcess($content, array $configuration, tslib_cObj &$parentObject) {
		return $content;
	}

	/**
	 * Hook for modifying $content after core's stdWrap has processed anything but debug
	 *
	 * @param	string		input value undergoing processing in this function. Possibly substituted by other values fetched from another source.
	 * @param	array		TypoScript stdWrap properties
	 * @param	tslib_cObj	parent content object
	 * @return	string		further processed $content
	 */
	public function stdWrapPostProcess($content, array $configuration, tslib_cObj &$parentObject) {
		if ($this->useCachingFramework && !empty($configuration['cache.'])) {

			// TODO: currently this is evaluated twice (@see stdWrapPreProcess) in case of a cache miss
			$key = $parentObject->stdWrap($configuration['cache.']['key'], $configuration['cache.']['key.']);

			// lifetime: NULL is default lifetime, 0 is unlimited lifetime, <int> is time in seconds
			$lifetime = NULL;
			if (!empty($configuration['cache.']['lifetime']) || !empty($configuration['cache.']['lifetime.'])) {
				$lifetime = $parentObject->stdWrap($configuration['cache.']['lifetime'], $configuration['cache.']['lifetime.']);
				$lifetime = ($lifetime == -1) ? NULL : $lifetime;
			}

			// cache tags
			$tags = $parentObject->stdWrap($configuration['cache.']['tags'], $configuration['cache.']['tags.']);
			$tags = !empty($tags) ? t3lib_div::trimExplode(',', $tags) : array();

			if (!empty($key)) {
				$this->getCacheFrontend()->set($key, $content, $tags, $lifetime);
			}
		}
		return $content;
	}


}