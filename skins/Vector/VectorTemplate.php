<?php
/**
 * Vector - Modern version of MonoBook with fresh look and many usability
 * improvements.
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
 * @ingroup Skins
 */

/**
 * QuickTemplate class for Vector skin
 * @ingroup Skins
 */
class VectorTemplate extends BaseTemplate {
	/* Functions */

	/**
	 * Outputs the entire contents of the (X)HTML page
	 */
	public function execute() {
		global $wgScriptPath;
		
		$this->data['namespace_urls'] = $this->data['content_navigation']['namespaces'];
		$this->data['view_urls'] = $this->data['content_navigation']['views'];
		$this->data['action_urls'] = $this->data['content_navigation']['actions'];
		$this->data['variant_urls'] = $this->data['content_navigation']['variants'];

		// Move the watch/unwatch star outside of the collapsed "actions" menu to the main "views" menu
		if ( $this->config->get( 'VectorUseIconWatch' ) ) {
			$mode = $this->getSkin()->getUser()->isWatched( $this->getSkin()->getRelevantTitle() )
				? 'unwatch'
				: 'watch';

			if ( isset( $this->data['action_urls'][$mode] ) ) {
				$this->data['view_urls'][$mode] = $this->data['action_urls'][$mode];
				unset( $this->data['action_urls'][$mode] );
			}
		}

		// Reverse horizontally rendered navigation elements
		if ( $this->data['rtl'] ) {
			$this->data['view_urls'] =
				array_reverse( $this->data['view_urls'] );
			$this->data['namespace_urls'] =
				array_reverse( $this->data['namespace_urls'] );
			$this->data['personal_urls'] =
				array_reverse( $this->data['personal_urls'] );
		}

		$this->data['pageLanguage'] =
			$this->getSkin()->getTitle()->getPageViewLanguage()->getHtmlCode();

		// Output HTML Page
		$this->html( 'headelement' );
		?>
		<div class="collab-fip-header" style="height:35px; clear:both; background-color:white;">
			<object type="image/svg+xml" tabindex="-1" role="img" data="<?php echo $wgScriptPath; ?>/skins/Vector/images/collab/sig-alt-en.svg" aria-label="Symbol of the Government of Canada" style="height:25px; float:left; padding:5px 10px;"></object>
			<ul id="tool-links" class="" style="list-style:none; padding:5px; width:30%; margin: 0 auto; font-weight:bold;">
				<li style="float:left; margin: 0px 2%;"><a href="https://account.gccollab.ca" style="color:#6b5088;"><span><img style="width:25px; display:inline-block; margin-right:3px;" src="<?php echo $wgScriptPath . '/skins/Vector/images/collab/mini_wiki_icon.png'; ?>" alt="gccollab"></span><?php global $wgLang; if ($wgLang->getCode() == 'fr') echo  'Compte'; else echo 'Account'; ?></a></li>
				<li style="float:left; margin: 0px 2%;"><a href="https://gccollab.ca/" style="color:#6b5088;"><span><img style="width:25px; display:inline-block; margin-right:3px;" src="<?php echo $wgScriptPath . '/skins/Vector/images/collab/mini_collab_icon.png'; ?>" alt="gccollab"></span>Collab</a></li>
				<li style="float:left; margin: 0px 2%;"><a href="https://message.gccollab.ca/" style="color:#6b5088;"><span><img style="width:25px; display:inline-block; margin-right:3px;" src="<?php echo $wgScriptPath . '/skins/Vector/images/collab/message_icon.png'; ?>" alt="gccollab"></span>Message</a></li>
			</ul>
		</div>
		<div id="mw-page-base" class="noprint"></div>
		<div id="mw-head-base" class="noprint"></div>
		<div id="content" class="mw-body" role="main">
			<a id="top"></a>

			<?php
			if ( $this->data['sitenotice'] ) {
				?>
				<div id="siteNotice" class="mw-body-content"><?php $this->html( 'sitenotice' ) ?></div>
			<?php
			}
			?>
			<?php
			if ( is_callable( [ $this, 'getIndicators' ] ) ) {
				echo $this->getIndicators();
			}
			// Loose comparison with '!=' is intentional, to catch null and false too, but not '0'
			if ( $this->data['title'] != '' ) {
			?>
			<h1 id="firstHeading" class="firstHeading" lang="<?php $this->text( 'pageLanguage' ); ?>"><?php
				$this->html( 'title' )
			?></h1>
			<?php
			} ?>
			<?php $this->html( 'prebodyhtml' ) ?>
			<div id="bodyContent" class="mw-body-content">
				<?php
				if ( $this->data['isarticle'] ) {
					?>
					<div id="siteSub" class="noprint"><?php $this->msg( 'tagline' ) ?></div>
				<?php
				}
				?>
				<div id="contentSub"<?php $this->html( 'userlangattributes' ) ?>><?php
					$this->html( 'subtitle' )
				?></div>
				<?php
				if ( $this->data['undelete'] ) {
					?>
					<div id="contentSub2"><?php $this->html( 'undelete' ) ?></div>
				<?php
				}
				?>
				<?php
				if ( $this->data['newtalk'] ) {
					?>
					<div class="usermessage"><?php $this->html( 'newtalk' ) ?></div>
				<?php
				}
				?>
				<div id="jump-to-nav" class="mw-jump">
					<?php $this->msg( 'jumpto' ) ?>
					<a href="#mw-head"><?php
						$this->msg( 'jumptonavigation' )
					?></a><?php $this->msg( 'comma-separator' ) ?>
					<a href="#p-search"><?php $this->msg( 'jumptosearch' ) ?></a>
				</div>
				<?php
				$this->html( 'bodycontent' );

				if ( $this->data['printfooter'] ) {
					?>
					<div class="printfooter">
						<?php $this->html( 'printfooter' ); ?>
					</div>
				<?php
				}

				if ( $this->data['catlinks'] ) {
					$this->html( 'catlinks' );
				}

				if ( $this->data['dataAfterContent'] ) {
					$this->html( 'dataAfterContent' );
				}
				?>
				<div class="visualClear"></div>
				<?php $this->html( 'debughtml' ); ?>
			</div>
		</div>
		<div id="mw-navigation">
			<h2><?php $this->msg( 'navigation-heading' ) ?></h2>

			<div id="mw-head" style="top:35px;">
				<style>
					#app-brand-name:before{
						content: ''; display: block; position: absolute; left: 166px; top: 0; width: 0; height: 0; border-top: 20px solid transparent; border-bottom: 22px solid transparent; border-left: 20px solid #6D4E86; clear: both;
					}
				</style>
				<div id="app-brand-name"  style="background:#6D4E86; position:absolute; top:2px; clear:both; float:left; font-size:24px; color:white; padding:8px 59px 6px 62px;">Wiki</div>
				
				<?php $this->renderNavigation( 'PERSONAL' ); ?>
				<div id="left-navigation">
					<?php $this->renderNavigation( [ 'NAMESPACES', 'VARIANTS' ] ); ?>
				</div>
				<div id="right-navigation">
					<?php $this->renderNavigation( [ 'VIEWS', 'ACTIONS', 'SEARCH' ] ); ?>
				</div>
			</div>
			<div id="mw-panel" class="collab-wiki-nav" style="top:90px;">
				
				<div id="p-logo" role="banner" style="margin-bottom:40px;"><a class="mw-wiki-logo" href="<?php
					echo htmlspecialchars( $this->data['nav_urls']['mainpage']['href'] )
					?>" <?php
					echo Xml::expandAttributes( Linker::tooltipAndAccesskeyAttribs( 'p-logo' ) )
					?>>
					<img src="<?php global $wgLang; if ($wgLang->getCode() == 'fr') echo $wgScriptPath . '/skins/Vector/images/collab/collab_logo_fr.png'; else echo $wgScriptPath .'/skins/Vector/images/collab/collab_logo_en.png'; ?>" type="image/png" style="width:100%;">
				</a>
				</div>
				<?php $this->renderPortals( $this->data['sidebar'] ); ?>
			</div>
		</div>
		<div id="footer" role="contentinfo"<?php $this->html( 'userlangattributes' ) ?>>
			<?php
			foreach ( $this->getFooterLinks() as $category => $links ) {
				?>
				<ul id="footer-<?php echo $category ?>">
					<?php
					foreach ( $links as $link ) {
						?>
						<li id="footer-<?php echo $category ?>-<?php echo $link ?>"><?php $this->html( $link ) ?></li>
					<?php
					}
					?>
				</ul>
			<?php
			}
			?>
			<?php $footericons = $this->getFooterIcons( 'icononly' );
			if ( count( $footericons ) > 0 ) {
				?>
				<ul id="footer-icons" class="noprint">
					<?php
					foreach ( $footericons as $blockName => $footerIcons ) {
						?>
						<li id="footer-<?php echo htmlspecialchars( $blockName ); ?>ico">
							<?php
							foreach ( $footerIcons as $icon ) {
								echo $this->getSkin()->makeFooterIcon( $icon );
							}
							?>
						</li>
					<?php
					}
					?>
				</ul>
			<?php
			}
			?>
			
			<div style="clear:both"></div>
			<div id="app-brand-footer" style="border-top: 3px solid #6D4E86; bottom:0; width:100%; margin-top:5px;">
				<object type="image/svg+xml" tabindex="-1" role="img" data="<?php echo $wgScriptPath; ?>/skins/Vector/images/collab/wmms-alt.svg" aria-label="Symbol of the Government of Canada" style="height:33px; float:right; padding:10px 15px;"></object>
			</div>
		</div>
		<?php $this->printTrail(); ?>

	</body>
</html>
<?php
	}

	/**
	 * Render a series of portals
	 *
	 * @param array $portals
	 */
	protected function renderPortals( $portals ) {
		// Force the rendering of the following portals
		if ( !isset( $portals['SEARCH'] ) ) {
			$portals['SEARCH'] = true;
		}
		if ( !isset( $portals['TOOLBOX'] ) ) {
			$portals['TOOLBOX'] = true;
		}
		if ( !isset( $portals['LANGUAGES'] ) ) {
			$portals['LANGUAGES'] = true;
		}

		// split off some items from the toolbox
		if ( !isset( $portals['ACTIONS'] ) ) {
				$portals['ACTIONS'] = true;
		}
			
		$toolbox = $this->getToolbox();
		$actions = array();

		// next - stuff from the toolbox
		foreach ( array( 'upload', 'specialpages' ) as $action ) {
			if( isset($toolbox[$action]) ){
				$actions[$action] = $toolbox[$action];
				unset($toolbox[$action]);
			}
		}

		// move some toolbox items to the top
		$pageinfo = array();

		if ( isset( $toolbox['info'] ) ){
			$pageinfo['info'] = $toolbox['info'];
			unset($toolbox['info']);
		}
		
		
		$tmp = $toolbox['whatlinkshere'];
		unset($toolbox['whatlinkshere']);
		
		// now combine...
		$pageinfo = array_merge($pageinfo, $toolbox);
		$pageinfo['whatlinkshere'] = $tmp;
		

		// Render portals
		foreach ( $portals as $name => $content ) {
			if ( $content === false ) {
				continue;
			}

			// Numeric strings gets an integer when set as key, cast back - T73639
			$name = (string)$name;

			switch ( $name ) {
				case 'ACTIONS':			// split off from tools
					$this->renderPortal( 'tba', $actions, 'toolbox-actions' );
					break;
				case 'SEARCH':
					break;
				case 'TOOLBOX':
					$this->renderPortal( 'tb', $pageinfo, 'toolbox', 'SkinTemplateToolboxEnd' );
					break;
				case 'LANGUAGES':
					if ( $this->data['language_urls'] !== false ) {
						$this->renderPortal( 'lang', $this->data['language_urls'], 'otherlanguages' );
					}
					break;
				default:
					$this->renderPortal( $name, $content );
					break;
			}
		}
	}

	/**
	 * @param string $name
	 * @param array $content
	 * @param null|string $msg
	 * @param null|string|array $hook
	 */
	protected function renderPortal( $name, $content, $msg = null, $hook = null ) {
		if ( $msg === null ) {
			$msg = $name;
		}
		$msgObj = wfMessage( $msg );
		$labelId = Sanitizer::escapeId( "p-$name-label" );
		?>
		<div class="portal" role="navigation" id='<?php
		echo Sanitizer::escapeId( "p-$name" )
		?>'<?php
		echo Linker::tooltip( 'p-' . $name )
		?> aria-labelledby='<?php echo $labelId ?>'>
			<h3<?php $this->html( 'userlangattributes' ) ?> id='<?php echo $labelId ?>'><?php
				echo htmlspecialchars( $msgObj->exists() ? $msgObj->text() : $msg );
				?></h3>

			<div class="body">
				<?php
				if ( is_array( $content ) ) {
					?>
					<ul>
						<?php
						foreach ( $content as $key => $val ) {
							echo $this->makeListItem( $key, $val );
						}
						if ( $hook !== null ) {
							// Avoid PHP 7.1 warning
							$skin = $this;
							Hooks::run( $hook, [ &$skin, true ] );
						}
						?>
					</ul>
				<?php
				} else {
					// Allow raw HTML block to be defined by extensions
					echo $content;
				}

				$this->renderAfterPortlet( $name );
				?>
			</div>
		</div>
	<?php
	}

	/**
	 * Render one or more navigations elements by name, automatically reveresed
	 * when UI is in RTL mode
	 *
	 * @param array $elements
	 */
	protected function renderNavigation( $elements ) {
		// If only one element was given, wrap it in an array, allowing more
		// flexible arguments
		if ( !is_array( $elements ) ) {
			$elements = [ $elements ];
			// If there's a series of elements, reverse them when in RTL mode
		} elseif ( $this->data['rtl'] ) {
			$elements = array_reverse( $elements );
		}
		// Render elements
		foreach ( $elements as $name => $element ) {
			switch ( $element ) {
				case 'NAMESPACES':
					?>
					<div id="p-namespaces" role="navigation" class="vectorTabs<?php
					if ( count( $this->data['namespace_urls'] ) == 0 ) {
						echo ' emptyPortlet';
					}
					?>" aria-labelledby="p-namespaces-label">
						<h3 id="p-namespaces-label"><?php $this->msg( 'namespaces' ) ?></h3>
						<ul<?php $this->html( 'userlangattributes' ) ?>>
							<?php
							foreach ( $this->data['namespace_urls'] as $key => $item ) {
								echo "\t\t\t\t\t\t\t" . $this->makeListItem( $key, $item, [
									'vector-wrap' => true,
								] ) . "\n";
							}
							?>
						</ul>
					</div>
					<?php
					break;
				case 'VARIANTS':
					?>
					<div id="p-variants" role="navigation" class="vectorMenu<?php
					if ( count( $this->data['variant_urls'] ) == 0 ) {
						echo ' emptyPortlet';
					}
					?>" aria-labelledby="p-variants-label">
						<?php
						// Replace the label with the name of currently chosen variant, if any
						$variantLabel = $this->getMsg( 'variants' )->text();
						foreach ( $this->data['variant_urls'] as $item ) {
							if ( isset( $item['class'] ) && stripos( $item['class'], 'selected' ) !== false ) {
								$variantLabel = $item['text'];
								break;
							}
						}
						?>
						<h3 id="p-variants-label">
							<span><?php echo htmlspecialchars( $variantLabel ) ?></span>
						</h3>

						<div class="menu">
							<ul>
								<?php
								foreach ( $this->data['variant_urls'] as $key => $item ) {
									echo "\t\t\t\t\t\t\t\t" . $this->makeListItem( $key, $item ) . "\n";
								}
								?>
							</ul>
						</div>
					</div>
					<?php
					break;
				case 'VIEWS':
					?>
					<div id="p-views" role="navigation" class="vectorTabs<?php
					if ( count( $this->data['view_urls'] ) == 0 ) {
						echo ' emptyPortlet';
					}
					?>" aria-labelledby="p-views-label">
						<h3 id="p-views-label"><?php $this->msg( 'views' ) ?></h3>
						<ul<?php $this->html( 'userlangattributes' ) ?>>
							<?php
							foreach ( $this->data['view_urls'] as $key => $item ) {
								echo "\t\t\t\t\t\t\t" . $this->makeListItem( $key, $item, [
									'vector-wrap' => true,
									'vector-collapsible' => true,
								] ) . "\n";
							}
							?>
						</ul>
					</div>
					<?php
					break;
				case 'ACTIONS':
					?>
					<div id="p-cactions" role="navigation" class="vectorMenu<?php
					if ( count( $this->data['action_urls'] ) == 0 ) {
						echo ' emptyPortlet';
					}
					?>" aria-labelledby="p-cactions-label">
						<h3 id="p-cactions-label"><span><?php
							$this->msg( 'vector-more-actions' )
						?></span></h3>

						<div class="menu">
							<ul<?php $this->html( 'userlangattributes' ) ?>>
								<?php
								foreach ( $this->data['action_urls'] as $key => $item ) {
									echo "\t\t\t\t\t\t\t\t" . $this->makeListItem( $key, $item ) . "\n";
								}
								?>
							</ul>
						</div>
					</div>
					<?php
					break;
				case 'PERSONAL':
					?>
					<div id="p-personal" role="navigation" class="<?php
					if ( count( $this->data['personal_urls'] ) == 0 ) {
						echo ' emptyPortlet';
					}
					?>" aria-labelledby="p-personal-label">
						<h3 id="p-personal-label"><?php $this->msg( 'personaltools' ) ?></h3>
						<ul<?php $this->html( 'userlangattributes' ) ?>>
							<?php
							$notLoggedIn = '';

							if ( !$this->getSkin()->getUser()->isLoggedIn() &&
								User::groupHasPermission( '*', 'edit' )
							) {
								$notLoggedIn =
									Html::rawElement( 'li',
										[ 'id' => 'pt-anonuserpage' ],
										$this->getMsg( 'notloggedin' )->escaped()
									);
							}

							$personalTools = $this->getPersonalTools();

							$langSelector = '';
							if ( array_key_exists( 'uls', $personalTools ) ) {
								$langSelector = $this->makeListItem( 'uls', $personalTools[ 'uls' ] );
								unset( $personalTools[ 'uls' ] );
							}

							if ( !$this->data[ 'rtl' ] ) {
								echo $langSelector;
								echo $notLoggedIn;
							}

							foreach ( $personalTools as $key => $item ) {
								echo $this->makeListItem( $key, $item );
							}

							if ( $this->data[ 'rtl' ] ) {
								echo $notLoggedIn;
								echo $langSelector;
							}
							?>
						</ul>
					</div>
					<?php
					break;
				case 'SEARCH':
					?>
					<div id="p-search" role="search">
						<h3<?php $this->html( 'userlangattributes' ) ?>>
							<label for="searchInput"><?php $this->msg( 'search' ) ?></label>
						</h3>

						<form action="<?php $this->text( 'wgScript' ) ?>" id="searchform">
							<div<?php echo $this->config->get( 'VectorUseSimpleSearch' ) ? ' id="simpleSearch"' : '' ?>>
							<?php
							echo $this->makeSearchInput( [ 'id' => 'searchInput' ] );
							echo Html::hidden( 'title', $this->get( 'searchtitle' ) );
							/* We construct two buttons (for 'go' and 'fulltext' search modes),
							 * but only one will be visible and actionable at a time (they are
							 * overlaid on top of each other in CSS).
							 * * Browsers will use the 'fulltext' one by default (as it's the
							 *   first in tree-order), which is desirable when they are unable
							 *   to show search suggestions (either due to being broken or
							 *   having JavaScript turned off).
							 * * The mediawiki.searchSuggest module, after doing tests for the
							 *   broken browsers, removes the 'fulltext' button and handles
							 *   'fulltext' search itself; this will reveal the 'go' button and
							 *   cause it to be used.
							 */
							echo $this->makeSearchButton(
								'fulltext',
								[ 'id' => 'mw-searchButton', 'class' => 'searchButton mw-fallbackSearchButton' ]
							);
							echo $this->makeSearchButton(
								'go',
								[ 'id' => 'searchButton', 'class' => 'searchButton' ]
							);
							?>
							</div>
						</form>
					</div>
					<?php

					break;
			}
		}
	}

	/**
	 * @inheritDoc
	 */
	public function makeLink( $key, $item, $options = [] ) {
		$html = parent::makeLink( $key, $item, $options );
		// Add an extra wrapper because our CSS is weird
		if ( isset( $options['vector-wrap'] ) && $options['vector-wrap'] ) {
			$html = Html::rawElement( 'span', [], $html );
		}
		return $html;
	}

	/**
	 * @inheritDoc
	 */
	public function makeListItem( $key, $item, $options = [] ) {
		// For fancy styling of watch/unwatch star
		if (
			$this->config->get( 'VectorUseIconWatch' )
			&& ( $key === 'watch' || $key === 'unwatch' )
		) {
			$item['class'] = rtrim( 'icon ' . $item['class'], ' ' );
			$item['primary'] = true;
		}

		// Add CSS class 'collapsible' to links which are not marked as "primary"
		if (
			isset( $options['vector-collapsible'] ) && $options['vector-collapsible']
			&& !( isset( $item['primary'] ) && $item['primary'] )
		) {
			$item['class'] = rtrim( 'collapsible ' . $item['class'], ' ' );
		}

		// We don't use this, prevent it from popping up in HTML output
		unset( $item['redundant'] );

		return parent::makeListItem( $key, $item, $options );
	}
}
