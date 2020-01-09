function firstnext() {
    var firstpage = document.getElementById("firstpage");
    var secondpage = document.getElementById("secondpage");
    firstpage.style.display = "none";
    secondpage.style.display = "block";
}
function secondlast() {
    firstpage.style.display = "block";
    secondpage.style.display = "none";
}
function secondnext() {
    var thirdpage = document.getElementById("thirdpage");
    secondpage.style.display = "none";
    thirdpage.style.display = "block";
}
function thirdlast() {
    secondpage.style.display = "block";
    thirdpage.style.display = "none";
}
function thirdnext() {
    var forthpage = document.getElementById("forthpage");
    thirdpage.style.display = "none";
    secondpage.style.display = "none";
    forthpage.style.display = "block";
}
function forthlast() {
    thirdpage.style.display = "block";
    forthpage.style.display = "none";
}
function forthnext() {
    var fifthpage = document.getElementById("fifthpage");
    forthpage.style.display = "none";
    fifthpage.style.display = "block";
}
function fifthlast() {
    forthpage.style.display = "block";
    fifthpage.style.display = "none";
}
function fifthnext() {
    var sixthpage = document.getElementById("sixthpage");
    fifthpage.style.display = "none";
    sixthpage.style.display = "block";
}
function sixthlast() {
    fifthpage.style.display = "block";
    sixthpage.style.display = "none";
}
function sixthnext() {
    sixthpage.style.display = "none";
    seventhpage.style.display = "block";
}
function seventhlast() {
    sixthpage.style.display = "block";
    seventhpage.style.display = "none";
}
function check() {
    if (document.course_form.agree.checked) {
        document.course_form.Submit.disabled = false;
    }
    else
        document.course_form.Submit.disabled = true;
}

function topFunction() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
}


function ShowData() {
    var show_data = document.getElementById("contact_num").value;
    show_data += document.getElementById("phone_num").value;
    document.getElementById("contact_num").value = show_data;
}
