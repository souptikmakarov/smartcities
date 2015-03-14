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

	$('#downloader').on("click",function(){
		alert('Hello');
		downloadImage(this,'qrcode.png');

	},false);

	function downloadImage(link,filename){
		link.href=document.getElementsByTagName('img').attr('src');
		alert(link.href);
		link.download=filename;
	}
}