/** alert **/
function fade(alert_show) {
    if (alert_show.is(":hidden")) {
        alert_show.show().delay(1500);
        alert_show.fadeOut(400);
    }
    else {
        alert_show.hide();
        alert_show.show().delay(1500);
        alert_show.fadeOut(400);
    }
}
