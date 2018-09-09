$(document).ready(function () {

    var pieData = [
        {
            value: 30,
            color:"#F38630"
        },
        {
            value : 50,
            color : "#E0E4CC"
        },
        {
            value : 100,
            color : "#69D2E7"
        }

    ];

    // Loading Screen Trigger
    $('#loadingScreenTrigger').on('click', function () {
        $('#loadingScreen').fadeIn(150);
    });

    // Overview: Pie Chart Example
    new Chart(document.getElementById("pieGoogleChart").getContext("2d")).Pie(pieData);

    // Trigger for bootstrap tooltip
    $('[data-toggle="tooltip-bootstrap"]').tooltip();

});