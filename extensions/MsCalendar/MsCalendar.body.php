<?php

class MsCalendar {

	static function updateDatabase( DatabaseUpdater $updater ) {
		global $wgDBprefix;
		$updater->addExtensionTable( $wgDBprefix . 'mscal_list', __DIR__ . '/MsCalendar.sql' );
		$updater->addExtensionTable( $wgDBprefix . 'mscal_names', __DIR__ . '/MsCalendar.sql' );
		$updater->addExtensionTable( $wgDBprefix . 'mscal_content', __DIR__ . '/MsCalendar.sql' );
		return true;
	}

	static function setHook( Parser $parser ) {
		$parser->setHook( 'MsCalendar', 'MsCalendar::render' );
		return true;
	}

	static function render( $input, array $args, Parser $parser, PPFrame $frame ) {
		global $wgOut;

		if ( $input ) {
			$name = $input;
		} else if ( array_key_exists( 'name', $args ) ) {
			$name = $args['name']; // For backwards compatibility
		} else {
			return wfMessage( 'msc-noname' );
		}

		$sort = 'abc'; // Default
		if ( array_key_exists( 'sort', $args ) ) {
			$sort = $args['sort'];
		}

		// Get the id of the calendar
		$dbr = wfGetDB( DB_SLAVE );
		$result = $dbr->select( 'mscal_names', array( 'ID' ), array( 'Cal_Name' => $name ));
		$row = $dbr->fetchRow( $result );
		if ( $row ) {
			$id = $row['ID'];
		} else {
			$dbw = wfGetDB( DB_MASTER );
			$dbw->insert(
				'mscal_names',
				array(
					'ID' => null,
					'Cal_Name' => $name,
				)
			);
			$id = $dbw->insert_id;
		}

		$parser->disableCache();
		$wgOut->addModules( 'ext.MsCalendar' );
		$output = '<div class="ms-calendar-header">';
		$output .= '<div class="righty">';
		$output .= '<span class="ms-calendar-prev">&#10094;</span>';
		$output .= '<span class="ms-calendar-year-month"><span class="ms-calendar-month"></span></span>';
		$output .= '<span class="ms-calendar-next">&#10095;</span>';
		$output .= '<span class="ms-calendar-prev-year">&#10094;</span>';
		$output .= '<span class="ms-calendar-year-year"><span class="ms-calendar-year"></span></span>';
		$output .= '<span class="ms-calendar-next-year">&#10095;</span>';
		$output .= '</div>';
		$output .= '<span class="ms-calendar-current" title="' . wfMessage( 'msc-todaylabel' )->escaped() . '">' . wfMessage( 'msc-today' )->parse() . '</span>';
		$output .= '</div>';
		$output .= '<div class="fc-calendar-container" data-calendar-id="' . htmlspecialchars( $id ) . '" data-calendar-name="' . htmlspecialchars( $name ) . '" data-calendar-sort="' . htmlspecialchars( $sort ) . '"></div>';
		return $output;
	}

	static function getMonth( $month, $year, $calendarId, $calendarSort ) {
		if ( $calendarId === 0 ) {
			return false;
		}

		$vars = array();
		$dbr = wfGetDB( DB_SLAVE );
		$result = $dbr->select(
			array( 'a' => 'mscal_list', 'b' => 'mscal_content' ),
			array(
				"DATE_FORMAT(Date, '%m') as monat", "YEAR(date) as jahr", "DAY(date) as tag",
				"DATE_FORMAT(Date, '%m-%d-%Y') as Datum",
				'Text_ID', 'b.ID', 'Text', 'Duration',
				'Start_Date', 'Yearly', 'Day_of_Set',
			),
			array(
				'MONTH(Date)' => $month,
				'YEAR(Date)'  => $year,
				'a.Text_ID = b.ID',
				'a.Cal_ID'    => $calendarId,
			),
			__METHOD__,
			array( 'ORDER BY' => ($calendarSort == 'id') ? 'ID' : 'Text' )
		);
		while ( $row = $dbr->fetchRow( $result ) ) {
			if ( $row['jahr'] == $year)	{
				$vars[ $row['Datum'] ][] = array(
					'ID' => $row['Text_ID'],
					'Text' => $row['Text'],
					'Duration' => $row['Duration'],
					'Day' => $row['Day_of_Set'],
					'Yearly' => $row['Yearly']
				);
			} else if ( $row['Yearly'] == 1 ) {
				$new_date = $row['monat'] . '-' . $row['tag'] . '-' . $year;
				$vars[ $new_date ][] = array(
					'ID' => $row['Text_ID'],
					'Text' => $row['Text'],
					'Duration' => $row['Duration'],
					'Day' => $row['Day_of_Set'],
					'Yearly' => $row['Yearly']
				);
			}
		}
		$dbr->freeResult( $result );
		return json_encode( $vars );
	}

	static function saveNew( $calendarId, $date, $title, $eventId, $duration, $yearly ) {
		$newDate = date( 'Y-m-d', strtotime( $date ) );
		$newDate2 = date( 'm-d-Y', strtotime( $date ) );

		$dbw = wfGetDB( DB_MASTER );
		$dbw->insert(
			'mscal_content',
			array(
				'ID'         => null,
				'Text'       => $title,
				'Start_Date' => $newDate,
				'Duration'   => $duration,
				'Yearly'     => $yearly,
			)
		);

		$result = $dbw->select( 'mscal_content', array( 'MAX(ID) as maxid' ), '');
		$row = $dbw->fetchRow( $result );
		$maxId = $row['maxid'];

		for ( $i = 0; $i < $duration; $i++ ) {
			$addDate = date( 'Y-m-d', strtotime( $newDate. ' + ' . $i . ' days' ) );
			$dbw->insert(
				'mscal_list',
				array(
					'ID'         => null,
					'Date'       => $addDate,
					'Text_ID'    => $maxId,
					'Day_of_Set' => $i + 1,
					'Cal_ID'     => $calendarId,
				)
			);
		}

		$vars[ $newDate2 ][] = array(
			'ID' => $maxId,
			'Text' => $title,
			'Duration' => $duration,
			'Yearly' => $yearly
		);
		return json_encode( $vars );
	}

	static function update( $calendarId, $date, $title, $eventId, $duration, $yearly ) {
		$newDate = date( 'Y-m-d', strtotime( $date ) );
		$newDate2 = date( 'm-d-Y', strtotime( $date ) );

		$dbw = wfGetDB( DB_MASTER );
		$dbw->update(
			'mscal_content',
			array(
				'Text'       => $title,
				'Start_Date' => $newDate,
				'Duration'   => $duration,
				'Yearly'     => $yearly,
			),
			array( 'ID' => $eventId )
		);

		$dbw->delete( 'mscal_list', array( 'Text_ID' => $eventId ));

		for ( $i = 0; $i < $duration; $i++ ) {
			$addDate = date( 'Y-m-d', strtotime( $newDate. ' + ' . $i . ' days' ) );
			$dbw->insert(
				'mscal_list',
				array(
					'ID'         => null,
					'Date'       => $addDate,
					'Text_ID'    => $eventId,
					'Day_of_Set' => $i + 1,
					'Cal_ID'     => $calendarId,
				)
			);
		}

		$data[ $newDate2 ][] = array(
			'ID' => $eventId,
			'Text' => $title,
			'Duration' => $duration,
			'Yearly' => $yearly
		);
		return json_encode( $data );
	}

	static function remove( $calendarId, $date, $title, $eventId, $duration, $yearly ) {
		$newDate = date( 'm-d-Y', strtotime( $date ) );
		$newDate2 = date( 'm-d-Y', strtotime( $date ) );

		$dbw = wfGetDB( DB_MASTER );
		$dbw->delete( 'mscal_content', array( 'ID' => $eventId ));
		$dbw->delete( 'mscal_list', array( 'Text_ID' => $eventId ));

		$data[ $newDate2 ][] = array(
			'ID' => $eventId,
			'Text' => $title,
			'Duration' => $duration,
			'Yearly' => $yearly
		);
		return json_encode( $data );
	}
}
