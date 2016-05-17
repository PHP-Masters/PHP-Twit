$(function(){
	// check each time they press a key in the username form
	$("#username").keypress(function (event) {
		var key = event.which;
		// if the key is the space bar, don't add it
		if (key == 32) {
            return false;
        }
		return true;
	});
});
