$(function () {
    // TODO: Asignar las opciones globalmente

    $('#objetoencontrado_fechaRegistro').datetimepicker({
        locale: 'es',
        format: 'YYYY-MM-DD HH:mm',
        showTodayButton: true,
        showClear: true,
        showClose: true,
        disabledHours: [0,1,2,3,4,5,22,23],
        icons: {
            time: "fa fa-clock-o",
            date: "fa fa-calendar",
            up: "fa fa-chevron-up",
            down: "fa fa-chevron-down",
            previous: "fa fa-chevron-left",
            next: "fa fa-chevron-right",
            today: "fa fa-calendar-check-o",
            clear: "fa fa-trash-o",
            close: "fa fa-window-close-o"
        }
    });

    $('#mantenimientoexterno_fecha').datetimepicker({
        locale: 'es',
        format: 'YYYY-MM-DD HH:mm',
        showTodayButton: true,
        showClear: true,
        showClose: true,
        disabledHours: [0,1,2,3,4,5,22,23],
        icons: {
            time: "fa fa-clock-o",
            date: "fa fa-calendar",
            up: "fa fa-chevron-up",
            down: "fa fa-chevron-down",
            previous: "fa fa-chevron-left",
            next: "fa fa-chevron-right",
            today: "fa fa-calendar-check-o",
            clear: "fa fa-trash-o",
            close: "fa fa-window-close-o"
        }
    });
});