

window.onload = function () {
    status_onload();
}

function status_more() {
    // document.getElementById('status_dropdown').pro
    document.getElementById("status_dropdown").style.position = "fixed";
    document.getElementById("status_dropdown").style.left = event.clientX - 50 + "px";
    document.getElementById("status_dropdown").style.top = event.clientY + 20 + "px";
    document.getElementById("status_dropdown").style.display = "block";
}


function status_onload() {
    var apply_btn = document.getElementsByName('apply_btn');
    var check_btn = document.getElementsByName('check_btn');
    for (var i = 0; i < apply_btn.length; i++) {
        status_style(apply_btn[i].id, apply_btn[i].value);
    }
    for (var i = 0; i < check_btn.length; i++) {
        status_style(check_btn[i].id, check_btn[i].value);
    }
}

function status_style(status_id, status_value) {
    switch (parseInt(status_value)) {
        case 1:  //已報名
            $("#" + status_id).css('backgroundColor', '#6c757d');
            $("#" + status_id).css('borderColor', '#6c757d');
            break;
        case 3:  //未到
            // $("#" + status_id).css('backgroundColor',  = '#6c757d';
            $("#" + status_id).css('backgroundColor', '#6c757d');
            $("#" + status_id).css('borderColor', '#6c757d');
            break;
        case 4:  //報到
            $("#" + status_id).css('backgroundColor', '#4CAF50');
            $("#" + status_id).css('borderColor', '#4CAF50');
            break;
        case 5:  //取消
            $("#" + status_id).css('backgroundColor', '#E43D40');
            $("#" + status_id).css('borderColor', '#E43D40');
            break;
        default:
            $("#" + status_id).css('backgroundColor', '#6c757d');
            $("#" + status_id).css('borderColor', '#6c757d');
            break;
    }
}
