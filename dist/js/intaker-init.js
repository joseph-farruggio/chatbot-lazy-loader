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
  (function(w,d,s,l,i){w[l]=i;var f=d.getElementsByTagName(s)[0], j=d.createElement(s);j.async=true;j.src= 'https://intaker.co/dist/chat-widget.min.js';f.parentNode.insertBefore(j,f); })(window,document,'script','SU5UQUtFUl9DSEFUX1VSTA==', intaker_settings.intaker_id);
};