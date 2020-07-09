/*!
 * chatbot-optimizer v0.0.1
 * Eliminate the impact of chatbots on your page speed
 * (c) 2020 YOUR NAME
 * MIT License
 * http://link-to-your-git-repo.com
 */

var chatIsLoaded = false;

if (chatIsLoaded === false) {
  // load after waiting 5000 milliseconds, 5 seconds
  setTimeout((function(){ 
    LoadChatWidget();
    chatIsLoaded = true;
  }), 5000);
}

function LoadChatWidget() {
  chatIsLoaded = true;

  
  !(function () {
    if (window.JOONBOT_WIDGET_ID) {
      console.warn("Joonbot snippet included twice");
    } else {
      window.JOONBOT_WIDGET_ID = joonbot_settings.joonbot_id;
      var n, o;
      o = document.createElement("script");
      o.src = "https://js.joonbot.com/init.js", o.defer = !0, o.type = "text/javascript", o.async = !0, o.crossorigin = "anonymous";
      n = document.getElementsByTagName("script")[0], n.parentNode.insertBefore(o, n);
    }
  })()
};