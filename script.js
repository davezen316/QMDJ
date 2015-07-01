function searchFunction() {
	var date = document.getElementById("date_txt").value;
	var time = document.getElementById("time_txt").value;
	// Returns successful data submission message when the entered information is stored in database.
	var dataString = 'date=' + date + '&time=' + time;
	if (date == '' || time == '') {
		alert("Please Fill All Fields");
	} else {
		// AJAX code to submit form.
		$.ajax({
			type: "POST",
			url: "index.php",
			data: dataString,
			cache: false,
			success: function(html) {
				alert(html);
			}
		});
	}
	return false;
}