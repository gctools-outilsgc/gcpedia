/**
 * jquery.calendario.js v1.0.0
 * http://www.codrops.com
 *
 * Licensed under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
 * 
 * Copyright 2012, Codrops
 * http://www.codrops.com
 */
;( function( $, window, undefined ) {
	
	'use strict';

	$.Calendario = function( options, element ) {
		
		this.$el = $( element );
		this._init( options );
		
	};

	// the options
	$.Calendario.defaults = {
		/*
		you can also pass:
		month : initialize calendar with this month (1-12). Default is today.
		year : initialize calendar with this year. Default is today.
		caldata : initial data/content for the calendar.
		caldata format:
		{
			'MM-DD-YYYY' : 'HTML Content',
			'MM-DD-YYYY' : 'HTML Content',
			'MM-DD-YYYY' : 'HTML Content'
			...
		}
		*/
		weeks : mw.msg('msc-days').split(","),
		weekabbrs : [ 'Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat' ],
		months : mw.msg('msc-months').split(","),
		monthabbrs : [ 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec' ],
		// choose between values in options.weeks or options.weekabbrs
		displayWeekAbbr : false,
		// choose between values in options.months or options.monthabbrs
		displayMonthAbbr : false,
		// left most day in the calendar
		// 0 - Sunday, 1 - Monday, ... , 6 - Saturday
		startIn : 1,
		onEventClick : function( $el, dateProperties ) { return false; },
		onAddEventClick : function( $el, dateProperties ) { return false; }
		
	};

	$.Calendario.prototype = {

		_init : function( options ) {
			
			// options
			this.options = $.extend( true, {}, $.Calendario.defaults, options );

			this.today = new Date();
			this.month = ( isNaN( this.options.month ) || this.options.month == null) ? this.today.getMonth() : this.options.month - 1;
			this.year = ( isNaN( this.options.year ) || this.options.year == null) ? this.today.getFullYear() : this.options.year;
			this.caldata = this.options.caldata || {};
			this._generateTemplate();
			this._initEvents();

		},
		_initEvents : function() {

			var self = this;
/*
			this.$el.on( 'click.calendario', 'div.fc-row > div', function() {

				var $cell = $( this ),
					idx = $cell.index(),
					$content = $cell.children( 'div' ),
					dateProp = {
						day : $cell.children( 'span.fc-date' ).text(),
						event : $cell.find( 'span.event' ).text(),
						
						month : self.month + 1,
						monthname : self.options.displayMonthAbbr ? self.options.monthabbrs[ self.month ] : self.options.months[ self.month ],
						year : self.year,
						weekday : idx + self.options.startIn,
						weekdayname : self.options.weeks[ idx + self.options.startIn ]
					};

				if( dateProp.day ) {
					self.options.onDayClick( $cell, $content, dateProp );
				};
				
				if( dateProp.event ) {
					self.options.onEventClick( $cell, $content, dateProp );
				}

			} );
			*/
			this.$el.on( 'click.calendario', 'div.fc-row > div > div span.event', function() {
				
				var $cell = $( this ),
					idx = $cell.index(),
					dateProp = {
						day : $cell.parent().parent().find( '.fc-date' ).text(),
						date : $cell.parent().parent().find( '.fc-date' ).attr('date'),
						dateger : $cell.parent().parent().find( '.fc-date' ).attr('dateger'),
						event : $cell.text(),
						event_id : $cell.attr('event_id'),
						duration : $cell.attr('duration'),
						day_of_set : $cell.attr('day'),
						yearly: $cell.attr('yearly'),
						month : self.month + 1,
						monthname : self.options.displayMonthAbbr ? self.options.monthabbrs[ self.month ] : self.options.months[ self.month ],
						year : self.year,
						weekday : idx + self.options.startIn,
						weekdayname : self.options.weeks[ idx + self.options.startIn ]
					};

				
				self.options.onEventClick( $cell, dateProp );
			});
			
			
			this.$el.on( 'click.calendario', 'div.fc-row > div > span.add_event', function() {
				
				var $cell = $( this ),
					dateProp = {
						date : $cell.parent().find( '.fc-date' ).attr('date'),
						dateger : $cell.parent().find( '.fc-date' ).attr('dateger')
					};
				self.options.onAddEventClick( $cell, dateProp);
			});

		},
		// Calendar logic based on http://jszen.blogspot.pt/2007/03/how-to-build-simple-calendar-with.html
		_generateTemplate : function( callback ) {

			var head = this._getHead(),
				body = this._getBody(),
				rowClass;

			switch( this.rowTotal ) {
				case 4 : rowClass = 'fc-four-rows'; break;
				case 5 : rowClass = 'fc-five-rows'; break;
				case 6 : rowClass = 'fc-six-rows'; break;
			}

			this.$cal = $( '<div class="fc-calendar ' + rowClass + '">' ).append( head, body );

			this.$el.find( 'div.fc-calendar' ).remove().end().append( this.$cal );

			if( callback ) { callback.call(); }

		},
		_getHead : function() {

			var html = '<div class="fc-head">';
		
			for ( var i = 0; i <= 6; i++ ) {

				var pos = i + this.options.startIn,
					j = pos > 6 ? pos - 6 - 1 : pos;

				html += '<div>';
				html += this.options.displayWeekAbbr ? this.options.weekabbrs[ j ] : this.options.weeks[ j ];
				html += '</div>';

			}

			html += '</div>';

			return html;

		},
		_getBody : function() {

			var d = new Date( this.year, this.month + 1, 0 ),
				// number of days in the month
				monthLength = d.getDate(),
				firstDay = new Date( this.year, this.month, 1 );

			// day of the week
			this.startingDay = firstDay.getDay();

			//week number	
			firstDay.setHours(0,0,0);
			firstDay.setDate(firstDay.getDate() + 4 - (firstDay.getDay()||7));
			var yearStart = new Date(firstDay.getFullYear(),0,1);
			var weekNo = Math.ceil(( ( (firstDay - yearStart) / 86400000) + 1)/7);
			//console.log(weekNo);
        	//week number


			var html = '<div class="fc-body"><div class="weekNo">'+weekNo+'</div><div class="fc-row">',
				// fill in the days
				day = 1;

			// this loop is for weeks (rows)
			for ( var i = 0; i < 7; i++ ) {


						
				var max_events = 0;
				var day_cells = '';
				// this loop is for weekdays (cells)
				for ( var j = 0; j <= 6; j++ ) {



					var pos = this.startingDay - this.options.startIn,
						p = pos < 0 ? 6 + pos + 1 : pos,
						inner = '',
						today = this.month === this.today.getMonth() && this.year === this.today.getFullYear() && day === this.today.getDate(),
						content = '';
					

					
					var cellClasses = '';
					
					if ( day <= monthLength && ( i > 0 || j >= p ) ) {

						
						
						// this day is:
						var strmonth = ( this.month + 1 < 10 ? '0' + ( this.month + 1 ) : this.month + 1 );
						var strday = ( day < 10 ? '0' + day : day );
						
						var strdate = strmonth + '-' + strday + '-' + this.year,
							strdateger = strday + '.' + strmonth + '.' + this.year,
							dayData = this.caldata[ strdate ];
						
						
						
						inner += '<span class="fc-date" date="'+strdate+'" dateger="'+strdateger+'">' + day + '</span>';
						inner += '<span class="fc-weekday">' + this.options.weekabbrs[ j + this.options.startIn > 6 ? j + this.options.startIn - 6 - 1 : j + this.options.startIn ] + '</span>';
						inner += '<span class="add_event">+</span>';
						
						if( dayData ) {
						$.each(dayData, function(index,value){
		                	content += '<span class="event" id="event_'+value.ID+'" yearly="'+value.Yearly+'" duration="'+value.Duration+'" event_id="'+value.ID+'" day="'+value.Day+'" title="'+value.Text+'">'+value.Text+'</span>';
		                	
		                });

		                max_events = dayData.length > max_events ? dayData.length : max_events;
						}	

						
						if( content !== '' ) {
							inner += '<div>' + content + '</div>';
						}

						++day;

					} else {
						today = false;
						cellClasses += 'fc-empty ';
					}

					cellClasses = today ? 'fc-today ' : cellClasses;
					if( content !== '' ) {
						cellClasses += 'fc-content ';
					}
					
					if( j <= 6 && j >= 5 ){ //weekend
						cellClasses += 'fc-we';
					}
					

					//day_cell[j] = cellClasses !== '' ? '<div class="' + cellClasses + '"' : '<div';
					//day_cell[j]['inner'] = inner;
					
					day_cells += cellClasses !== '' ? '<div class="' + cellClasses + '" div_height>' : '<div div_height>';
					day_cells += inner;
					day_cells += '</div>';



				} //for days
				
				
				//.toString();
				day_cells = day_cells.replace(/div_height/g, "style='height:"+(60+max_events*25.3)+"px;'");
				
				html += day_cells;
				//console.log(day_cells);
				//console.log(max_events);
				//console.log(strmonth);

				// stop making rows if we've run out of days
				if (day > monthLength) {
					this.rowTotal = i + 1;
					break;
				} 
				else {
					html += '</div><div class="weekNo">'+(weekNo+i+1)+'</div><div class="fc-row">';
				}

			} //for rows
			
			html += '</div></div>';

			return html;

		},
		// based on http://stackoverflow.com/a/8390325/989439
		_isValidDate : function( date ) {

			date = date.replace(/-/gi,'');
			var month = parseInt( date.substring( 0, 2 ), 10 ),
				day = parseInt( date.substring( 2, 4 ), 10 ),
				year = parseInt( date.substring( 4, 8 ), 10 );

			if( ( month < 1 ) || ( month > 12 ) ) {
				return false;
			}
			else if( ( day < 1 ) || ( day > 31 ) )  {
				return false;
			}
			else if( ( ( month == 4 ) || ( month == 6 ) || ( month == 9 ) || ( month == 11 ) ) && ( day > 30 ) )  {
				return false;
			}
			else if( ( month == 2 ) && ( ( ( year % 400 ) == 0) || ( ( year % 4 ) == 0 ) ) && ( ( year % 100 ) != 0 ) && ( day > 29 ) )  {
				return false;
			}
			else if( ( month == 2 ) && ( ( year % 100 ) == 0 ) && ( day > 29 ) )  {
				return false;
			}

			return {
				day : day,
				month : month,
				year : year
			};

		},
		_move : function( period, dir, callback ) {

			if( dir === 'previous' ) {
				
				if( period === 'month' ) {
					this.year = this.month > 0 ? this.year : --this.year;
					this.month = this.month > 0 ? --this.month : 11;
				}
				else if( period === 'year' ) {
					this.year = --this.year;
				}

			}
			else if( dir === 'next' ) {

				if( period === 'month' ) {
					this.year = this.month < 11 ? this.year : ++this.year;
					this.month = this.month < 11 ? ++this.month : 0;
				}
				else if( period === 'year' ) {
					this.year = ++this.year;
				}

			}
			this._generateTemplate( callback );

		},
		/************************* 
		******PUBLIC METHODS *****
		**************************/

		getYear : function() {
			return this.year;
		},
		getMonth : function() {
			return this.month + 1;
		},
		getMonthName : function() {
			return this.options.displayMonthAbbr ? this.options.monthabbrs[ this.month ] : this.options.months[ this.month ];
		},
		getWeek : function(){
			return 2;
			var onejan = new Date(this.getFullYear(),0,1);
        	return Math.ceil((((this - onejan) / 86400000) + onejan.getDay()+1)/7);
		},
		
		// gets the cell's content div associated to a day of the current displayed month
		// day : 1 - [28||29||30||31]
		getCell : function( day ) {

			var row = Math.floor( ( day + this.startingDay - this.options.startIn ) / 7 ),
				pos = day + this.startingDay - this.options.startIn - ( row * 7 ) - 1;

			return this.$cal.find( 'div.fc-body' ).children( 'div.fc-row' ).eq( row ).children( 'div' ).eq( pos ).children( 'div' );

		},
		setData : function( caldata ) {

			caldata = caldata || {};
			$.extend( this.caldata, caldata );
			this._generateTemplate();

		},
		addData : function( caldata ) {

			caldata = caldata || {};
			$.extend( {}, this.caldata, caldata );
			this._generateTemplate();

		},
		
		// goes to today's month/year
		gotoNow : function( callback ) {

			this.month = this.today.getMonth();
			this.year = this.today.getFullYear();
			this._generateTemplate( callback );

		},
		// goes to month/year
		gotoX : function( month, year, callback ) {

			this.month = month;
			this.year = year;
			this._generateTemplate( callback );

		},
		gotoPreviousMonth : function( callback ) {
			this._move( 'month', 'previous', callback );
		},
		gotoPreviousYear : function( callback ) {
			this._move( 'year', 'previous', callback );
		},
		gotoNextMonth : function( callback ) {
			this._move( 'month', 'next', callback );
		},
		gotoNextYear : function( callback ) {
			this._move( 'year', 'next', callback );
		}

	};
	
	var logError = function( message ) {

		if ( window.console ) {

			window.console.error( message );
		
		}

	};
	
	$.fn.calendario = function( options ) {

		var instance = $.data( this, 'calendario' );
		
		if ( typeof options === 'string' ) {
			
			var args = Array.prototype.slice.call( arguments, 1 );
			
			this.each(function() {
			
				if ( !instance ) {

					logError( "cannot call methods on calendario prior to initialization; " +
					"attempted to call method '" + options + "'" );
					return;
				
				}
				
				if ( !$.isFunction( instance[options] ) || options.charAt(0) === "_" ) {

					logError( "no such method '" + options + "' for calendario instance" );
					return;
				
				}
				
				instance[ options ].apply( instance, args );
			
			});
		
		} 
		else {
		
			this.each(function() {
				
				if ( instance ) {

					instance._init();
				
				}
				else {

					instance = $.data( this, 'calendario', new $.Calendario( options, this ) );
				
				}

			});
		
		}
		
		return instance;
		
	};
	
} )( jQuery, window );
