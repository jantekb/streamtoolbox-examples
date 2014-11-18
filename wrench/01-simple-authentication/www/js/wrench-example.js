function regenerateLinks() {

  var httpurl = 'http://' + $("#server").val() + '/' + $("#appname").val() + '/' + $("#stream").val() + '/playlist.m3u8?t=' + token;
  var rtmpurl_jw5 = 'rtmp://' + $("#server").val() + '/' + $("#appname").val() + '/' + $("#stream").val() + '?t=' + token;
  var rtmpurl_jw6 = 'rtmp://' + $("#server").val() + '/' + $("#appname").val() + '/?t=' + token + '/' + $("#stream").val();

  var httpAnchor = $('#httpurl');
  httpAnchor.attr("href", httpurl);
  httpAnchor.text(httpurl);
  
  var rtmpAnchor = $('#rtmpurl5');
  rtmpAnchor.attr("href", rtmpurl_jw5);
  rtmpAnchor.text(rtmpurl_jw5);
  
  var rtmpAnchor = $('#rtmpurl6');
  rtmpAnchor.attr("href", rtmpurl_jw6);
  rtmpAnchor.text(rtmpurl_jw6);

}

function setupPlayer() {
	$("#player-container").empty();
	
	// this weird url is only needed for JW Player 6
	var rtmpurl_jw6 = $('#rtmpurl6').text();
	
	jwplayer("player-container").setup({
	  
	  /* In this example we are dynamically construct the RTMP URL with the form,
	    so we construct the link containing the token from Javascript. An other very
		common approach is to generate this small Javascript function directly into your HTML code
		from PHP where you can directly emit a Javascript containing the token. See the video.php file
		for the commented example */

	  'file' : rtmpurl_jw6,
	  'width' : 640,
	  'height' : 400
	}
	
	);
}

$(document).ready(function() {

  $("#server").keyup(regenerateLinks);
  $("#appname").keyup(regenerateLinks);
  $("#stream").keyup(regenerateLinks);

  $("#regenerate").click(setupPlayer);
});

