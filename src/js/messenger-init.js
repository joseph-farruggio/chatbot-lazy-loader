window.fbAsyncInit = function() {
  FB.init({
    xfbml            : true,
    version          : 'v7.0'
  });
};

var LoadChatWidget = function(){ (function(d, s, id) {
var js, fjs = d.getElementsByTagName(s)[0];
if (d.getElementById(id)) return;
js = d.createElement(s); js.id = id;
js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));
};

// function OpenChatWidget() {
//   FB.Event.subscribe('customerchat.load', FB.CustomerChat.showDialog());
// }


var chatIsLoaded = false;

if (chatIsLoaded === false) {
  // load after waiting 5000 milliseconds, 5 seconds
  setTimeout(function(){ 
    LoadChatWidget();
    chatIsLoaded = true;
  }, 5000);
}