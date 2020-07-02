/*!
 * project-name v0.0.1
 * A description for your project.
 * (c) 2020 YOUR NAME
 * MIT License
 * http://link-to-your-git-repo.com
 */

window.fbAsyncInit = function() {
  FB.init({
    xfbml            : true,
    version          : 'v7.0'
  });
};

(function(d, s, id) {
var js, fjs = d.getElementsByTagName(s)[0];
if (d.getElementById(id)) return;
js = d.createElement(s); js.id = id;
js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));

