/*!
 * project-name v0.0.1
 * A description for your project.
 * (c) 2020 YOUR NAME
 * MIT License
 * http://link-to-your-git-repo.com
 */

document.documentElement.style.setProperty('--chat-button', intercom_settings.button_color);

//Set your APP_ID
var APP_ID = intercom_settings.intercom_id;
var BACKGROUND = intercom_settings.button_color;

window.intercomSettings = {
  app_id: APP_ID,
  background_color: BACKGROUND,
  action_color: BACKGROUND,
};

var LoadChatWidget = function(){chatIsLoaded = true; var w=window;var ic=w.Intercom;if(typeof ic==="function"){ic('reattach_activator');ic('update',w.intercomSettings);}else{var d=document;var i=function(){i.c(arguments);};i.q=[];i.c=function(args){i.q.push(args);};w.Intercom=i;var l=function(){var s=d.createElement('script');s.type='text/javascript';s.async=true;s.src='https://widget.intercom.io/widget/' + APP_ID;var x=d.getElementsByTagName('script')[0];x.parentNode.insertBefore(s, x);};if(document.readyState==='complete'){l();}else if(w.attachEvent){w.attachEvent('onload',l);}else{w.addEventListener('load',l,false);}}};

var chatIsLoaded = false;

if (chatIsLoaded === false) {
  // load after waiting 5000 milliseconds, 5 seconds
  setTimeout((function(){ 
    LoadChatWidget();
    chatIsLoaded = true;
  }), 5000);
}