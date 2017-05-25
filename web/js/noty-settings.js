function notificacion(text, type) {
    new Noty({
        type        : type,
        text        : text
    }).show();
}

Noty.overrideDefaults({
    layout   : 'topCenter',
    theme    : 'sunset',
    timeout     : 5000
});