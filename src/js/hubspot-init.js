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

  
  !function () {
    if (window.HUBSPOT_ID) {
      console.warn("Hubspot snippet included twice");
    } else {
      window.HUBSPOT_ID = hubspot_settings.hubspot_id;
      var n, o;
      o = document.createElement("script");
      o.src = "//js.hs-scripts.com/"+window.HUBSPOT_ID+".js", o.defer = !0, o.type = "text/javascript", o.async = !0, o.crossorigin = "anonymous";
      n = document.getElementsByTagName("script")[0], n.parentNode.insertBefore(o, n);
    }
  }()
};