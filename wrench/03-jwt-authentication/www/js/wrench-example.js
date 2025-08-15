function hlsUrl() {
  return 'http://' + $("#server").val() + '/' + $("#appname").val() + '/' + $("#stream").val() + '/playlist.m3u8?t=' + token;
}

function rtmpUrl() {
  return 'rtmp://' + $("#server").val() + '/' + $("#appname").val() + '/' + $("#stream").val() + '?t=' + token;
}

function regenerateLinks() {
  
  var hlsAnchor = $('#hlsUrl');
  hlsAnchor.attr("href", hlsUrl());
  hlsAnchor.text(hlsUrl());
    
  var rtmpAnchor = $('#rtmpUrl');
  rtmpAnchor.attr("href", rtmpUrl());
  rtmpAnchor.text(rtmpUrl());

}

function setupPlayer() {
  var video = document.getElementById('video');
	var videoSrc = hlsUrl();

	if (Hls.isSupported()) {
		var hls = new Hls();
		hls.loadSource(videoSrc);
		hls.attachMedia(video);
	}	else if (video.canPlayType('application/vnd.apple.mpegurl')) {
		video.src = videoSrc;
	}
}

$(document).ready(function() {

  $("#server").keyup(regenerateLinks);
  $("#appname").keyup(regenerateLinks);
  $("#stream").keyup(regenerateLinks);

  $("#regenerate").click(setupPlayer);
});

