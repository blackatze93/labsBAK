function notificacion(text, type) {
    noty({
        text        : text,
        type        : type,
        dismissQueue: true,
        timeout     : 5000,
        progressBar : true,
        closeWith   : ['click'],
        layout      : 'topCenter',
        modal       : false,
        theme       : 'bootstrapTheme',
        maxVisible  : 3
    });
}