displayBox = function(msgString){
	body = document.getElementsByTagName("body");	
	body[0].innerHTML += "<div class='messageBox'><p class='messageBoxText'>"+msgString+"</p></div>";
	msgBox = document.getElementsByClassName("messageBox");

	fadeOut(3500,msgBox[0]);
	body[0].removeChild(msgBox);
	
		//setTimeout(function(){	msgBox[0].style.opacity =0;}, 2500);
}

function fadeOut(ms, el) {
  var opacity = 1,
    interval = 50,
    gap = interval / ms;
    
  function func() { 
    opacity -= gap;
    el.style.opacity = opacity;
    
    if(opacity <= 0) {
      window.clearInterval(fading); 
      el.style.display = 'none';
    }
  }
  
  var fading = window.setInterval(func, interval);

}