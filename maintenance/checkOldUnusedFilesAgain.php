<?php
/**
* Looks for files not linked to or mentioned in any way in a current version of any wiki page.
* 
*/


require_once( dirname( __FILE__ ) . '/Maintenance.php' );

class CheckUnusedFiles extends Maintenance {
	public function __construct() {
		parent::__construct();
		$this->mDescription = "Look for unused files";
	}

	public function execute() {
		$now = date('Y/m/d H:i:s');		
		$this->output( "Starting Old Unused files list script at " . $now ."\n" );
		$this->output( "Fetching file list...\n" );
		$dbr = wfGetDB( DB_SLAVE );
		$result = $dbr->select(
			array( 'image', 'imagelinks', 'page', 'categorylinks' ),
			array( 'img_name' ),
			array( 'cl_to = "Orphaned_file_-_fichier_orphelin" AND il_to IS NULL' ),// where the files are older than X days
			__METHOD__,
			array(),
			array('imagelinks' => array (
					'LEFT JOIN', 'il_to = img_name' ), 
				'page' => array(
					'LEFT JOIN', 'page_title = img_name' ),
				'categorylinks' => array(
					'LEFT JOIN', 'cl_from = page_id' ) ));
			
		$count = $result->numRows();
		$this->output( "Found $count total unused files:\n\n" );
		
		$unused['num'] = 0;
		$log = fopen( dirname( __FILE__ ) . '/checkOldUnusedFilesQueryList.txt', 'w' );
		
		// start time
		$tstart = time();
		
		foreach ( $result as $file ) {
			$unused['num']++;
			fwrite( $log, $file->img_name . "\r\n" );
		}
		$this->output( "\n\n". $unused['num'] ." unused files \nScript running time: "
						. (time() - $tstart) . "s, or " . ( time() - $tstart ) / 60 . "min" );
		fwrite( $log, "\r\n". $unused['num'] ." unused files \r\nScript running time: " 
						. (time() - $tstart) . "s, or " . ( time() - $tstart ) / 60 . "min" );
		$this->output( "\ndone.\n" );
		
		fclose($log);
	}
}

$maintClass = "CheckUnusedFiles";
require_once( RUN_MAINTENANCE_IF_MAIN );

?>