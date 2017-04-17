function notificacion(text, type) {
    new Noty({
        type        : type,
        text        : text
    }).show();
}

Noty.overrideDefaults({
    layout   : 'bottomCenter',
    theme    : 'mint',
    timeout     : 5000
});