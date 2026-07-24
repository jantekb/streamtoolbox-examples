param(
  [string]$HostName = "127.0.0.1",
  [int]$Port = 1935,
  [string]$Application = "ppm",
  [string]$Stream = "publisher-test",
  [string]$Token = "publishsecret",
  [int]$Seconds = 25
)

$rtmpUrl = "rtmp://${HostName}:${Port}/${Application}"
$rtmpApp = "${Application}?t=${Token}"

ffmpeg `
  -hide_banner `
  -re `
  -f lavfi -i "testsrc=size=1280x720:rate=30" `
  -f lavfi -i "sine=frequency=1000:sample_rate=44100" `
  -t $Seconds `
  -c:v libx264 -preset veryfast -pix_fmt yuv420p -g 60 -b:v 1800k `
  -c:a aac -b:a 128k `
  -rtmp_app $rtmpApp `
  -rtmp_playpath $Stream `
  -f flv $rtmpUrl
