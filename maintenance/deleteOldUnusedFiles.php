<?php
/**
**
** Delete files and related pages, etc identified by the checkOldUnusedFiles script
**
**/


require_once( dirname( __FILE__ ) . '/Maintenance.php' );

class DeleteOldUnusedFiles extends Maintenance {
    public function __construct() {
        parent::__construct();
        /*$this->addOption( "sizebound", "The lower size bound in Mb on files to be checked (filter out smaller files)", true, true );*/
        $this->mDescription = "Delete unused files";
    }
   
    public function execute() {
        
       $this->output( "Started\n" );
        // set up files
        //$inlog = fopen( dirname( __FILE__ ) . '/oldUnusedFilesLog.txt', 'r' );            // input log file
        $inlines = file( dirname( __FILE__ ) . '/oldUnusedFilesLog.txt', FILE_IGNORE_NEW_LINES);        // read filename lines into an array
		
        $outlog = fopen( dirname( __FILE__ ) . '/deletedOldUnusedFilesLog.txt', 'w' );    // log of deletion progress
		
		$this->output( "Started\n" );
       
		$dbr = wfGetDB( DB_SLAVE );
		
        foreach ( $inlines as $filename ){
            // generate title object required by the deletion function
            $t = Title::makeTitle( NS_IMAGE, $filename );
           
            $this->deleteFilePermanently( $t );			// delete everything about the file
			
			// log the deletion
            $this->output( $filename. "  " . $t->getArticleID() . "\n" );	
			fwrite($outlog, $filename ."\n");// add filename to progress log now that it's deleted
        }

    }

    function deleteFilePermanently( $title ) {
        global $wgOut;
     
        $ns = NS_IMAGE;            //$title->getNamespace();        // Since we're only deleting images, this is always the case
        $t = $title->getDBkey();
        $id = $title->getArticleID();
        $cats = $title->getParentCategories();
     
        $dbw = wfGetDB(DB_MASTER);
     
        $dbw->begin();
     
        ####
        ## First delete entries, which are in direct relation with the page:
        ####

        # delete redirect...
        $dbw->delete('redirect', array ('rd_from' => $id), __METHOD__);
     
        # delete external link...
        $dbw->delete('externallinks', array ('el_from' => $id), __METHOD__);
     
        # delete language link...
        $dbw->delete('langlinks', array ('ll_from' => $id), __METHOD__);
     
        # delete search index...
        $dbw->delete('searchindex', array ('si_page' => $id), __METHOD__);
     
        # Delete restrictions for the page
        $dbw->delete('page_restrictions', array ('pr_page' => $id), __METHOD__);
     
        # Delete page Links
        $dbw->delete('pagelinks', array ('pl_from' => $id), __METHOD__);
     
        # delete category links
        $dbw->delete('categorylinks', array ('cl_from' => $id), __METHOD__);
     
        # delete template links
        $dbw->delete('templatelinks', array ('tl_from' => $id), __METHOD__);
     
        # read text entries for all revisions and delete them.
        $res = $dbw->select('revision', 'rev_text_id', "rev_page=$id");
     
        while ($row = $dbw->fetchObject($res)) {
            $value = $row->rev_text_id;
            $dbw->delete('text', array ('old_id' => $value), __METHOD__);
        }
     
        # In the table 'revision' : Delete all the revision of the page where 'rev_page' = $id
        $dbw->delete('revision', array ('rev_page' => $id), __METHOD__);
     
        # delete image links
        $dbw->delete('imagelinks', array ('il_from' => $id), __METHOD__);
     
        ####
        ## then delete entries which are not in direct relation with the page:
        ####

        # Clean up recentchanges entries...
        $dbw->delete('recentchanges', array (
                'rc_namespace' => $ns,
                'rc_title' => $t
        ), __METHOD__);
     
        # read text entries for all archived pages and delete them.
        $res = $dbw->select('archive', 'ar_text_id', array (
                'ar_namespace' => $ns,
                'ar_title' => $t
        ));
     
        while ($row = $dbw->fetchObject($res)) {
                $value = $row->ar_text_id;
                $dbw->delete('text', array ('old_id' => $value), __METHOD__);
        }
     
        # Clean archive entries...
        $dbw->delete('archive', array (
                'ar_namespace' => $ns,
                'ar_title' => $t
        ), __METHOD__);
     
        # Clean up log entries...
        $dbw->delete('logging', array (
                'log_namespace' => $ns,
                'log_title' => $t
        ), __METHOD__);
     
        # Clean up watchlist...
        $dbw->delete('watchlist', array (
                'wl_namespace' => $ns,
                'wl_title' => $t
        ), __METHOD__);
     
        # In the table 'page' : Delete the page entry
        $dbw->delete('page', array ('page_id' => $id), __METHOD__);
     
        ####
        ## If the article belongs to a category, update category counts
        ####
        if (!empty($cats)) {
                foreach ($cats as $parentcat => $currentarticle) {
                        //$catname = split(':', $parentcat, 2);        split is depricated, using explode instead
                        $catname = explode(':', $parentcat, 2);
                        $cat = Category::newFromName($catname[1]);
                        $cat->refreshCounts();
                }
        }
     
        ####
        ## If an image is beeing deleted, some extra work needs to be done
        ####
        if ($ns == NS_IMAGE) {
     
                $file = wfFindFile( $t );
    		$this->output( ($file==false) ? " false " : " file " );
     
                if ($file) {
    		$this->output( $file->fileExists ." \n " );
    		
                    # Get all filenames of old versions:
                    $fields = OldLocalFile::selectFields();
                    $res = $dbw->select('oldimage', $fields, array ('oi_name' => $t));
     
                    while ($row = $dbw->fetchObject($res)) {
                        $oldLocalFile = OldLocalFile::newFromRow($row, $file->repo);
                        $path = $oldLocalFile->getArchivePath() . '/' . $oldLocalFile->getArchiveName();
    					$path = str_ireplace( "mwstore://local-backend/local-public", "../images", $path );		// fix the path
    		$this->output( $file->getFullUrl() . "\n" );
                        try { unlink($path); }
                        catch (Exception $e) { $wgOut->addHTML($e->getMessage()); }
                    }
     
                    //$path = $file->getPath();
    			$path = str_ireplace( "mwstore://local-backend/local-public", "../images", $file->getPath() );
     
                try {
                        $file->purgeThumbnails();
                        unlink($path);
                } catch (Exception $e) { $wgOut->addHTML($e->getMessage()); }
            }
     
            # clean the filearchive for the given filename:
            $dbw->delete('filearchive', array ('fa_name' => $t), __METHOD__);
     
            # Delete old db entries of the image:
            $dbw->delete('oldimage', array ('oi_name' => $t), __METHOD__);
     
            # Delete archive entries of the image:
            $dbw->delete('filearchive', array ('fa_name' => $t), __METHOD__);
     
            # Delete image entry:
            $dbw->delete('image', array ('img_name' => $t), __METHOD__);
     
            $dbw->commit();
     
            $linkCache = LinkCache::singleton();
            $linkCache->clear();
        }
        return true;
    }
}

$maintClass = "DeleteOldUnusedFiles";
require_once( RUN_MAINTENANCE_IF_MAIN );

?>