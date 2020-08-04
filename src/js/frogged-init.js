window.frogedSettings = { appId: frogged_settings.frogged_id }

var chatIsLoaded = false;

if (chatIsLoaded === false) {
  // load after waiting 5000 milliseconds, 5 seconds
  setTimeout(function () {
    LoadChatWidget();
    chatIsLoaded = true;
  }, 5000);
}

function LoadChatWidget() {
  chatIsLoaded = true;

  
    (function () {
      var a = document, b = window;
      if ("function" != typeof Froged) {
        Froged = function (a, b, c) {
          Froged.c(a, b, c);
        },
        Froged.q = [],
        Froged.c = function (a, b, c) {
          Froged.q.push([a, b, c]);
        },
        fg_data = {
          hooks: {}
        }
        var c = function () {
          var b = a.createElement("script");
          b.type = "text/javascript",
            b.async = !0, b.src = "https://sdk.froged.com";
          var c = a.getElementsByTagName("script")[0];
          c.parentNode.insertBefore(b, c);
        };
        "complete" === a.readyState ? c() : window.attachEvent ? b.attachEvent("onload", c) : b.addEventListener("load", c, !1);
      }
    }
    )()
};