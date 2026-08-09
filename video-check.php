<?php
// TEMPORARY diagnostic page - delete after testing
require __DIR__ . '/includes/config.php';
?>
<!DOCTYPE html>
<html>
<head><title>video check</title></head>
<body style="font-family:monospace;">
<h3>Video playback check</h3>
<video id="v" autoplay muted loop playsinline preload="auto" style="width:400px;">
  <source src="<?php echo e(site_url('images/Olive%20and%20White%20Modern%20Spa%20and%20Wellness%20Banner%20Landscape.mp4')); ?>" type="video/mp4">
</video>
<pre id="out">checking...</pre>
<script>
var v = document.getElementById('v');
var out = document.getElementById('out');
function log(m){ out.textContent += '\n' + m; }
log('readyState=' + v.readyState + ' paused=' + v.paused + ' error=' + (v.error ? v.error.code : 'none'));
v.addEventListener('loadedmetadata', function(){
  log('loadedmetadata: videoWidth=' + v.videoWidth + ' videoHeight=' + v.videoHeight + ' duration=' + v.duration);
});
v.addEventListener('playing', function(){ log('EVENT playing (started playback)'); });
v.addEventListener('waiting', function(){ log('EVENT waiting (buffering)'); });
v.addEventListener('error', function(){ log('EVENT error code=' + (v.error ? v.error.code : '?')); });
setTimeout(function(){
  log('AFTER 12s: readyState=' + v.readyState + ' paused=' + v.paused + ' currentTime=' + v.currentTime.toFixed(2));
  log('supported=' + (v.canPlayType('video/mp4') || 'no'));
}, 12000);
</script>
</body>
</html>
