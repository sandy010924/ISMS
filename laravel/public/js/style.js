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
/*學員修改基本資料button*/
var basic_input = document.getElementsByClassName("basic-inf");
var i;
document.getElementById('update-inf').onclick = function() {
    for (i = 0; i < basic_input.length; i++) {
        basic_input[i].removeAttribute('readonly');
    }
    document.getElementById("save-inf").style.display = "block";
    document.getElementById("update-inf").style.display = "none";
};

document.getElementById('save-inf').onclick = function() {
    for (i = 0; i < basic_input.length; i++) {
        basic_input[i].setAttribute('readonly','readonly');
    }
    /*document.getElementById('basic-inf').setAttribute('readonly','readonly');*/
    document.getElementById("save-inf").style.display = "none";
    document.getElementById("update-inf").style.display = "block";
};
