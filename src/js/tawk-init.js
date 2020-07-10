var chatIsLoaded = false;

if (chatIsLoaded === false) {
  // load after waiting 5000 milliseconds, 5 seconds
  setTimeout(function(){ 
    LoadChatWidget();
    chatIsLoaded = true;
  }, 5000);
}

function LoadChatWidget() {
  chatIsLoaded = true;

  var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
  (function(){
  var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
  s1.async=true;
  s1.src='https://embed.tawk.to/5f08beaa5b59f94722ba80c2/default';
  s1.charset='UTF-8';
  s1.setAttribute('crossorigin','*');
  s0.parentNode.insertBefore(s1,s0);
  })();

};