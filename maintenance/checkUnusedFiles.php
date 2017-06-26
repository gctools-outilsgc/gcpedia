<?php
/**
* Looks for files not linked to or mentioned in any way in a current version of any wiki page.
* 
*/


require_once( dirname( __FILE__ ) . '/Maintenance.php' );

class CheckUnusedFiles extends Maintenance {
	public function __construct() {
		parent::__construct();
		$this->addOption( "bound", "The lower bound in Mb on files to be checked (filter smaller files)", true, true );
		$this->mDescription = "Look for unused files";
	}

	public function execute() {
		$this->output( "Fetching file list...\n" );
		$dbr = wfGetDB( DB_SLAVE );
		$result = $dbr->select(
			array( 'image' ),
			array( 'img_name', 'img_size' ) );

		$count = $result->numRows();
		$this->output( "Found $count total files.\n" .
						"Looking for unused files:\n\n" );	
		
		$unused['num'] = 0;
		$unused['size'] = 0;
		$log = fopen( dirname( __FILE__ ) . '/checkUnusedFilesLog.txt', 'w' );
		
		// start time
		$tstart = time();
		
		foreach ( $result as $file ) {
			if ( $file->img_size > $this->getOption( 'bound' ) * (1024*1024) ) {
				$this->output( (int)( $file->img_size / (1024*1024) ) . "MB\n" );
				$used = $dbr->query( 'SELECT * FROM ' . $dbr->tableName('page') . ' LEFT JOIN ' . $dbr->tableName('revision') . ' ON page_latest = rev_id LEFT JOIN ' . $dbr->tableName('text') . ' ON rev_text_id = old_id WHERE CONVERT( old_text USING latin1) COLLATE latin1_swedish_ci LIKE"%' . $file->img_name .'%"' );
				if ( $used->numRows() < 1 ) {
					$unused['num']++;
					$unused['size'] += $file->img_size;
					$this->output( $file->img_name . "\n" );
					fwrite( $log, $file->img_name . "\r\n" );
				}
			}
		}
		$this->output( "\n\n". $unused['num'] ." unused files taking up ". (int)( $unused['size'] / (1024*1024) ) ."MB \nScript running time: "
						. (time() - $tstart) . "s, or " . ( time() - $tstart ) / 60 . "min" );
		fwrite( $log, "\r\n". $unused['num'] ." unused files taking up ". (int)( $unused['size'] / (1024*1024) ) ."MB \r\nScript running time: " 
						. (time() - $tstart) . "s, or " . ( time() - $tstart ) / 60 . "min" );
		$this->output( "\ndone.\n" );
		
		fclose($log);
	}
}

$maintClass = "CheckUnusedFiles";
require_once( RUN_MAINTENANCE_IF_MAIN );

?>