/*!
 * chatbot-optimizer v0.0.1
 * Eliminate the impact of chatbots on your page speed
 * (c) 2020 YOUR NAME
 * MIT License
 * http://link-to-your-git-repo.com
 */

document.documentElement.style.setProperty('--chat-button', indemandly_settings.button_color);

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
  

  var button = document.getElementById('indemandly-button');
  if (button) {
    button.parentNode.removeChild(button);
  }

  !(function (d, s, c) {
    s = d.createElement("script");
    s.src = "https://widget.indemand.ly/launcher.js";
    s.onload = function () {
        indemandly = new Indemandly({ domain: indemandly_settings.indemandly_username });
    };
    c = d.getElementsByTagName("script")[0];
    c.parentNode.insertBefore(s, c);
  })(document);
}