window.onload=function(){
	var qrcode = new QRCode(document.getElementById("qrcode"), {
		width : 200,
		height : 200
	});

	function makeCode () {		
		var elText = document.getElementById("text");
		
		if (!elText.value) {
			elText.focus();
			return;
		}
		
		qrcode.makeCode(elText.value);
	}

	makeCode();

	$("#text").
		on("blur", function () {
			makeCode();
		}).
		on("keyup", function (e) {
			makeCode();
		});
}