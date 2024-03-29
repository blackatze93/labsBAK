var opDefault = {
    locale: 'es',
    showTodayButton: true,
    showClear: true,
    showClose: true,
    useCurrent: false,
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
    },
    tooltips: {
        today: 'Hoy',
        clear: 'Limpiar',
        close: 'Cerrar',
        selectTime: 'Seleccionar hora',
        incrementHour: 'Aumentar hora',
        incrementMinute: 'Aumentar minuto',
        decrementHour: 'Disminuir hora',
        decrementMinute: 'Disminuir minuto',
        pickHour: 'Seleccionar hora',
        pickMinute: 'Seleccionar minuto',
        selectMonth: 'Seleccionar mes',
        prevMonth: 'Mes anterior',
        nextMonth: 'Siguiente mes',
        selectYear: 'Seleccionar año',
        prevYear: 'Año anterior',
        nextYear: 'Siguiente año',
        selectDecade: 'Seleccionar década',
        prevDecade: 'Década anterior',
        nextDecade: 'Siguiente década',
        prevCentury: 'Siglo anterior',
        nextCentury: 'Siguiente siglo'
    }
};

var opDateTime = {
    format: 'YYYY-MM-DD HH:mm'
};

$.extend(opDateTime, opDefault);

var opDate = {
    format: 'YYYY-MM-DD'
};

$.extend(opDate, opDefault);

var opTime = {
    format: 'HH:mm'
};

$.extend(opTime, opDefault);

$(function () {
    $('#objetoencontrado_fechaRegistro').datetimepicker(opDateTime);

    $('#incidencia_fechaRegistro').datetimepicker(opDateTime);

    $('#incidencia_fechaAtencion').datetimepicker(opDateTime);

    $('#mantenimientoexterno_fecha').datetimepicker(opDateTime);

    $('#baja_fecha').datetimepicker(opDate);

    $('#traslado_fecha').datetimepicker(opDate);

    $('#evento_fecha').datetimepicker(opDate);

    $('#evento_horaInicio').datetimepicker(opTime);

    $('#evento_horaFin').datetimepicker(opTime);

    $('#elemento_fechaIngreso').datetimepicker(opDate);

    $('#prestamopracticalibre_fechaPrestamo').datetimepicker(opDate);

    $('#prestamopracticalibre_horaEntrada').datetimepicker(opTime);

    $('#prestamopracticalibre_horaSalida').datetimepicker(opTime);

    $('#prestamoelemento_fechaPrestamo').datetimepicker(opDateTime);

    $('#prestamoelemento_fechaDevolucion').datetimepicker(opDateTime);

    $('#solicitudsala_fecha').datetimepicker(opDate);

    $('#solicitudsala_fechaSolicitud').datetimepicker(opDateTime);

    $('#solicitudsala_horaInicio').datetimepicker(opTime);

    $('#solicitudsala_horaFin').datetimepicker(opTime);

    $('#soportefacultad_fechaRegistro').datetimepicker(opDateTime);


});