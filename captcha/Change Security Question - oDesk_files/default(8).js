jQuery(function() {
    var uid = window.ODESK_USER_UID || window.USER_UID;
    odesk.launchbar = new odesk.Launchbar('.navigation', {
        uid: uid,
        helpcms: window.ODESK_HELPCMS_ROOT || window.HELPCMS_ROOT,
        cookie: {
            name: window.ODESK_COOKIE_PREFIX + 'mc_unread.' + uid,
            options: {
                domain: window.ODESK_COOKIE_DOMAIN
            }
        }
    });
});
