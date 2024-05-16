// Inspect element disable procted content
document.onkeydown = function(e) {
  if(event.keyCode == 123) {
     return false;
  }
  if(e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)) {
     return false;
  }
  if(e.ctrlKey && e.shiftKey && e.keyCode == 'C'.charCodeAt(0)) {
     return false;
  }
  if(e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)) {
     return false;
  }
  if(e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)) {
     return false;
  }
}
document.addEventListener('contextmenu', function(e) {
  e.preventDefault();
  //alert('Oops Sorry! Website Content is protected');
});

// don't copy text content
jQuery(document).bind("contextmenu cut copy",function(e){
    e.preventDefault();
    // alert('This Website is Protected:)');
});
function killCopy(e){
        return false
    }
    function reEnable(){
        return true
    }
    document.onselectstart=new Function ("return false")
    if (window.sidebar){
        document.onmousedown=killCopy
        document.onclick=reEnable
    }
    document.addEventListener('copy', function (e){
    e.preventDefault();
    e.clipboardData.setData("text/plain", "Do not copy this site's content!");
})

// When open google dev tools
var element = new Image;
var devtoolsOpen = false;
element.__defineGetter__("id", function() {
    devtoolsOpen = true; // This only executes when devtools is open.
});
setInterval(function() {
    devtoolsOpen = false;
    console.log(element);
    if(devtoolsOpen == true)
    {
      alert("Please Stop");
    }
}, 1000);
