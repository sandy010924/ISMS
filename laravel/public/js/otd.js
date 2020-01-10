var apply_btn = document.getElementsByClassName('apply_btn');
var check_btn = document.getElementsByClassName('check_btn');

window.onload = function () {
    for (var i = 0; i < apply_btn.length; i++) {
        status_style(apply_btn[i].id, apply_btn[i].value);
        apply_btn[i].onclick = function (event) {
            var apply_id = event.target.id;
            var apply_value = event.target.value;
            apply_value = change_apply(apply_id, apply_value);
            status_style(apply_id, apply_value);
        }
    }
    for (var i = 0; i < check_btn.length; i++) {
        status_style(check_btn[i].id, check_btn[i].value);
        check_btn[i].onclick = function (event) {
            var check_id = event.target.id;
            var check_value = event.target.value;
            check_value = change_check(check_id, check_value);
            status_style(check_id, check_value);
        }
    }
    // for (var i = 0; i < status_btn2.length; i++) {
    //     status_btn2[i].onclick = function (event) {
    //         var status_id = event.target.id;
    //         var status_value = status_id.value;

    //         change_status(status_id, changevalue_status2(status_id));
    //     }
    // }
}
function change_apply(apply_id, apply_value) {
    if (apply_value == '0') {
        document.getElementById(apply_id).value = '3';
    }
    else {
        document.getElementById(apply_id).value = '0';
    }
    return document.getElementById(apply_id).value;
}
function change_check(check_id, check_value) {
    if (check_value == '1') {
        document.getElementById(check_id).value = '2';
    }
    else {
        document.getElementById(check_id).value = '1';
    }
    return document.getElementById(check_id).value;
}

function status_more() {
    // document.getElementById('status_dropdown').pro
    document.getElementById("status_dropdown").style.position = "fixed";
    document.getElementById("status_dropdown").style.left = event.clientX - 50 + "px";
    document.getElementById("status_dropdown").style.top = event.clientY + 20 + "px";
    document.getElementById("status_dropdown").style.display = "block";
}
// function change_check(status_id) {
//     if (i++ % 2 == 0) {
//         document.getElementById(status_id).value = 0;
//     }
//     else {
//         document.getElementById(status_id).value = 3;
//     }
//     return document.getElementById(status_id).value;
// }
function status_style(status_id, status_value) {
    switch (status_value) {
        case '0':
            // document.getElementById(status_id).className = 'btn btn-sm absent apply_btn';
            document.getElementById(status_id).style.backgroundColor = '#6c757d';
            document.getElementById(status_id).style.borderColor = '#6c757d';
            document.getElementById(status_id).innerHTML = '已報名';
            break;
        case '1':
            // document.getElementById(status_id).className = 'btn btn-sm present apply_btn';
            document.getElementById(status_id).style.backgroundColor = '#4CAF50';
            document.getElementById(status_id).style.borderColor = '#4CAF50';
            document.getElementById(status_id).innerHTML = '報到';
            break;
        case '2':
            // document.getElementById(status_id).className = 'btn btn-sm absent apply_btn';
            document.getElementById(status_id).style.backgroundColor = '#6c757d';
            document.getElementById(status_id).style.borderColor = '#6c757d';
            document.getElementById(status_id).innerHTML = '未到';
            break;
        case '3':
            // document.getElementById(status_id).className = 'btn btn-sm cancel apply_btn';
            document.getElementById(status_id).style.backgroundColor = '#E43D40';
            document.getElementById(status_id).style.borderColor = '#E43D40';
            document.getElementById(status_id).innerHTML = '取消';
            break;
        default:
            // document.getElementById(status_id).className = 'btn btn-sm absent apply_btn';
            document.getElementById(status_id).style.backgroundColor = '#6c757d';
            document.getElementById(status_id).style.borderColor = '#6c757d';
            document.getElementById(status_id).textContent = '未到';
            break;
    }
}


function check(status_id) {
    document.getElementById(status_id).style.backgroundColor = '#4CAF50';
    document.getElementById(status_id).style.borderColor = '#4CAF50';
    document.getElementById(status_id).textContent = '報到';
}
function absent(status_id) {
    document.getElementById(status_id).style.backgroundColor = '#6c757d';
    document.getElementById(status_id).style.borderColor = '#6c757d';
    document.getElementById(status_id).textContent = '未到';
}
function cancel(status_id) {
    document.getElementById(status_id).style.backgroundColor = '#E43D40';
    document.getElementById(status_id).style.borderColor = '#E43D40';
    document.getElementById(status_id).textContent = '取消';
}
// function present(status_id) {
//     document.getElementById(status_id).style.backgroundColor = '#4CAF50';
//     document.getElementById(status_id).style.borderColor = '#4CAF50';
//     document.getElementById(status_id).textContent = '報到';

// }
// function nocheck(status_id) {
//     document.getElementById(status_id).style.backgroundColor = '#6c757d';
//     document.getElementById(status_id).style.borderColor = '#6c757d';
//     document.getElementById(status_id).textContent = '未到';
// }

