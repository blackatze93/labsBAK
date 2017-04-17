function notificacion(text, type) {
    noty({
        text        : text,
        type        : type,
        dismissQueue: true,
        timeout     : 10000,
        progressBar : true,
        closeWith   : ['click'],
        layout      : 'topCenter',
        modal       : false,
        theme       : 'metroui',
        maxVisible  : 3
    });
}