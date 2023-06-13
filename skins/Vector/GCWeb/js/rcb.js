( function () {
var checkboxHtml = '<input id="helpCheckbox" type="checkbox" >'
var helpToggleHtml = '<li><label id="helpToggle">' + checkboxHtml + ' Start Here</label></li>';
var helpOn = $.cookie('gcpediaHelp');
var helpBubbleHtml = ' \
	<div id="helpArea" style="display:none;"> \
 		<span id="triangle-black"></span> \
  		<span id="triangle-green"></span> \
  		<div id="helpBubble"> \
   			Type a title to search or to create a page \
		</div> \
	</div>'

// add the toggle to the menu
$('#pt-uls').parent('ul').append(helpToggleHtml);
$("#searchInput").after(helpBubbleHtml);

$('#pt-uls').parent().on('change','#helpCheckbox', function(){
	var $this = $('#helpCheckbox'), $helpArea = $('#helpArea');
	if($this.is(":checked")){
		$helpArea.show();
		$.cookie('gcpediaHelp', 'y');
	}
	else{
		$helpArea.hide(); //hide it
		$.cookie('gcpediaHelp', 'n');
	}
});

		if((helpOn=="") || (helpOn==null)){ // no cookie set
			$.cookie('gcpediaHelp', 'y') //create a cookie with help on
			$("#helpCheckbox").attr('checked', true); //manually check the checkbox
			// manually do things in toggleHelp function:
			if ($("#helpArea").length) { //if helpArea exists
				//console.log( "help area exists, show"); //debugging
				$("#helpArea").show(); //show it
			}
			else{
				//console.log( "help area doesn't exist, show"); //debugging
				$("#searchInput").after(helpBubbleHtml); //put it on the screen
			}
		}
		else{ // cookie set
			//read the cookie - turn help on or off
			if ($.cookie('gcpediaHelp') == 'y'){ //cookie says y
				$("#helpCheckbox").prop('checked', true)
				$("#helpCheckbox").trigger('change'); //manually check the checkbox and trigger event
			}
		}
}() );
