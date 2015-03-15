$(document).ready(function () {
	$('#scanner').html5_qrcode(function(data){
	 		$('#read').html(data);
	 	},
	 	function(error){
			$('#read_error').html(error);
		}, function(videoError){
			$('#vid_error').html(videoError);
		}
	);
});