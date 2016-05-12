$(function(){
	$("#username").keypress(function (event) {
		var key = event.which;
		if (key == 32) {
            return false;
        }
		return true;
	});
});
