<?php
/**
 * ResourceLoader module based on local JavaScript/CSS files.
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @file
 * @author Trevor Parscal
 * @author Roan Kattouw
 */

/**
 * ResourceLoader module based on local JavaScript/CSS files.
 */
class ResourceLoaderFileModule extends ResourceLoaderModule {

	/** @var string Local base path, see __construct() */
	protected $localBasePath = '';

	/** @var string Remote base path, see __construct() */
	protected $remoteBasePath = '';

	/** @var array Saves a list of the templates named by the modules. */
	protected $templates = [];

	/**
	 * @var array List of paths to JavaScript files to always include
	 * @par Usage:
	 * @code
	 * [ [file-path], [file-path], ... ]
	 * @endcode
	 */
	protected $scripts = [];

	/**
	 * @var array List of JavaScript files to include when using a specific language
	 * @par Usage:
	 * @code
	 * [ [language-code] => [ [file-path], [file-path], ... ], ... ]
	 * @endcode
	 */
	protected $languageScripts = [];

	/**
	 * @var array List of JavaScript files to include when using a specific skin
	 * @par Usage:
	 * @code
	 * [ [skin-name] => [ [file-path], [file-path], ... ], ... ]
	 * @endcode
	 */
	protected $skinScripts = [];

	/**
	 * @var array List of paths to JavaScript files to include in debug mode
	 * @par Usage:
	 * @code
	 * [ [skin-name] => [ [file-path], [file-path], ... ], ... ]
	 * @endcode
	 */
	protected $debugScripts = [];

	/**
	 * @var array List of paths to CSS files to always include
	 * @par Usage:
	 * @code
	 * [ [file-path], [file-path], ... ]
	 * @endcode
	 */
	protected $styles = [];

	/**
	 * @var array List of paths to CSS files to include when using specific skins
	 * @par Usage:
	 * @code
	 * [ [file-path], [file-path], ... ]
	 * @endcode
	 */
	protected $skinStyles = [];

	/**
	 * @var array List of packaged files to make available through require()
	 * @par Usage:
	 * @code
	 * [ [file-path], [file-path], ... ]
	 * @endcode
	 */
	protected $packageFiles = null;

	/**
	 * @var array Expanded versions of $packageFiles, lazy-computed by expandPackageFiles();
	 *  keyed by context hash
	 */
	private $expandedPackageFiles = [];

	/**
	 * @var array List of modules this module depends on
	 * @par Usage:
	 * @code
	 * [ [file-path], [file-path], ... ]
	 * @endcode
	 */
	protected $dependencies = [];

	/**
	 * @var string File name containing the body of the skip function
	 */
	protected $skipFunction = null;

	/**
	 * @var array List of message keys used by this module
	 * @par Usage:
	 * @code
	 * [ [message-key], [message-key], ... ]
	 * @endcode
	 */
	protected $messages = [];

	/** @var string Name of group to load this module in */
	protected $group;

	/** @var bool Link to raw files in debug mode */
	protected $debugRaw = true;

	/** @var bool Whether mw.loader.state() call should be omitted */
	protected $raw = false;

	protected $targets = [ 'desktop' ];

	/** @var bool Whether CSSJanus flipping should be skipped for this module */
	protected $noflip = false;

	/**
	 * @var bool Whether getStyleURLsForDebug should return raw file paths,
	 * or return load.php urls
	 */
	protected $hasGeneratedStyles = false;

	/**
	 * @var array Place where readStyleFile() tracks file dependencies
	 * @par Usage:
	 * @code
	 * [ [file-path], [file-path], ... ]
	 * @endcode
	 */
	protected $localFileRefs = [];

	/**
	 * @var array Place where readStyleFile() tracks file dependencies for non-existent files.
	 * Used in tests to detect missing dependencies.
	 */
	protected $missingLocalFileRefs = [];

	/**
	 * Constructs a new module from an options array.
	 *
	 * @param array $options List of options; if not given or empty, an empty module will be
	 *     constructed
	 * @param string|null $localBasePath Base path to prepend to all local paths in $options.
	 *     Defaults to $IP
	 * @param string|null $remoteBasePath Base path to prepend to all remote paths in $options.
	 *     Defaults to $wgResourceBasePath
	 *
	 * Below is a description for the $options array:
	 * @throws InvalidArgumentException
	 * @par Construction options:
	 * @code
	 *     [
	 *         // Base path to prepend to all local paths in $options. Defaults to $IP
	 *         'localBasePath' => [base path],
	 *         // Base path to prepend to all remote paths in $options. Defaults to $wgResourceBasePath
	 *         'remoteBasePath' => [base path],
	 *         // Equivalent of remoteBasePath, but relative to $wgExtensionAssetsPath
	 *         'remoteExtPath' => [base path],
	 *         // Equivalent of remoteBasePath, but relative to $wgStylePath
	 *         'remoteSkinPath' => [base path],
	 *         // Scripts to always include (cannot be set if 'packageFiles' is also set, see below)
	 *         'scripts' => [file path string or array of file path strings],
	 *         // Scripts to include in specific language contexts
	 *         'languageScripts' => [
	 *             [language code] => [file path string or array of file path strings],
	 *         ],
	 *         // Scripts to include in specific skin contexts
	 *         'skinScripts' => [
	 *             [skin name] => [file path string or array of file path strings],
	 *         ],
	 *         // Scripts to include in debug contexts
	 *         'debugScripts' => [file path string or array of file path strings],
	 *         // For package modules: files to be made available for internal require() do not
	 *         // need to have 'type' defined; it will be inferred from the file name extension
	 *         // if omitted. 'config' can only be used when 'type' is 'data'; the variables are
	 *         // resolved with Config::get(). The first entry in 'packageFiles' is always the
	 *         // module entry point. If 'packageFiles' is set, 'scripts' cannot also be set.
	 *         'packageFiles' => [
	 *             [file path string], // or:
	 *             [ 'name' => [file name], 'file' => [file path], 'type' => 'script'|'data' ], // or:
	 *             [ 'name' => [name], 'content' => [string], 'type' => 'script'|'data' ], // or:
	 *             [ 'name' => [name], 'callback' => [callable], 'type' => 'script'|'data' ],
	 *             [ 'name' => [name], 'config' => [ [config var name], ... ], 'type' => 'data' ],
	 *             [ 'name' => [name], 'config' => [ [JS name] => [PHP name] ], 'type' => 'data' ],
	 *         ],
	 *         // Modules which must be loaded before this module
	 *         'dependencies' => [module name string or array of module name strings],
	 *         'templates' => [
	 *             [template alias with file.ext] => [file path to a template file],
	 *         ],
	 *         // Styles to always load
	 *         'styles' => [file path string or array of file path strings],
	 *         // Styles to include in specific skin contexts
	 *         'skinStyles' => [
	 *             [skin name] => [file path string or array of file path strings],
	 *         ],
	 *         // Messages to always load
	 *         'messages' => [array of message key strings],
	 *         // Group which this module should be loaded together with
	 *         'group' => [group name string],
	 *         // Function that, if it returns true, makes the loader skip this module.
	 *         // The file must contain valid JavaScript for execution in a private function.
	 *         // The file must not contain the "function () {" and "}" wrapper though.
	 *         'skipFunction' => [file path]
	 *     ]
	 * @endcode
	 */
	public function __construct(
		$options = [],
		$localBasePath = null,
		$remoteBasePath = null
	) {
		// Flag to decide whether to automagically add the mediawiki.template module
		$hasTemplates = false;
		// localBasePath and remoteBasePath both have unbelievably long fallback chains
		// and need to be handled separately.
		list( $this->localBasePath, $this->remoteBasePath ) =
			self::extractBasePaths( $options, $localBasePath, $remoteBasePath );

		// Extract, validate and normalise remaining options
		foreach ( $options as $member => $option ) {
			switch ( $member ) {
				// Lists of file paths
				case 'scripts':
				case 'debugScripts':
				case 'styles':
				case 'packageFiles':
					$this->{$member} = (array)$option;
					break;
				case 'templates':
					$hasTemplates = true;
					$this->{$member} = (array)$option;
					break;
				// Collated lists of file paths
				case 'languageScripts':
				case 'skinScripts':
				case 'skinStyles':
					if ( !is_array( $option ) ) {
						throw new InvalidArgumentException(
							"Invalid collated file path list error. " .
							"'$option' given, array expected."
						);
					}
					foreach ( $option as $key => $value ) {
						if ( !is_string( $key ) ) {
							throw new InvalidArgumentException(
								"Invalid collated file path list key error. " .
								"'$key' given, string expected."
							);
						}
						$this->{$member}[$key] = (array)$value;
					}
					break;
				case 'deprecated':
					$this->deprecated = $option;
					break;
				// Lists of strings
				case 'dependencies':
				case 'messages':
				case 'targets':
					// Normalise
					$option = array_values( array_unique( (array)$option ) );
					sort( $option );

					$this->{$member} = $option;
					break;
				// Single strings
				case 'group':
				case 'skipFunction':
					$this->{$member} = (string)$option;
					break;
				// Single booleans
				case 'debugRaw':
				case 'raw':
				case 'noflip':
					$this->{$member} = (bool)$option;
					break;
			}
		}
		if ( isset( $options['scripts'] ) && isset( $options['packageFiles'] ) ) {
			throw new InvalidArgumentException( "A module may not set both 'scripts' and 'packageFiles'" );
		}
		if ( $hasTemplates ) {
			$this->dependencies[] = 'mediawiki.template';
			// Ensure relevant template compiler module gets loaded
			foreach ( $this->templates as $alias => $templatePath ) {
				if ( is_int( $alias ) ) {
					$alias = $templatePath;
				}
				$suffix = explode( '.', $alias );
				$suffix = end( $suffix );
				$compilerModule = 'mediawiki.template.' . $suffix;
				if ( $suffix !== 'html' && !in_array( $compilerModule, $this->dependencies ) ) {
					$this->dependencies[] = $compilerModule;
				}
			}
		}
	}

	/**
	 * Extract a pair of local and remote base paths from module definition information.
	 * Implementation note: the amount of global state used in this function is staggering.
	 *
	 * @param array $options Module definition
	 * @param string|null $localBasePath Path to use if not provided in module definition. Defaults
	 *     to $IP
	 * @param string|null $remoteBasePath Path to use if not provided in module definition. Defaults
	 *     to $wgResourceBasePath
	 * @return array Array( localBasePath, remoteBasePath )
	 */
	public static function extractBasePaths(
		$options = [],
		$localBasePath = null,
		$remoteBasePath = null
	) {
		global $IP, $wgResourceBasePath;

		// The different ways these checks are done, and their ordering, look very silly,
		// but were preserved for backwards-compatibility just in case. Tread lightly.

		if ( $localBasePath === null ) {
			$localBasePath = $IP;
		}
		if ( $remoteBasePath === null ) {
			$remoteBasePath = $wgResourceBasePath;
		}

		if ( isset( $options['remoteExtPath'] ) ) {
			global $wgExtensionAssetsPath;
			$remoteBasePath = $wgExtensionAssetsPath . '/' . $options['remoteExtPath'];
		}

		if ( isset( $options['remoteSkinPath'] ) ) {
			global $wgStylePath;
			$remoteBasePath = $wgStylePath . '/' . $options['remoteSkinPath'];
		}

		if ( array_key_exists( 'localBasePath', $options ) ) {
			$localBasePath = (string)$options['localBasePath'];
		}

		if ( array_key_exists( 'remoteBasePath', $options ) ) {
			$remoteBasePath = (string)$options['remoteBasePath'];
		}

		return [ $localBasePath, $remoteBasePath ];
	}

	/**
	 * Gets all scripts for a given context concatenated together.
	 *
	 * @param ResourceLoaderContext $context Context in which to generate script
	 * @return string|array JavaScript code for $context, or package files data structure
	 */
	public function getScript( ResourceLoaderContext $context ) {
		$deprecationScript = $this->getDeprecationInformation();
		if ( $this->packageFiles !== null ) {
			$packageFiles = $this->getPackageFiles( $context );
			if ( $deprecationScript ) {
				$mainFile =& $packageFiles['files'][$packageFiles['main']];
				$mainFile['content'] = $deprecationScript . $mainFile['content'];
			}
			return $packageFiles;
		}

		$files = $this->getScriptFiles( $context );
		return $deprecationScript . $this->readScriptFiles( $files );
	}

	/**
	 * @param ResourceLoaderContext $context
	 * @return array
	 */
	public function getScriptURLsForDebug( ResourceLoaderContext $context ) {
		$urls = [];
		foreach ( $this->getScriptFiles( $context ) as $file ) {
			$urls[] = OutputPage::transformResourcePath(
				$this->getConfig(),
				$this->getRemotePath( $file )
			);
		}
		return $urls;
	}

	/**
	 * @return bool
	 */
	public function supportsURLLoading() {
		// If package files are involved, don't support URL loading, because that breaks
		// scoped require() functions
		return $this->debugRaw && !$this->packageFiles;
	}

	/**
	 * Get all styles for a given context.
	 *
	 * @param ResourceLoaderContext $context
	 * @return array CSS code for $context as an associative array mapping media type to CSS text.
	 */
	public function getStyles( ResourceLoaderContext $context ) {
		$styles = $this->readStyleFiles(
			$this->getStyleFiles( $context ),
			$this->getFlip( $context ),
			$context
		);
		// Collect referenced files
		$this->saveFileDependencies( $context, $this->localFileRefs );

		return $styles;
	}

	/**
	 * @param ResourceLoaderContext $context
	 * @return array
	 */
	public function getStyleURLsForDebug( ResourceLoaderContext $context ) {
		if ( $this->hasGeneratedStyles ) {
			// Do the default behaviour of returning a url back to load.php
			// but with only=styles.
			return parent::getStyleURLsForDebug( $context );
		}
		// Our module consists entirely of real css files,
		// in debug mode we can load those directly.
		$urls = [];
		foreach ( $this->getStyleFiles( $context ) as $mediaType => $list ) {
			$urls[$mediaType] = [];
			foreach ( $list as $file ) {
				$urls[$mediaType][] = OutputPage::transformResourcePath(
					$this->getConfig(),
					$this->getRemotePath( $file )
				);
			}
		}
		return $urls;
	}

	/**
	 * Gets list of message keys used by this module.
	 *
	 * @return array List of message keys
	 */
	public function getMessages() {
		return $this->messages;
	}

	/**
	 * Gets the name of the group this module should be loaded in.
	 *
	 * @return string Group name
	 */
	public function getGroup() {
		return $this->group;
	}

	/**
	 * Gets list of names of modules this module depends on.
	 * @param ResourceLoaderContext|null $context
	 * @return array List of module names
	 */
	public function getDependencies( ResourceLoaderContext $context = null ) {
		return $this->dependencies;
	}

	/**
	 * Get the skip function.
	 * @return null|string
	 * @throws MWException
	 */
	public function getSkipFunction() {
		if ( !$this->skipFunction ) {
			return null;
		}

		$localPath = $this->getLocalPath( $this->skipFunction );
		if ( !file_exists( $localPath ) ) {
			throw new MWException( __METHOD__ . ": skip function file not found: \"$localPath\"" );
		}
		$contents = $this->stripBom( file_get_contents( $localPath ) );
		return $contents;
	}

	/**
	 * @return bool
	 */
	public function isRaw() {
		return $this->raw;
	}

	/**
	 * Disable module content versioning.
	 *
	 * This class uses getDefinitionSummary() instead, to avoid filesystem overhead
	 * involved with building the full module content inside a startup request.
	 *
	 * @return bool
	 */
	public function enableModuleContentVersion() {
		return false;
	}

	/**
	 * Helper method for getDefinitionSummary.
	 *
	 * @see ResourceLoaderModule::getFileDependencies
	 * @param ResourceLoaderContext $context
	 * @return array
	 */
	private function getFileHashes( ResourceLoaderContext $context ) {
		$files = [];

		// Flatten style files into $files
		$styles = self::collateFilePathListByOption( $this->styles, 'media', 'all' );
		foreach ( $styles as $styleFiles ) {
			$files = array_merge( $files, $styleFiles );
		}

		$skinFiles = self::collateFilePathListByOption(
			self::tryForKey( $this->skinStyles, $context->getSkin(), 'default' ),
			'media',
			'all'
		);
		foreach ( $skinFiles as $styleFiles ) {
			$files = array_merge( $files, $styleFiles );
		}

		// Extract file names for package files
		$expandedPackageFiles = $this->expandPackageFiles( $context );
		$packageFiles = $expandedPackageFiles ?
			array_filter( array_map( function ( $fileInfo ) {
				return $fileInfo['filePath'] ?? null;
			}, $expandedPackageFiles['files'] ) ) :
			[];

		// Final merge, this should result in a master list of dependent files
		$files = array_merge(
			$files,
			$packageFiles,
			$this->scripts,
			$this->templates,
			$context->getDebug() ? $this->debugScripts : [],
			$this->getLanguageScripts( $context->getLanguage() ),
			self::tryForKey( $this->skinScripts, $context->getSkin(), 'default' )
		);
		if ( $this->skipFunction ) {
			$files[] = $this->skipFunction;
		}
		$files = array_map( [ $this, 'getLocalPath' ], $files );
		// File deps need to be treated separately because they're already prefixed
		$files = array_merge( $files, $this->getFileDependencies( $context ) );
		// Filter out any duplicates from getFileDependencies() and others.
		// Most commonly introduced by compileLessFile(), which always includes the
		// entry point Less file we already know about.
		$files = array_values( array_unique( $files ) );

		// Don't include keys or file paths here, only the hashes. Including that would needlessly
		// cause global cache invalidation when files move or if e.g. the MediaWiki path changes.
		// Any significant ordering is already detected by the definition summary.
		return array_map( [ __CLASS__, 'safeFileHash' ], $files );
	}

	/**
	 * Get the definition summary for this module.
	 *
	 * @param ResourceLoaderContext $context
	 * @return array
	 */
	public function getDefinitionSummary( ResourceLoaderContext $context ) {
		$summary = parent::getDefinitionSummary( $context );

		$options = [];
		foreach ( [
			// The following properties are omitted because they don't affect the module reponse:
			// - localBasePath (Per T104950; Changes when absolute directory name changes. If
			//    this affects 'scripts' and other file paths, getFileHashes accounts for that.)
			// - remoteBasePath (Per T104950)
			// - dependencies (provided via startup module)
			// - targets
			// - group (provided via startup module)
			'scripts',
			'debugScripts',
			'styles',
			'languageScripts',
			'skinScripts',
			'skinStyles',
			'messages',
			'templates',
			'skipFunction',
			'debugRaw',
			'raw',
		] as $member ) {
			$options[$member] = $this->{$member};
		};

		$summary[] = [
			'options' => $options,
			'packageFiles' => $this->expandPackageFiles( $context ),
			'fileHashes' => $this->getFileHashes( $context ),
			'messageBlob' => $this->getMessageBlob( $context ),
		];

		$lessVars = $this->getLessVars( $context );
		if ( $lessVars ) {
			$summary[] = [ 'lessVars' => $lessVars ];
		}

		return $summary;
	}

	/**
	 * @param string|ResourceLoaderFilePath $path
	 * @return string
	 */
	protected function getLocalPath( $path ) {
		if ( $path instanceof ResourceLoaderFilePath ) {
			return $path->getLocalPath();
		}

		return "{$this->localBasePath}/$path";
	}

	/**
	 * @param string|ResourceLoaderFilePath $path
	 * @return string
	 */
	protected function getRemotePath( $path ) {
		if ( $path instanceof ResourceLoaderFilePath ) {
			return $path->getRemotePath();
		}

		return "{$this->remoteBasePath}/$path";
	}

	/**
	 * Infer the stylesheet language from a stylesheet file path.
	 *
	 * @since 1.22
	 * @param string $path
	 * @return string The stylesheet language name
	 */
	public function getStyleSheetLang( $path ) {
		return preg_match( '/\.less$/i', $path ) ? 'less' : 'css';
	}

	/**
	 * Infer the file type from a package file path.
	 * @param string $path
	 * @return string 'script' or 'data'
	 */
	public static function getPackageFileType( $path ) {
		if ( preg_match( '/\.json$/i', $path ) ) {
			return 'data';
		}
		return 'script';
	}

	/**
	 * Collates file paths by option (where provided).
	 *
	 * @param array $list List of file paths in any combination of index/path
	 *     or path/options pairs
	 * @param string $option Option name
	 * @param mixed $default Default value if the option isn't set
	 * @return array List of file paths, collated by $option
	 */
	protected static function collateFilePathListByOption( array $list, $option, $default ) {
		$collatedFiles = [];
		foreach ( (array)$list as $key => $value ) {
			if ( is_int( $key ) ) {
				// File name as the value
				if ( !isset( $collatedFiles[$default] ) ) {
					$collatedFiles[$default] = [];
				}
				$collatedFiles[$default][] = $value;
			} elseif ( is_array( $value ) ) {
				// File name as the key, options array as the value
				$optionValue = $value[$option] ?? $default;
				if ( !isset( $collatedFiles[$optionValue] ) ) {
					$collatedFiles[$optionValue] = [];
				}
				$collatedFiles[$optionValue][] = $key;
			}
		}
		return $collatedFiles;
	}

	/**
	 * Get a list of element that match a key, optionally using a fallback key.
	 *
	 * @param array $list List of lists to select from
	 * @param string $key Key to look for in $map
	 * @param string|null $fallback Key to look for in $list if $key doesn't exist
	 * @return array List of elements from $map which matched $key or $fallback,
	 *  or an empty list in case of no match
	 */
	protected static function tryForKey( array $list, $key, $fallback = null ) {
		if ( isset( $list[$key] ) && is_array( $list[$key] ) ) {
			return $list[$key];
		} elseif ( is_string( $fallback )
			&& isset( $list[$fallback] )
			&& is_array( $list[$fallback] )
		) {
			return $list[$fallback];
		}
		return [];
	}

	/**
	 * Get a list of script file paths for this module, in order of proper execution.
	 *
	 * @param ResourceLoaderContext $context
	 * @return array List of file paths
	 */
	private function getScriptFiles( ResourceLoaderContext $context ) {
		$files = array_merge(
			$this->scripts,
			$this->getLanguageScripts( $context->getLanguage() ),
			self::tryForKey( $this->skinScripts, $context->getSkin(), 'default' )
		);
		if ( $context->getDebug() ) {
			$files = array_merge( $files, $this->debugScripts );
		}

		return array_unique( $files, SORT_REGULAR );
	}

	/**
	 * Get the set of language scripts for the given language,
	 * possibly using a fallback language.
	 *
	 * @param string $lang
	 * @return array
	 */
	private function getLanguageScripts( $lang ) {
		$scripts = self::tryForKey( $this->languageScripts, $lang );
		if ( $scripts ) {
			return $scripts;
		}
		$fallbacks = Language::getFallbacksFor( $lang );
		foreach ( $fallbacks as $lang ) {
			$scripts = self::tryForKey( $this->languageScripts, $lang );
			if ( $scripts ) {
				return $scripts;
			}
		}

		return [];
	}

	/**
	 * Get a list of file paths for all styles in this module, in order of proper inclusion.
	 *
	 * This is considered a private method. Exposed for internal use by WebInstallerOutput.
	 *
	 * @private
	 * @param ResourceLoaderContext $context
	 * @return array List of file paths
	 */
	public function getStyleFiles( ResourceLoaderContext $context ) {
		return array_merge_recursive(
			self::collateFilePathListByOption( $this->styles, 'media', 'all' ),
			self::collateFilePathListByOption(
				self::tryForKey( $this->skinStyles, $context->getSkin(), 'default' ),
				'media',
				'all'
			)
		);
	}

	/**
	 * Gets a list of file paths for all skin styles in the module used by
	 * the skin.
	 *
	 * @param string $skinName The name of the skin
	 * @return array A list of file paths collated by media type
	 */
	protected function getSkinStyleFiles( $skinName ) {
		return self::collateFilePathListByOption(
			self::tryForKey( $this->skinStyles, $skinName ),
			'media',
			'all'
		);
	}

	/**
	 * Gets a list of file paths for all skin style files in the module,
	 * for all available skins.
	 *
	 * @return array A list of file paths collated by media type
	 */
	protected function getAllSkinStyleFiles() {
		$styleFiles = [];
		$internalSkinNames = array_keys( Skin::getSkinNames() );
		$internalSkinNames[] = 'default';

		foreach ( $internalSkinNames as $internalSkinName ) {
			$styleFiles = array_merge_recursive(
				$styleFiles,
				$this->getSkinStyleFiles( $internalSkinName )
			);
		}

		return $styleFiles;
	}

	/**
	 * Returns all style files and all skin style files used by this module.
	 *
	 * @return array
	 */
	public function getAllStyleFiles() {
		$collatedStyleFiles = array_merge_recursive(
			self::collateFilePathListByOption( $this->styles, 'media', 'all' ),
			$this->getAllSkinStyleFiles()
		);

		$result = [];

		foreach ( $collatedStyleFiles as $media => $styleFiles ) {
			foreach ( $styleFiles as $styleFile ) {
				$result[] = $this->getLocalPath( $styleFile );
			}
		}

		return $result;
	}

	/**
	 * Get the contents of a list of JavaScript files. Helper for getScript().
	 *
	 * @param array $scripts List of file paths to scripts to read, remap and concetenate
	 * @return string Concatenated JavaScript data from $scripts
	 * @throws MWException
	 */
	private function readScriptFiles( array $scripts ) {
		if ( empty( $scripts ) ) {
			return '';
		}
		$js = '';
		foreach ( array_unique( $scripts, SORT_REGULAR ) as $fileName ) {
			$localPath = $this->getLocalPath( $fileName );
			if ( !file_exists( $localPath ) ) {
				throw new MWException( __METHOD__ . ": script file not found: \"$localPath\"" );
			}
			$contents = $this->stripBom( file_get_contents( $localPath ) );
			$js .= $contents . "\n";
		}
		return $js;
	}

	/**
	 * Get the contents of a list of CSS files.
	 *
	 * @internal This is considered a private method. Exposed for internal use by WebInstallerOutput.
	 * @param array $styles Map of media type to file paths to read, remap, and concatenate
	 * @param bool $flip
	 * @param ResourceLoaderContext $context
	 * @return array List of concatenated and remapped CSS data from $styles,
	 *     keyed by media type
	 * @throws MWException
	 */
	public function readStyleFiles( array $styles, $flip, $context ) {
		if ( !$styles ) {
			return [];
		}
		foreach ( $styles as $media => $files ) {
			$uniqueFiles = array_unique( $files, SORT_REGULAR );
			$styleFiles = [];
			foreach ( $uniqueFiles as $file ) {
				$styleFiles[] = $this->readStyleFile( $file, $flip, $context );
			}
			$styles[$media] = implode( "\n", $styleFiles );
		}
		return $styles;
	}

	/**
	 * Reads a style file.
	 *
	 * This method can be used as a callback for array_map()
	 *
	 * @param string $path File path of style file to read
	 * @param bool $flip
	 * @param ResourceLoaderContext $context
	 *
	 * @return string CSS data in script file
	 * @throws MWException If the file doesn't exist
	 */
	protected function readStyleFile( $path, $flip, $context ) {
		$localPath = $this->getLocalPath( $path );
		$remotePath = $this->getRemotePath( $path );
		if ( !file_exists( $localPath ) ) {
			$msg = __METHOD__ . ": style file not found: \"$localPath\"";
			wfDebugLog( 'resourceloader', $msg );
			throw new MWException( $msg );
		}

		if ( $this->getStyleSheetLang( $localPath ) === 'less' ) {
			$style = $this->compileLessFile( $localPath, $context );
			$this->hasGeneratedStyles = true;
		} else {
			$style = $this->stripBom( file_get_contents( $localPath ) );
		}

		if ( $flip ) {
			$style = CSSJanus::transform( $style, true, false );
		}
		$localDir = dirname( $localPath );
		$remoteDir = dirname( $remotePath );
		// Get and register local file references
		$localFileRefs = CSSMin::getLocalFileReferences( $style, $localDir );
		foreach ( $localFileRefs as $file ) {
			if ( file_exists( $file ) ) {
				$this->localFileRefs[] = $file;
			} else {
				$this->missingLocalFileRefs[] = $file;
			}
		}
		// Don't cache this call. remap() ensures data URIs embeds are up to date,
		// and urls contain correct content hashes in their query string. (T128668)
		return CSSMin::remap( $style, $localDir, $remoteDir, true );
	}

	/**
	 * Get whether CSS for this module should be flipped
	 * @param ResourceLoaderContext $context
	 * @return bool
	 */
	public function getFlip( $context ) {
		return $context->getDirection() === 'rtl' && !$this->noflip;
	}

	/**
	 * Get target(s) for the module, eg ['desktop'] or ['desktop', 'mobile']
	 *
	 * @return array Array of strings
	 */
	public function getTargets() {
		return $this->targets;
	}

	/**
	 * Get the module's load type.
	 *
	 * @since 1.28
	 * @return string
	 */
	public function getType() {
		$canBeStylesOnly = !(
			// All options except 'styles', 'skinStyles' and 'debugRaw'
			$this->scripts
			|| $this->debugScripts
			|| $this->templates
			|| $this->languageScripts
			|| $this->skinScripts
			|| $this->dependencies
			|| $this->messages
			|| $this->skipFunction
			|| $this->raw
		);
		return $canBeStylesOnly ? self::LOAD_STYLES : self::LOAD_GENERAL;
	}

	/**
	 * Compile a LESS file into CSS.
	 *
	 * Keeps track of all used files and adds them to localFileRefs.
	 *
	 * @since 1.22
	 * @since 1.27 Added $context paramter.
	 * @throws Exception If less.php encounters a parse error
	 * @param string $fileName File path of LESS source
	 * @param ResourceLoaderContext $context Context in which to generate script
	 * @return string CSS source
	 */
	protected function compileLessFile( $fileName, ResourceLoaderContext $context ) {
		static $cache;

		if ( !$cache ) {
			$cache = ObjectCache::getLocalServerInstance( CACHE_ANYTHING );
		}

		$vars = $this->getLessVars( $context );
		// Construct a cache key from the LESS file name, and a hash digest
		// of the LESS variables used for compilation.
		ksort( $vars );
		$varsHash = hash( 'md4', serialize( $vars ) );
		$cacheKey = $cache->makeGlobalKey( 'LESS', $fileName, $varsHash );
		$cachedCompile = $cache->get( $cacheKey );

		// If we got a cached value, we have to validate it by getting a
		// checksum of all the files that were loaded by the parser and
		// ensuring it matches the cached entry's.
		if ( isset( $cachedCompile['hash'] ) ) {
			$contentHash = FileContentsHasher::getFileContentsHash( $cachedCompile['files'] );
			if ( $contentHash === $cachedCompile['hash'] ) {
				$this->localFileRefs = array_merge( $this->localFileRefs, $cachedCompile['files'] );
				return $cachedCompile['css'];
			}
		}

		$compiler = $context->getResourceLoader()->getLessCompiler( $vars );
		$css = $compiler->parseFile( $fileName )->getCss();
		$files = $compiler->AllParsedFiles();
		$this->localFileRefs = array_merge( $this->localFileRefs, $files );

		// Cache for 24 hours (86400 seconds).
		$cache->set( $cacheKey, [
			'css'   => $css,
			'files' => $files,
			'hash'  => FileContentsHasher::getFileContentsHash( $files ),
		], 3600 * 24 );

		return $css;
	}

	/**
	 * Takes named templates by the module and returns an array mapping.
	 * @return array Templates mapping template alias to content
	 * @throws MWException
	 */
	public function getTemplates() {
		$templates = [];

		foreach ( $this->templates as $alias => $templatePath ) {
			// Alias is optional
			if ( is_int( $alias ) ) {
				$alias = $templatePath;
			}
			$localPath = $this->getLocalPath( $templatePath );
			if ( file_exists( $localPath ) ) {
				$content = file_get_contents( $localPath );
				$templates[$alias] = $this->stripBom( $content );
			} else {
				$msg = __METHOD__ . ": template file not found: \"$localPath\"";
				wfDebugLog( 'resourceloader', $msg );
				throw new MWException( $msg );
			}
		}
		return $templates;
	}

	/**
	 * Expand the packageFiles definition into something that's (almost) the right format for
	 * getPackageFiles() to return. This expands shorthands, resolves config vars and callbacks,
	 * but does not expand file paths or read the actual contents of files. Those things are done
	 * by getPackageFiles().
	 *
	 * This is split up in this way so that getFileHashes() can get a list of file names, and
	 * getDefinitionSummary() can get config vars and callback results in their expanded form.
	 *
	 * @param ResourceLoaderContext $context
	 * @return array|null
	 */
	private function expandPackageFiles( ResourceLoaderContext $context ) {
		$hash = $context->getHash();
		if ( isset( $this->expandedPackageFiles[$hash] ) ) {
			return $this->expandedPackageFiles[$hash];
		}
		if ( $this->packageFiles === null ) {
			return null;
		}
		$expandedFiles = [];
		$mainFile = null;

		foreach ( $this->packageFiles as $alias => $fileInfo ) {
			if ( is_string( $fileInfo ) ) {
				$fileInfo = [ 'name' => $fileInfo, 'file' => $fileInfo ];
			} elseif ( !isset( $fileInfo['name'] ) ) {
				$msg = __METHOD__ . ": invalid package file definition for module " .
					"\"{$this->getName()}\": 'name' key is required when value is not a string";
				wfDebugLog( 'resourceloader', $msg );
				throw new MWException( $msg );
			}

			// Infer type from alias if needed
			$type = $fileInfo['type'] ?? self::getPackageFileType( $fileInfo['name'] );
			$expanded = [ 'type' => $type ];
			if ( !empty( $fileInfo['main'] ) ) {
				$mainFile = $fileInfo['name'];
				if ( $type !== 'script' ) {
					$msg = __METHOD__ . ": invalid package file definition for module " .
						"\"{$this->getName()}\": main file \"$mainFile\" must be of type \"script\", not \"$type\"";
					wfDebugLog( 'resourceloader', $msg );
					throw new MWException( $msg );
				}
			}

			if ( isset( $fileInfo['content'] ) ) {
				$expanded['content'] = $fileInfo['content'];
			} elseif ( isset( $fileInfo['file'] ) ) {
				$expanded['filePath'] = $fileInfo['file'];
			} elseif ( isset( $fileInfo['callback'] ) ) {
				if ( is_callable( $fileInfo['callback'] ) ) {
					$expanded['content'] = $fileInfo['callback']( $context );
				} else {
					$msg = __METHOD__ . ": invalid callback for package file \"{$fileInfo['name']}\"" .
						" in module \"{$this->getName()}\"";
					wfDebugLog( 'resourceloader', $msg );
					throw new MWException( $msg );
				}
			} elseif ( isset( $fileInfo['config'] ) ) {
				if ( $type !== 'data' ) {
					$msg = __METHOD__ . ": invalid use of \"config\" for package file \"{$fileInfo['name']}\" " .
						"in module \"{$this->getName()}\": type must be \"data\" but is \"$type\"";
					wfDebugLog( 'resourceloader', $msg );
					throw new MWException( $msg );
				}
				$expandedConfig = [];
				foreach ( $fileInfo['config'] as $key => $var ) {
					$expandedConfig[ is_numeric( $key ) ? $var : $key ] = $this->getConfig()->get( $var );
				}
				$expanded['content'] = $expandedConfig;
			} elseif ( !empty( $fileInfo['main'] ) ) {
				// [ 'name' => 'foo.js', 'main' => true ] is shorthand
				$expanded['filePath'] = $fileInfo['name'];
			} else {
				$msg = __METHOD__ . ": invalid package file definition for \"{$fileInfo['name']}\" " .
					"in module \"{$this->getName()}\": one of \"file\", \"content\", \"callback\" or \"config\" " .
					"must be set";
				wfDebugLog( 'resourceloader', $msg );
				throw new MWException( $msg );
			}

			$expandedFiles[$fileInfo['name']] = $expanded;
		}

		if ( $expandedFiles && $mainFile === null ) {
			// The first package file that is a script is the main file
			foreach ( $expandedFiles as $path => &$file ) {
				if ( $file['type'] === 'script' ) {
					$mainFile = $path;
					break;
				}
			}
		}

		$result = [
			'main' => $mainFile,
			'files' => $expandedFiles
		];

		$this->expandedPackageFiles[$hash] = $result;
		return $result;
	}

	/**
	 * Resolves the package files defintion and generates the content of each package file.
	 * @param ResourceLoaderContext $context
	 * @return array Package files data structure, see ResourceLoaderModule::getScript()
	 */
	public function getPackageFiles( ResourceLoaderContext $context ) {
		if ( $this->packageFiles === null ) {
			return null;
		}
		$expandedPackageFiles = $this->expandPackageFiles( $context );

		// Expand file contents
		foreach ( $expandedPackageFiles['files'] as &$fileInfo ) {
			if ( isset( $fileInfo['filePath'] ) ) {
				$localPath = $this->getLocalPath( $fileInfo['filePath'] );
				if ( !file_exists( $localPath ) ) {
					$msg = __METHOD__ . ": package file not found: \"$localPath\"" .
						" in module \"{$this->getName()}\"";
					wfDebugLog( 'resourceloader', $msg );
					throw new MWException( $msg );
				}
				$content = $this->stripBom( file_get_contents( $localPath ) );
				if ( $fileInfo['type'] === 'data' ) {
					$content = json_decode( $content );
				}
				$fileInfo['content'] = $content;
				unset( $fileInfo['filePath'] );
			}
		}

		return $expandedPackageFiles;
	}

	/**
	 * Takes an input string and removes the UTF-8 BOM character if present
	 *
	 * We need to remove these after reading a file, because we concatenate our files and
	 * the BOM character is not valid in the middle of a string.
	 * We already assume UTF-8 everywhere, so this should be safe.
	 *
	 * @param string $input
	 * @return string Input minus the intial BOM char
	 */
	protected function stripBom( $input ) {
		if ( substr_compare( "\xef\xbb\xbf", $input, 0, 3 ) === 0 ) {
			return substr( $input, 3 );
		}
		return $input;
	}
}
