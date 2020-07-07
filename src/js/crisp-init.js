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

  window.$crisp=[];window.CRISP_WEBSITE_ID=crisp_settings.crisp_id;(function(){d=document;s=d.createElement("script");s.src="https://client.crisp.chat/l.js";s.async=1;d.getElementsByTagName("head")[0].appendChild(s);})();
};

function OpenChatWidget() {
  $crisp.push(["do", "chat:open"]);
};