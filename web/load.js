
var arr_script = [
'load.js', 'app.js', 'jquery.js', 'yii.js', 'yii.activeForm.js', 'bootstrap.js', 'bootstrap-notify.min.js'
];
var debug = document.createElement("div");
debug.id = 'debug';

var file_loaded = 0, percent = 0;
function getPercent(e){
  var file = fileres(e.target);
  var found = arr_script.find(function(v,id,arr){ return file.match(v)});
  if(found){
    file_loaded ++;
    percent = Math.round((file_loaded / arr_script.length) * 100);
  }
}

function fileres(res){
  var type = res.nodeName;
  if(type=='SCRIPT' || type=='IFRAME' || type=='IMG' || type=='SOURCE')
    return res.src;
  else if(type=='LINK' || type=='MAP')
    return res.href;
  else if(type=='OBJEXT')
    return res.data;
  return "";
}

function showLog (e){
	getPercent(e);
  if(!document.body){ 
    var log = "Loading..";
    document.writeln(`Loading ${percent}%`);
  }else{
    var debug_con = document.getElementById('debug_con');
    if(!document.getElementById('debug') && debug_con) debug_con.appendChild(debug);
    debug.textContent = `Loading ${percent}%`;
  }
}

document.addEventListener('DOMContentLoaded', showLog);
document.addEventListener('load', function(e) {
  showLog(e);
}, true);
window.addEventListener("unload", function(e) {
  showLog(e);
  navigator.sendBeacon("/", JSON.stringify({'test':1}));
});
document.addEventListener('readystatechange', (e) => {
  showLog(e);
  if(document.readyState =='complete'){
      debug.style.opacity=0;
  }
});

document.addEventListener("visibilitychange", function(e) {
  showLog(e);
  if (document.visibilityState === 'visible') {
  } else {
  }
});
