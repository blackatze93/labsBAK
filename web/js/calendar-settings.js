$(function () {
    // TODO: eliminar o comprobar el encabezado de todo el dia, dependiendo si hay eventos asi
    $('#calendar-holder').fullCalendar({
        locale: 'es',
        schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives',
        // General display options
        defaultView: 'agendaDay',
        header: {
            left: 'prev, next, today',
            center: 'title',
            right: 'agendaDay, agendaWeek, month'
        },
        // Agenda options
        // minTime: '06:00:00',
        // maxTime: '22:00:00',
        // Current date options
        nowIndicator: true,
        // Clicking & Hovering
        navLinks: true,
        // Event Data options
        eventSources: [
            {
                url: Routing.generate('fullcalendar_loader'),
                type: 'POST',
                // A way to add custom filters to your event listeners
                data: {
                    filter: 'my_custom_filter_param'
                },
                error: function() {
                    //alert('There was an error while fetching Google Calendar!');
                }
            }
        ],
        // Resource Data options
        resources: {
            url: Routing.generate('fullcalendar_lugares'),
            type: 'POST'
        }
    });
});