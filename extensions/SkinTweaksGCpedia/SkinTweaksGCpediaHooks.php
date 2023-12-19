<?php
/**
 * CSS extension - A parser-function for adding CSS to articles via file,
 * article or inline rules.
 */

class SkinTweaksGCpediaHooks {
	/**
	 * @param Skin $skin
	 * @param &$bar
	 * @return bool true
	 */
	public static function onSidebarBeforeOutput( Skin $skin, &$bar ) {
		$actions = [];
        foreach ( array( 'upload', 'specialpages' ) as $action ) {
			if( isset($bar['TOOLBOX'][$action]) ){
				$actions[$action] = $bar['TOOLBOX'][$action];
				unset($bar['TOOLBOX'][$action]);
			}
		}
		$bar['sidebar-actions'] = $actions;

		return;
	}


    public static function onBeforePageDisplay( OutputPage $out, Skin $skin ) {
        $out->addModuleStyles( [ 'ext.skintweaksgcpedia.styles' ] );
        SkinTweaksGCpediaHooks::addMetaTags( $out, $skin );

        return;
    }


    public static function onAfterFinalPageOutput( $output ) {
		$langMessages = [
			"gcpedia" => wfMessage('gcpedia')->text(),
			"wet:gcdirectoryLink" => wfMessage('wet:gcdirectoryLink')->text(),
			"wet:barDirectory" => wfMessage('wet:barDirectory')->text(),
			"wet:gcintranetLink" => wfMessage('wet:gcintranetLink')->text(),
			"wet:gcconnexLink" => wfMessage('wet:gcconnexLink')->text(),
			"wet:gccollabLink" => wfMessage('wet:gccollabLink')->text(),
			"topbar:langlink" => wfMessage('topbar:langlink')->text(),
		];
		$searchbox = SkinTweaksGCpediaHooks::outputSearch();
        $fipHeader = <<<EOT
<header role="banner">
    <div id="app-brand">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-2 col-md-2 col-xs-7">
                    <div class="app-name">
                    <a href="/">
                        <span><span class="bold-gc">{$langMessages['gcpedia']}</span>
                    </a>
                    </div>
                    
                </div>
                <div class="col-lg-6 col-md-5 col-sm-7 hidden-sm hidden-xs">
                    <ul id="tool-link" class="pull-left list-unstyled mrgn-bttm-0">

						<li class="pull-left tool-link">
                        	<a href="{$langMessages['wet:gcdirectoryLink']}">
                            <span class="bold-gc">GC</span>{$langMessages['wet:barDirectory']}</a>

                    	</li>

	                    <li class="pull-left tool-link">
	                        <a href="{$langMessages['wet:gcintranetLink']}">
	                        <span class="bold-gc">GC</span>intranet</a>
	                        
	                    </li>

	                    <li class="pull-left tool-link">
	                        <a href="{$langMessages['wet:gcconnexLink']}">
	                        <span class="bold-gc">GC</span>connex</a>
	                        
	                    </li>
                        
                        <li class="pull-left tool-link">
	                        <a href="{$langMessages['wet:gccollabLink']}">
	                        <span class="bold-gc">GC</span>collab</a>
	                        
	                    </li>
	                    
                    </ul>
                </div>

                <div id="wb-lng" class="visible-md visible-lg text-right col-sm-1">
                	<div class="col-md-12">
                		<ul class="list-inline margin-bottom-none">
                			<li>{$langMessages['topbar:langlink']}</li>
                		</ul>
                	</div>
                </div>
				$searchbox
            </div>
        </div>
        
    </div>
</header>
		
EOT;

$fipFooter = <<<EOT
<div style="clear:both"></div>
<footer id="wb-info" class="visible-sm visible-md visible-lg wb-navcurr wb-navcurr-inited" role="contentinfo">
<div class="brand">
	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-6 visible-sm visible-xs tofpg">
				<a href="#content">Top of Page <span class="glyphicon glyphicon-chevron-up"></span></a>
			</div>
			<div class="col-xs-6 col-md-12 text-right">
				<object type="image/svg+xml" tabindex="-1" role="img" data="extensions/SkinTweaksGCpedia/resources/images/wmms-alt.svg" aria-label="Symbol of the Government of Canada"></object>
			</div>
		</div>
	</div>
</div>
</footer>
EOT;
	
        $out = ob_get_clean();
        // change final html in $out
        ob_start();
        echo $fipHeader . $out . $fipFooter;
        return;
    }





    public static function addMetaTags( OutputPage $out, Skin $skin ) {
		$title = $skin->getTitle();
		
		$category_array = $out->getCategories();
		$category_string = (is_array($category_array)) ? implode(",", $category_array) : '';
		$timestamp = $out->getRevisionTimestamp();
		$timestamp = isset($timestamp) ? preg_replace( '/(\d{4})(\d{2})(\d{2})(\d{2})(\d{2})(\d{2})/', "$1-$2-$3 $4:$5:$6", $timestamp) : '';
		$language =  $_GET['uselang'] ?? $_GET['setlang'] ?? 'en';
		$namespace = $title->getNsText();
		
		$out->addMeta( 'platform', 'gcpedia' );
		$out->addMeta( 'dcterms.language', $language );
		$out->addMeta( 'dcterms.title', $title->getFullText() );
		$out->addMeta( 'dcterms.type', $namespace );
		$out->addMeta( 'dcterms.modified', $timestamp );
		$out->addMeta( 'dcterms.description', strip_tags($out->mBodytext) );

		if ( $title->inNamespace(NS_USER) )
			$out->addMeta( 'dcterms.keywords', str_replace( '.', ' ', $title->getRootText() ) );
	}

	/**
	* Outputs the federated search form
	*/
   private static function outputSearch() {
    global $wgLang;
    if ($wgLang->getCode() == 'fr')
      $lang3Code = 'fra';
    else
      $lang3Code = 'eng';

	$searchBoxPlaceholder = wfMessage( 'searchsuggest-search-tools' );
    
	return <<<EOT
	   <div class="col-sm-5 col-lg-3 col-md-4 col-xs-5 text-right"><section id="wb-srch" class="text-right">
<h2>Search</h2>
<form action="http://intranet.canada.ca/search-recherche/query-recherche-$lang3Code.aspx" method="get" name="cse-search-box" role="search" class="form-inline">
<div class="form-group">
<label for="wb-srch-q" class="wb-inv">Search website</label>
<input id="search" list="wb-srch-q-ac" class="wb-srch-q form-control" name="q" type="search" value="" size="21" maxlength="150" placeholder="$searchBoxPlaceholder">
<datalist id="wb-srch-q-ac">
<!--[if lte IE 9]><select><![endif]-->
<!--[if lte IE 9]></select><![endif]-->
</datalist>
			   <!-- hidden forms for federated search -->
			   <input type="hidden" name="a"  value="s">
			   <input type="hidden" name="s"  value="2">
			   <input type="hidden" name="chk3"  value="True">
</div>
<div class="form-group submit">
<button type="submit" id="wb-srch-sub" class="btn btn-small" name="wb-srch-sub"><span class="glyphicon-search glyphicon"></span><span class="wb-inv">Search</span></button>
</div>
</form>
</section></div>
EOT;
	}
}