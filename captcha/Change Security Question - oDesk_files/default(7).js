jQuery(function() {
    
    new odesk.SimpleCompanySelector('#simple-company-selector', {
        cookie: {
            domain: window.ODESK_COOKIE_DOMAIN,
            prefix: window.ODESK_COOKIE_PREFIX
        }
    });
    
});
