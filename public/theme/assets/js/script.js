
// date picker   




             $(document).ready( function() {
                $(".datepicker").datepicker({
                   
                    dateFormat:"dd-mm-yy"
                });
              
                      // $("[type=date]").attr("type","text" );
                    date_format();
                  
            } )

      var isShift = false;
    var seperator = "-";
    // window.onload = function () {
        function date_format(){
        //Reference the Table.
        var tblForm = document.getElementById("tblForm");
 
        //Reference all INPUT elements in the Table.
        var inputs = document.getElementsByClassName("datepicker");
        // console.log(inputs);
        //Loop through all INPUT elements.
        for (var i = 0; i < inputs.length; i++) {
            //Check whether the INPUT element is TextBox.
            if (inputs[i].type == "text") {
                //Check whether Date Format Validation is required.
                if (inputs[i].className.indexOf("datepicker") != 1) {
                       
                    //Set Max Length.
                    inputs[i].setAttribute("maxlength", 10);
 
                    //Only allow Numeric Keys.
                    inputs[i].onkeydown = function (e) {
                        return IsNumeric(this, e.keyCode);
                    };
 
                    //Validate Date as User types.
                    inputs[i].onkeyup = function (e) {
                        ValidateDateFormat(this, e.keyCode);
                    };
                }
            }
        }
    };
 
    function IsNumeric(input, keyCode) {
        if (keyCode == 16) {
            isShift = true;
        }
        //Allow only Numeric Keys.
        if (((keyCode >= 48 && keyCode <= 57) || keyCode == 8 || keyCode <= 37 || keyCode <= 39 || (keyCode >= 96 && keyCode <= 105)) && isShift == false) {
            if ((input.value.length == 2 || input.value.length == 5) && keyCode != 8) {
                input.value += seperator;
            }
 
            return true;
        }
        else {
            return false;
        }
    };
 
    function ValidateDateFormat(input, keyCode) {
        var dateString = input.value;
        if (keyCode == 16) {
            isShift = false;
        }
        var regex = /(((0|1)[0-9]|2[0-9]|3[0-1])\/(0[1-9]|1[0-2])\/((19|20)\d\d))$/;
 
        //Check whether valid dd/MM/yyyy Date Format.
        if (regex.test(dateString) || dateString.length == 0) {
            ShowHideError(input, "none");
        } else {
            ShowHideError(input, "block");
        }
    };
   
 
    function ShowHideError(textbox, display) {
        var row = textbox.parentNode.parentNode;
        var errorMsg = row.getElementsByClassName("error_message")[0];
        if (errorMsg != null) {
            errorMsg.style.display = display;
        }
    };




// date year four digit restriction 

let alldateinput= document.querySelectorAll('[type="date"]');
alldateinput.forEach(each=>{
    each.setAttribute("max" , "9999-12-31");
})

// for row highlight 
function highlightRow(rowId) {
    $('.highlight').removeClass('highlight');
    $("#row_" + rowId).addClass("highlight");
}

// for required field


var allrequiredfield = document.querySelectorAll("[required]");
allrequiredfield.forEach((each) => {
    let label = each.parentElement.querySelector("label");
    //   console.log(label);
    if (label == null) {
        label = each.parentElement.parentElement.parentElement.querySelector("label")
    }
    var span = document.createElement("span");
    span.className = "text-danger fw-bolder";
    span.innerText = "*";
    if (label != null) {
        label.appendChild(span);
    }



})

$(document).ready(function () {

    $('form input').keydown(function(e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            // console.log('1113457890');
            var self = $(this), form = self.parents('form:eq(0)'), focusable, next;
            focusable = form.find('input:not([readonly])').filter(':visible');
            next = focusable.eq(focusable.index(this) + 1);
            next.focus();
            
            return false;
    
        }
    });

   


    // Initialize select2
    $(".fstdropdown-select").select2();
    // for cancel btn
    $(".blob-btn").click(function(){
       window.location.reload();
    })
});
document.onkeydown = function (e) {
    var e = e || window.event; // for IE to cover IEs window event-object
    if ((e.altKey && e.which == 83)) {
        e.preventDefault();
        var submitbtn = document.getElementsByClassName('blob-btn1');

        for (var i = 0; i < submitbtn.length; i++) {
            submitbtn[i].click();
        }
        return false;
    }
    if ((e.altKey && e.which == 78)) {
        document.getElementById("submitbtn").click();
    }
    if ((e.altKey && e.which == 71)) {
        e.preventDefault();
        var generatebtn = document.getElementsByClassName('blob-btn41');

        for (var i = 0; i < generatebtn.length; i++) {
            generatebtn[i].click();
        }
        return false;
    }
    if ((e.altKey && e.which == 67)) {
        e.preventDefault();
        var cancelbtn = document.getElementsByClassName('blob-btn');

        for (var i = 0; i < cancelbtn.length; i++) {
            cancelbtn[i].click();
        }
        return false;
    }
    if ((e.altKey && e.which == 65)) {
        e.preventDefault();
        var add_newbtn = document.getElementsByClassName('btn_new');
        // console.log(add_newbtn);
        for (var i = 0; i < add_newbtn.length; i++) {
            add_newbtn[i].click();
        }
        return false;
    }
}


// enter key press next field code
// $('body').on('keydown', 'input , #exampleModal , select , textarea ', function (e) {

//     if (e.key === "Enter") {
//         e.preventDefault();

//         $('#exampleModal').modal('hide');


//         var self = $(this), form = self.parents('form:eq(0)'), focusable, next;
//         focusable = form.find('input:not([readonly])').filter(':visible');
//         next = focusable.eq(focusable.index(this) + 1);
       
//         if (next.length) {
//             next.focus();
//             next.select();
//             next.trigger('click');

//         } else {
//             form.submit();


//         }
//         return false;
//     }
//     else if (e.which == "37") {
//         e.preventDefault();
//         var self = $(this), form = self.parents('form:eq(0)'), focusable, next;
//         focusable = form.find('input:not([readonly])').filter(':visible');
//         next = focusable.eq(focusable.index(this) - 1);
//         if (next.length) {
//             next.focus();
//             next.select();
//             next.trigger('click');

//         }
//         return false;
//     }
//     else if (e.which == "38") {
//         e.preventDefault();
//         var self = $(this), form = self.parents('form:eq(0)'), focusable, next;
//         focusable = form.find('input:not([readonly])').filter(':visible');
//         var all_bags = $(".bagheadings");
//         // console.log(all_bags);
//         if(all_bags.length!=0){
//         if (all_bags[0].style.display == "none") {
//             next = focusable.eq(focusable.index(this) - 4);
//         }
//         else {

//             next = focusable.eq(focusable.index(this) - 8);
//         }}
//         else{
//             next = focusable.eq(focusable.index(this) - 6); 
//         }
//         if (next.length) {
//             next.focus();
//             next.select();

//             next.trigger('click');
//         }
//         return false;
//     }
//     else if (e.which == "39") {
//         e.preventDefault();
//         var self = $(this), form = self.parents('form:eq(0)'), focusable, next;
//         focusable = form.find('input:not([readonly])').filter(':visible');
//         next = focusable.eq(focusable.index(this) + 1);
//         if (next.length) {
//             next.focus();
//             next.select();

//             next.trigger('click');
//         }
//         return false;
//     }
//     else if (e.which == "40") {
//         e.preventDefault();
//         var self = $(this), form = self.parents('form:eq(0)'), focusable, next;
//         focusable = form.find('input:not([readonly])').filter(':visible');
//         var all_bags = $(".bagheadings");
//         if(all_bags.length!=0){
//         if (all_bags[0].style.display == "none") {
//             next = focusable.eq(focusable.index(this) + 4);
//         }
//         else {

//             next = focusable.eq(focusable.index(this) + 8);
//         }}
//         else{
//             next = focusable.eq(focusable.index(this) + 6); 
//         }
//         if (next.length) {
//             next.focus();
//             next.select();
            
//             next.trigger('click');
//         }else{
//             focusable[0].focus();
//             focusable[0].select();
//             focusable[0].trigger('click');
//         }
//         return false;
//     }

    


// });


//enter key prevent defeult


//index page filtering on click of enter btn
$('#user-search , #user-search input').keydown(function(e) {
    if (e.keyCode == 13) {
        $('#user-search').submit();
    }
});

"use strict";
if (navigator.userAgent.indexOf("Firefox") != -1) {
    //  alert('some functionality of this website is not working properly in Firefox');
    var cancel_btn = document.getElementsByClassName("blob-btn");
    var submit_btn = document.getElementsByClassName("blob-btn1");
    var small_generate_btn = document.getElementsByClassName("blob-btn44");
    var generate_btn = document.getElementsByClassName("blob-btn41");
    var client_data_btn = document.getElementsByClassName("blob-btn5");
    var plant_wise_btn = document.getElementsByClassName("blob-btn40");
    var download_btn = document.getElementsByClassName("blob-btn4");
    var ledger_btn = document.getElementsByClassName("blob-btn42");
    var minus_btn = document.getElementsByClassName("blob-btn31");
    for (var i = 0; i < cancel_btn.length; i++) {
        cancel_btn[i].classList.add('cancelbtn');


    }
    for (var i = 0; i < download_btn.length; i++) {
        download_btn[i].classList.add('downloadbtn');


    }
    for (var i = 0; i < ledger_btn.length; i++) {
        ledger_btn[i].classList.add('ledgerbtn');


    }
    for (var n = 0; n < submit_btn.length; n++) {

        submit_btn[n].classList.add('submitbtn');

    }

    for (var j = 0; j < small_generate_btn.length; j++) {
        small_generate_btn[j].classList.add('smgeneratebtn');
    }
    for (var k = 0; k < generate_btn.length; k++) {
        generate_btn[k].classList.add('generatebtn');
    }
    for (var l = 0; l < client_data_btn.length; l++) {
        client_data_btn[l].classList.add('client_data_btn');
    }
    for (var m = 0; m < plant_wise_btn.length; m++) {
        plant_wise_btn[m].classList.add('plant_wise_btn');
    }
    for (var n = 0; n < minus_btn.length; n++) {
        minus_btn[n].classList.add('minus_btn');
    }
}
$(document).ready(function () {
    // card js start
    $(".card-header-right .close-card").on('click', function () {
        var $this = $(this);
        $this.parents('.card').animate({
            'opacity': '0',
            '-webkit-transform': 'scale3d(.3, .3, .3)',
            'transform': 'scale3d(.3, .3, .3)'
        });

        setTimeout(function () {
            $this.parents('.card').remove();
        }, 800);
    });
    $(".card-header-right .reload-card").on('click', function () {
        var $this = $(this);
        $this.parents('.card').addClass("card-load");
        $this.parents('.card').append('<div class="card-loader"><i class="feather icon-radio rotate-refresh"></div>');
        setTimeout(function () {
            $this.parents('.card').children(".card-loader").remove();
            $this.parents('.card').removeClass("card-load");
        }, 3000);
    });
    $(".card-header-right .card-option .open-card-option").on('click', function () {
        var $this = $(this);
        if ($this.hasClass('icon-x')) {
            $this.parents('.card-option').animate({
                'width': '30px',
            });
            $this.parents('.card-option').children('li').children(".open-card-option").removeClass("icon-x").fadeIn('slow');
            $this.parents('.card-option').children('li').children(".open-card-option").addClass("icon-chevron-left").fadeIn('slow');
            $this.parents('.card-option').children(".first-opt").fadeIn();
        } else {
            $this.parents('.card-option').animate({
                'width': '130px',
            });
            $this.parents('.card-option').children('li').children(".open-card-option").addClass("icon-x").fadeIn('slow');
            $this.parents('.card-option').children('li').children(".open-card-option").removeClass("icon-chevron-left").fadeIn('slow');
            $this.parents('.card-option').children(".first-opt").fadeOut();
        }
    });
    $(".card-header-right .minimize-card").on('click', function () {
        var $this = $(this);
        var port = $($this.parents('.card'));
        var card = $(port).children('.card-block').slideToggle();
        $(this).toggleClass("icon-minus").fadeIn('slow');
        $(this).toggleClass("icon-plus").fadeIn('slow');
    });
    $(".card-header-right .full-card").on('click', function () {
        var $this = $(this);
        var port = $($this.parents('.card'));
        port.toggleClass("full-card");
        $(this).toggleClass("icon-minimize");
        $(this).toggleClass("icon-maximize");
    });
    $("#more-details").on('click', function () {
        $(".more-details").slideToggle(500);
    });
    $(".mobile-options").on('click', function () {
        $(".navbar-container .nav-right").slideToggle('slow');
    });
    $(".search-btn").on('click', function () {
        $(".main-search").addClass('open');
        $('.main-search .form-control').animate({
            'width': '200px',
        });
    });
    $(".search-close").on('click', function () {
        $('.main-search .form-control').animate({
            'width': '0',
        });
        setTimeout(function () {
            $(".main-search").removeClass('open');
        }, 300);
    });
    // card js end
    $("#styleSelector .style-cont").slimScroll({
        setTop: "1px",
        height: "calc(100vh - 480px)",
    });
    /*chatbar js start*/
    /*chat box scroll*/
    var a = $(window).height() - 80;
    $(".main-friend-list").slimScroll({
        height: a,
        allowPageScroll: false,
        wheelStep: 5
    });
    var a = $(window).height() - 155;
    $(".main-friend-chat").slimScroll({
        height: a,
        allowPageScroll: false,
        wheelStep: 5
    });

    // search
    $("#search-friends").on("keyup", function () {
        var g = $(this).val().toLowerCase();
        $(".userlist-box .media-body .chat-header").each(function () {
            var s = $(this).text().toLowerCase();
            $(this).closest('.userlist-box')[s.indexOf(g) !== -1 ? 'show' : 'hide']();
        });
    });

    // open chat box
    $('.displayChatbox').on('click', function () {
        var my_val = $('.pcoded').attr('vertical-placement');
        if (my_val == 'right') {
            var options = {
                direction: 'left'
            };
        } else {
            var options = {
                direction: 'right'
            };
        }
        $('.showChat').toggle('slide', options, 500);
    });

    //open friend chat
    $('.userlist-box').on('click', function () {
        var my_val = $('.pcoded').attr('vertical-placement');
        if (my_val == 'right') {
            var options = {
                direction: 'left'
            };
        } else {
            var options = {
                direction: 'right'
            };
        }
        $('.showChat_inner').toggle('slide', options, 500);
    });
    //back to main chatbar
    $('.back_chatBox').on('click', function () {
        var my_val = $('.pcoded').attr('vertical-placement');
        if (my_val == 'right') {
            var options = {
                direction: 'left'
            };
        } else {
            var options = {
                direction: 'right'
            };
        }
        $('.showChat_inner').toggle('slide', options, 500);
        $('.showChat').css('display', 'block');
    });
    $('.back_friendlist').on('click', function () {
        var my_val = $('.pcoded').attr('vertical-placement');
        if (my_val == 'right') {
            var options = {
                direction: 'left'
            };
        } else {
            var options = {
                direction: 'right'
            };
        }
        $('.p-chat-user').toggle('slide', options, 500);
        $('.showChat').css('display', 'block');
    });
    // /*chatbar js end*/
    $('[data-toggle="tooltip"]').tooltip();

    // wave effect js
    Waves.init();
    Waves.attach('.flat-buttons', ['waves-button']);
    Waves.attach('.float-buttons', ['waves-button', 'waves-float']);
    Waves.attach('.float-button-light', ['waves-button', 'waves-float', 'waves-light']);
    Waves.attach('.flat-buttons', ['waves-button', 'waves-float', 'waves-light', 'flat-buttons']);

    // $('#mobile-collapse i').addClass('icon-toggle-right');
    // $('#mobile-collapse').on('click', function() {
    //     $('#mobile-collapse i').toggleClass('icon-toggle-right');
    //     $('#mobile-collapse i').toggleClass('icon-toggle-left');
    // });
    // materia form

    $('.form-control').on('blur', function () {
        if ($(this).val().length > 0) {
            $(this).addClass("fill");
        } else {
            $(this).removeClass("fill");
        }
    });
    $('.form-control').on('focus', function () {
        $(this).addClass("fill");
    });
    $('#mobile-collapse i').addClass('icon-toggle-right');
    $('#mobile-collapse').on('click', function () {
        $('#mobile-collapse i').toggleClass('icon-toggle-right');
        $('#mobile-collapse i').toggleClass('icon-toggle-left');
    });
});
$(document).ready(function () {
    var $window = $(window);
    // $('.loader-bar').animate({
    //     width: $window.width()
    // }, 1000);
    // setTimeout(function() {
    // while ($('.loader-bar').width() == $window.width()) {
    // $(window).on('load',function(){
    $('.loader-bg').fadeOut();
    // });

    // break;

    // }
    // }, 2000);
});

// toggle full screen
function toggleFullScreen() {
    var a = $(window).height() - 10;

    if (!document.fullscreenElement && // alternative standard method
        !document.mozFullScreenElement && !document.webkitFullscreenElement) { // current working methods
        if (document.documentElement.requestFullscreen) {
            document.documentElement.requestFullscreen();
        } else if (document.documentElement.mozRequestFullScreen) {
            document.documentElement.mozRequestFullScreen();
        } else if (document.documentElement.webkitRequestFullscreen) {
            document.documentElement.webkitRequestFullscreen(Element.ALLOW_KEYBOARD_INPUT);
        }
    } else {
        if (document.cancelFullScreen) {
            document.cancelFullScreen();
        } else if (document.mozCancelFullScreen) {
            document.mozCancelFullScreen();
        } else if (document.webkitCancelFullScreen) {
            document.webkitCancelFullScreen();
        }
    }
    $('.full-screen').toggleClass('icon-maximize');
    $('.full-screen').toggleClass('icon-minimize');
}
function myFunction1() {
    var checkBox = document.getElementById("myCheck");
    var text = document.getElementById("text");

    if (checkBox.checked == true) {
        text.style.display = "flex";

    } else {
        text.style.display = "none";

    }
}
function myFunction23() {
    // console.log("called");
    var checkBox = document.getElementById("myCheck23");
    var optionvaluediv = document.getElementById("increment_by_value_div");
    var text = document.getElementById("text23");

    if (checkBox.checked == true) {
        text.style.display = "flex";
        optionvaluediv.style.display = "none";
    } else {
        text.style.display = "none";

    }
}


function rateincrementoption(elem) {
    if (elem.checked == true) {

        document.getElementById("rate_increment_option").style.display = "flex";

    }
    else {
        document.getElementById("rate_increment_option").style.display = "none";
        document.getElementById("increment_by_value_div").style.display = "none";
        document.getElementById("text23").style.display = "none";
    }



}




function incrementbyvalue(elem) {
    var text = document.getElementById("text23");
    if (elem.checked == true) {

        document.getElementById("increment_by_value_div").style.display = "flex";
        text.style.display = "none";
    }
    else {
        document.getElementById("increment_by_value_div").style.display = "none";
    }



}

// $(function () {
//     $("#chkPassport").click(function () {
//         if ($(this).is(":checked")) {
//             $("#dvPassport").hide();
//             $("#AddPassport").show();
//         } else {
//             $("#dvPassport").show();
//             $("#AddPassport").hide();
//         }
//     });
// });
function showSupply() {
    var occupancy = document.getElementById("chkPassport");
    var dvPassport = document.getElementById("dvPassport");
    var AddPassport = document.getElementById("AddPassport");
    if (occupancy.checked == true) {
        dvPassport.style.display = "none";
        AddPassport.style.display = "block";
    } else {
        dvPassport.style.display = "block";
        AddPassport.style.display = "none";
    }
}
function show1() {
    document.getElementById('div1').style.display = 'none';
}
function show2() {
    document.getElementById('div1').style.display = 'block';
}
function myFunction2() {
    var checkBox = document.getElementById("myCheck1");
    var text = document.getElementById("text1");

    if (checkBox.checked == true) {
        text.style.display = "block";

    } else {
        text.style.display = "none";

    }
}
function myFunction3() {
    var checkBox = document.getElementById("myCheck2");
    var text = document.getElementById("text2");

    if (checkBox.checked == true) {
        text.style.display = "block";

    } else {
        text.style.display = "none";

    }
}
function myFunction4() {
    var checkBox = document.getElementById("myCheck3");
    var text = document.getElementById("text3");

    if (checkBox.checked == true) {
        text.style.display = "flex";

    } else {
        text.style.display = "none";

    }
}
function myFunction5() {
    var checkBox = document.getElementById("myCheck5");
    var text = document.getElementById("text5");

    if (checkBox.checked == true) {
        text.style.display = "block";

    } else {
        text.style.display = "none";

    }
}
function show3() {
    document.getElementById('div2').style.display = 'none';
}
function show4() {
    document.getElementById('div2').style.display = 'block';
}

function sendbilltoggle(val) {
    if (val != '') {
        document.getElementById("where_to_send_bill").style.display = "block";
    }
    else {
        document.getElementById("where_to_send_bill").style.display = "none";
    }
}
$('#select_box2').change(function () {
    var select = $(this).find(':selected').val();
    $(".hide1").hide();
    $('#' + select).show();

}).change();
function toggledisable(elem) {
    console.log(elem.checked);
    if (elem.checked == true) {
        document.getElementById("submit").removeAttribute("disabled");
    } else {
        document.getElementById("submit").setAttribute("disabled", "disabled");
    }
}
$('#checked').click(function () {
    if ($(this).is(':checked')) {
        $('#submitted').removeAttr('disabled');
    } else {
        $('#submitted').attr('disabled', 'disabled');
    }
});

function EnableDisableTextBox(chk) {
    var txt = document.getElementById("txt");
    txt.disabled = chk.checked ? false : true;
    if (!txt.disabled) {
        txt.focus();
    }
}

function paper_fn() {
    var checkBox = document.getElementById("myCheckgrv");
    var paper_book = document.getElementById("paper_book");
    var paper_book1 = document.getElementById("paper_book1");
    var AddPassport12 = document.getElementById("dvPassport");

    if (checkBox.checked == true) {
        paper_book.style.display = "block";
        paper_book1.style.display = "block";
        showSupply()

    } else {
        paper_book.style.display = "none";
        paper_book1.style.display = "none";
        AddPassport12.style.display = "none";
    }
}
//delete row
$(".btnDeleteRow").click(function () {
    var rowCount = $(this).closest('table').find('tbody').length;
    if (rowCount > 1) {
        $(this).closest('tbody').remove();
    }
    rowCount--;
    if (rowCount <= 1) {
        $(document).find('.btnDeleteRow').prop('disabled', true);
    }
});

//add row
$(".btnAddRow").click(function () {
    var table = $(this).closest('table');
    var lastRow = table.find('tbody').last();
    var newRow = lastRow.clone(true, true);
    newRow.find('input, textarea, select').val('');
    newRow.find('.growTextarea').css('height', 'auto');
    newRow.insertAfter(lastRow);
    table.find('.btnDeleteRow').removeAttr("disabled");
});



// growTextarea function: use for testing that the the javascript
// is also copied when row is cloned.  to confirm, 
// type several lines into Location, add a row, & repeat

function growTextarea(i, elem) {
    var elem = $(elem);
    var resizeTextarea = function (elem) {
        var scrollLeft = window.pageXOffset || (document.documentElement || document.body.parentNode || document.body).scrollLeft;
        var scrollTop = window.pageYOffset || (document.documentElement || document.body.parentNode || document.body).scrollTop;
        elem.css('height', 'auto').css('height', elem.prop('scrollHeight'));
        window.scrollTo(scrollLeft, scrollTop);
    };

    elem.on('input', function () {
        resizeTextarea($(this));
    });

    resizeTextarea($(elem));
}

$('.growTextarea').each(growTextarea);
function processDate(dateString) {
    var splitString = dateString.split("/");
    var d = parseInt(splitString[0], 10),
        m = parseInt(splitString[1], 10),
        y = parseInt(splitString[2], 10);

    var dateToReturn = new Date(y, m - 1, d);
    return dateToReturn;
}
var firstOfFinancialYear = processDate("09/10/2021");

var lastOfFinancialYear = processDate("29/10/2021");

var firstOfFinancialYear2 = processDate("01/04/2021");

var lastOfFinancialYear2 = processDate("29/10/2021");
var counter = 0;
var totalRowAvl = 0;
var showInactive = "no";
function hideProcessing() {
    $.unblockUI();
}
$(document).ready(function () {
    $(":input[data-inputmask-mask]").inputmask();
    $(":input[data-inputmask-alias]").inputmask();
    $(":input[data-inputmask-regex]").inputmask("Regex");

    $('.select2statusclient').select2({ width: '10%' });


    $(":input[data-inputmask-mask]").inputmask();
    $(":input[data-inputmask-alias]").inputmask();
    $(":input[data-inputmask-regex]").inputmask("Regex");
    $(".datepicker").keypress(function (event) { event.preventDefault(); });
    $('.datepicker').datepicker({
        clearBtn: true,
        todayHighlight: true,
        autoclose: true
    });
    /*              $("input").iCheck({
                    checkboxClass : "icheckbox_square-blue",
                    radioClass : "iradio_square-blue"
                }); */
    $('.datepicker').datepicker('update', new Date());
    $(".datepicker").keypress(function (event) { event.preventDefault(); });
    $("#saveChanges").click(function () {
        $(".errorborder").removeClass('errorborder');
        $("#validationError").text("");
        var isError = false;
        var rowCountTbl = $('#myTable tr').length;
        if (isError == false) {

            $(".checkDate").each(function () {
                if ($(this).val() != "" && $(this).val() != null) {
                    var date = $(this).val().split("/");
                    var d = parseInt(date[0], 10),
                        m = parseInt(date[1], 10),
                        y = parseInt(date[2], 10);

                    var timestamp = processDate($(this).val());

                    if (isNaN(timestamp) == false) {

                        var dateToCheck = new Date(y, m - 1, d);

                        if (firstOfFinancialYear <= dateToCheck && lastOfFinancialYear >= dateToCheck && firstOfFinancialYear2 <= dateToCheck && lastOfFinancialYear2 >= dateToCheck) {

                        }
                        else {
                            $(this).focus();
                            $(this).addClass('errorborder');
                            $("#validationError").text("Check Date , This date input not allowed !!");
                            isError = true;
                            hideProcessing();

                            return false;
                        }

                    }
                    else {
                        $(this).focus();
                        $(this).addClass('errorborder');
                        $("#validationError").text("Check Date input !");
                        isError = true;
                        hideProcessing();

                        return false;
                    }



                }
                else {
                    $(this).focus();
                    $(this).addClass('errorborder');
                    $("#validationError").text("Check Date input !");
                    isError = true;
                    hideProcessing();

                    return false;
                }

            });


        }


        //Check No Validation
        if (isError == false) {
            $('.cno').each(function (i, obj) {
                if ($(obj).val() != "" && $(obj).val().length < 6) {
                    $(obj).focus();
                    $(obj).addClass('errorborder');
                    $("#validationError").text("Cheque number should be 6 digit number");
                    isError = true;
                    hideProcessing();
                    return false;
                }
            });
        }
        if (isError == false) {
            //Date Validation
            $('.select2statusclient').each(function (i, obj) {

                if ($(obj).val() == null) {
                    $(obj).focus();
                    $(obj).addClass('errorborder');
                    $("#validationError").text("Select Client To Proceed");
                    isError = true;
                    hideProcessing();
                    return false;
                }
            });
        }
        if (isError == false) {
            //Date Validation
            $('.datei').each(function (i, obj) {
                if ($(obj).val().trim() == "" || $(obj).val().match(/[a-z]/i)) {
                    $(obj).focus();
                    $(obj).addClass('errorborder');
                    $("#validationError").text("Date can't be empty or Date is Invalid ");
                    isError = true;
                    hideProcessing();
                    return false;
                }
            });
        }
        if (isError == false) {
            //Amount Validation
            $('.amounti').each(function (i, obj) {
                if ($(obj).val().trim() == "") {
                    $(obj).focus();
                    $(obj).addClass('errorborder');
                    $("#validationError").text("Please enter the amount");
                    isError = true;
                    hideProcessing();
                    return false;
                }
                else if ($(obj).val().trim().startsWith("0") || $(obj).val().trim().startsWith("0.")) {
                    $(obj).focus();
                    $(obj).addClass('errorborder');
                    $("#validationError").text("Please enter the valid amount");
                    isError = true;
                    hideProcessing();
                    return false;
                }
            });
        }
        if (isError == false) {
            //if no row in table
            if (rowCountTbl < 4) {
                $("#validationError").text("Please add records before save changes");
                isError = true;
                hideProcessing();
                return false;
            }
        }


        if (isError == false) {
            $("#bulkPaymentCheque").submit();
        }
        else {
            return false;
        }
    });


    $("#addrow").on("click", function () {
        for (i = 0; i < 5; i++) {
            addRows();
        }
        postAddAction();
    });


    $("#removerow").click(function () {
        $('#myTable>tbody tr:last').remove();
        counter--;
        totalRowAvl--;
        $(".totalRecords").text(totalRowAvl);
        var tAmnt = 0;
        $('.amounti').each(function (i, obj) {
            if ($(obj).val().trim() != "" && !isNaN($(obj).val().trim())) {
                tAmnt += parseInt($(obj).val().trim(), 10);
            }
        });
        $(".totalAmount").text(tAmnt);
    });

});

function defaultRows() {
    for (i = 0; i < 5; i++) {
        addRows();
    }
    postAddAction();
}


function onChangeActionSecurity(counter) {
    /*      alert("security"+counter+$('[name="paymentCheques['+counter+'].security"]').val()); */
    if ($('[name="paymentCheques[' + counter + '].security"]').prop("checked") == true) {

        $('[name="paymentCheques[' + counter + '].registration"]').prop("checked", false);
    }
    if ($('[name="paymentCheques[' + counter + '].security"]').prop("checked") == true) {

    }
    /*      if()
                {
                
                }
            $('[name="paymentCheques['+counter+'].security"]').prop; */
}
function onChangeActionRegistration(counter) {
    if ($('[name="paymentCheques[' + counter + '].registration"]').prop("checked") == true) {

        $('[name="paymentCheques[' + counter + '].security"]').prop("checked", false);
    }
}
function addRows() {
    var newRow = $("<tr>");
    var cols = "";

    cols += '<td><strong>' + (counter + 1) + '</strong></td>';
    cols += '<td  ><select style="width: 10%" class="select2statusclient select2-container select2-selection--single select2-selection__rendered "  name="paymentCheques[' + counter + '].client"></select></td>';
    cols += '<td style="text-align: center;"><div class="icheck2 skin row"><input class="form-check-input" type="checkbox" onchange=onChangeActionSecurity(' + counter + ') name="paymentCheques[' + counter + '].security" /><label>Security ?</label></div><div class="icheck2 skin"><input class="form-check-input" onchange=onChangeActionRegistration(' + counter + ') type="checkbox" name="paymentCheques[' + counter + '].registration" /><label>Registration ?</label></div></td>';
    cols += '<td><input placeholder="Cheque No" type="text" class="cno form-control numericonly" maxlength="6" name="paymentCheques[' + counter + '].chequeNo"/></td>';
    cols += '<td><input placeholder="Date" data-inputmask-alias="dd/mm/yyyy"' + 'data-inputmask="\'yearrange\': { \'minyear\': \'2019\', \'maxyear\': \'2021\' }"' + '" data-val="true" data-val-required="Required" placeholder="mm/dd/yyyy" value="" type="text" data-date-format="dd/mm/yyyy" class="datei  form-control" name="paymentCheques[' + counter + '].date"/></td>';
    cols += '<td><select class="select2status" name="paymentCheques[' + counter + '].bank"/></td>';
    cols += '<td><input placeholder="Amount" type="text" maxlength="10" class="amounti form-control currencyonly" name="paymentCheques[' + counter + '].amount"/></td>';
    cols += '<td><input placeholder="Bill No.s" type="text" maxlength="20" class="form-control alphanumeric" name="paymentCheques[' + counter + '].billNos"/></td>';
    cols += '<td><input placeholder="Transaction Id" type="text" maxlength="20" class="form-control alphanumeric" name="paymentCheques[' + counter + '].transactionId"/></td>';

    newRow.append(cols);
    $("table.order-list").append(newRow);
    counter++;
    totalRowAvl++;
    $(".totalRecords").text(totalRowAvl);


    $(".form-control:first").focus();
}

var bank = '{"ALB":"Allahabad Bank","AUGB":"Allahabad Up Gramin Bank","ANB":"Andhra Bank","AUSFB":"Au Small Financial Bank","AXIS":"Axis Bank","BAND.B":"Bandhan Bank","BOB":"Bank of Baroda","BOI":"Bank of India","BOM":"Bank of Maharashtra","BMB":"Bombay  Mercantil Bank","CAN.B.":"Canara Bank","CBC":"Central Bank Of Commerce","CBI":"Central Bank of India","CITI":"Citi Bank","CCBL":"Citizen Coop Bank Ltd","COOP":"Co-operative Bank","CORP.B":"Corporation Bank","DBGB":"Dakshin Bihar Gramin Bank","DENA B":"Dena Bank","DCOB":"District Cooperative Bank","FED.B.":"Federal Bank","GBA":"Gramin Bank Of Aryavant","HGB":"Haryana Gramin Bank","HDFC":"Hdfc Bank","IDFC":"I D F C Bank","ICICI":"Icici Bank","IDBIB":"IDBI Bank","IND.B":"Indian Bank","IOB":"Indian Overseas Bank","INDUSL":"Induslnd Bank ","J\u0026K":"Jammu \u0026 Kashmir Bank","JSFB":"Jana Small Finance Bank","KRBANK":"Karnatka Bank","KVB":"Karur Vaisaya Bank","KMB":"Kotak Mahindra Bank","MBGB":"Madhya Bihar Gramin Bank","MSUCOB":"Mansarovar Urban Cooperative Bank","MDCB":"Md Cooperative Bank","NNB":"Nainital Bank","NDACOB":"Noida Commercial Cooperative Ltd Bank","OBC":"Oriental Bank of Commerce","OTH":"Others","PSB":"Punjab and Sind Bank","PNB":"Punjab National Bank","RBL":"Ratnakar Bank Limited","SHGB":"Sarva Haryana Gramin Bank","SUPB":"Sarva Up Bank","SSFM":"Shivalik Small Finance Bank","SMCOB":"Shree Mahaveer Co-operative Bank","SFB":"Small Finance Bank","SOIB":"South Indian Bank","STACHA":"Standard Chartered","SBI":"State Bank of India","SYB":"Syndicate Bank","TMB":"Tamilnad Mercantile Bank Ltd.","TEST":"Test2","TBUCB":"The Bijnor Urban Company-cooperative Bank Ltd","GMUCB":"The Ganga Mercantile Urban Cooperative Bank Ltd","TNBL":"The Nainital Bank Ltd","UCO":"UCO Bank","UBI":"Union Bank of India","UNI":"United Bank of India","UCOL":"Urban Cooperative Ltd","USFB":"Utkarsh Small Finance Bank","VB":"Vijaya Bank","YESBAN":"Yes Bank ","ZILASA":"Zila Sahkari Bank"}';
var bankObj = jQuery.parseJSON(bank);

var options = [];
$.each(bankObj, function (key, value) {
    options.push({ id: key, text: key })
});
options.push({ id: 'DIRECT DEPOSIT', text: 'DIRECT DEPOSIT' });
options.push({ id: 'NEFT', text: 'NEFT' });
options.push({ id: 'IMPS', text: 'IMPS' });
options.push({ id: 'UPI', text: 'UPI' });

var bankHeads = '{"Hd24ONFnc-Li8U1Q7jV4kQ":"Axis Bank Ltd. (4588) -  GH : Bank Accounts , DL","LYfcWtNj9EXR8UPVRySlHg":"INDUSIND BANK LTD. (79598) -  GH : Bank Accounts , DL","hpw6Iw4488fOHSgENPWJqQ":"HDFC Bank Ltd (Auto Set) -  GH : Bank Accounts , DL","b2MvQwhzqBLYQQGPH8drZw":"Bank of Maharastra -  GH : Bank Accounts , DL","asFeLCIa_xdQssCOaGhDcg":"Cash -  GH : Cash In Hand , DL","U_Nl2t3FNISA6ZhtuL53Gg":"Punjab National Bank-3288 -  GH : Bank Accounts , DL","2RGwgbO3YQ2nkEx3U899Fw":"Axis Bank Ltd (Auto Set) -  GH : Bank Accounts , DL","H3MwxHvMvZSlcYmNuEZGRw":"Axis Bank Ltd-4588 - not in use -  GH : Bank Accounts , DL","6bGceioyk6eP_JNq7p5Ulg":"Punjab National Bank-2322 -  GH : Bank Accounts , DL","t5RDhGeDOMJG6zHJPead0g":"PNBank (Auto Set) -  GH : Bank Accounts , DL"}';
var bankHeadsObj = jQuery.parseJSON(bankHeads);

var optionBankHeads = [];
$.each(bankHeadsObj, function (key, value) {
    optionBankHeads.push({ id: key, text: value })
});
$(".select2statusbankhead").select2({
    width: '100%',
    data: optionBankHeads
});
$('#bankAccountingHeadId').select2('open');
//var clients = '';
//var clientsObj = jQuery.parseJSON(clients);
//var optionsClient = [];
//$.each(clientsObj, function(key, value) {
//  optionsClient.push({id:key, text:value})
//});

function postAddAction() {
    /*          $("input").iCheck({
                    checkboxClass : "icheckbox_square-blue",
                    radioClass : "iradio_square-blue"
                }); */
    $(":input[data-inputmask-mask]").inputmask();
    $(":input[data-inputmask-alias]").inputmask();
    $(":input[data-inputmask-regex]").inputmask("Regex");
    $(".amounti").keyup(function () {
        var tAmnt = 0;
        $('.amounti').each(function (i, obj) {
            if ($(obj).val().trim() != "" && !isNaN($(obj).val().trim())) {
                tAmnt += parseInt($(obj).val().trim(), 10);
            }
        });
        $(".totalAmount").text(tAmnt);
    });

    $(".datepicker").keypress(function (event) { event.preventDefault(); });
    $('.datepicker').datepicker({
        clearBtn: true,
        todayHighlight: true,
        autoclose: true
    });

    $(".select2status").select2({
        width: '100%',
        data: options
    });
    $('#showInactive').change(function () {
        //alert($('#showInactiveVar').val());
        if ($('#showInactive').prop("checked") == true) {
            $('#showInactiveVar').val("all");
        }
        else {
            $('#showInactiveVar').val("no");
        }
        //alert($('#showInactiveVar').val());
        initializeAjaxClient();
    });
    initializeAjaxClient();
    /* $(".select2statusclient").select2({   
         width: '100%',
         ajax:{
                url : '/getAllClientHcfPharmaWithAddressWithKeyword?filter='+$('#showInactiveVar').val(),
                dataType : 'json',
                processResults : function(data){
                    return {
                        results : data.results
                    }
                }
            },
            minimumInputLength: 2,
            formatInputTooShort: function () {
            return "Enter atleast 2 Character";
            }, 
            dropdownAutoWidth : true,
            dropdownCssClass : 'bigdrop',
            allowClear: true,
            placeholder : 'Select an option...',
        templateResult: format,
         dropdownAutoWidth : true,
          templateSelection: function (selection) {
                return selection.text.split('##')[0].split(", Main")[0];
              }
        }); */
    $('.select2statusclient').on('select2:opening', function (e) {
        if ($(this).val() != null) {
            showDetailsOfClient($(this).val());
        }
    });
    $('.select2statusclient').on('select2:select', function (e) {
        if ($(this).val() != null) {
            showDetailsOfClient($(this).val());
        }
    });
    $('.select2statusclient').change(function () {
        if ($(this).val() != null) {
            showDetailsOfClient($(this).val());
        }
    });
    /*        $('body').on({
                    mouseenter: function () {
                         var highlighted_item = $(this).text();
                         alert(highlighted_item);
                     // CODE   
                    },
                    mouseleave: function () {
                    // CODE
                    }
                }, '.select2-results__option.select2-results__option--highlighted');
    
             *///$(".select2statusclient").select2({dropdownCssClass : 'bigdrop'}); 
    $(".currencyonly").keyup(function () {
        var val = $(this).val();
        if (isNaN(val)) {
            val = val.replace(/[^0-9\.]/g, '');
            if (val.split('.').length > 2)
                val = val.replace(/\.+$/, "");
        }
        $(this).val(val);
    });
    $(".numericonly").keypress(function (e) {
        var node = $(this);
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            node.attr("placeholder", "Numeric only");
            return false;
        }
    });
    $(".allow_only_numbers").keydown(function (e) {
        var node = $(this);
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
            // Allow: Ctrl+A,Ctrl+C,Ctrl+V, Command+A
            ((e.keyCode == 65 || e.keyCode == 86 || e.keyCode == 67) && (e.ctrlKey === true || e.metaKey === true)) ||
            // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
            // let it happen, don't do anything
            return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            node.attr("placeholder", "NUMERIC");
            e.preventDefault();
        }
    });
    hideProcessing()
}

function initializeAjaxClient() {

    $(".select2statusclient").select2({
        width: '100%',
        ajax: {
            url: '/getAllClientHcfPharmaWithAddressWithKeyword?filter=' + $('#showInactiveVar').val(),
            dataType: 'json',
            processResults: function (data) {
                return {
                    results: data.results
                }
            }
        },
        minimumInputLength: 2,
        formatInputTooShort: function () {
            return "Enter atleast 2 Character";
        },
        dropdownAutoWidth: false,
        dropdownCssClass: 'bigdrop',
        allowClear: true,
        placeholder: 'Select an option...',
        templateResult: format,
        dropdownAutoWidth: false,
        templateSelection: function (selection) {
            return selection.text.split('##')[0].split(", Main")[0];
        }
    });
}


$(document).ready(function () {
    $("#id_payments").addClass("active");

    msgm = '';
    errorm = '';
    if (msgm != '') {
        swal("DONE!", msgm, "success");
    }
    if (errorm != '') {
        swal(
            'Oops...',
            'Something went wrong!',
            'error'
        )
    }
});
function format(d) {

    if (!d.id) {
        return d.text;
    }
    var fixedAmount = null;
    if (d.text.split('##').length == "4") {
        fixedAmount = '<span>' + d.text.split('##')[3] + '</span>';
    }
    else {
        fixedAmount = "";
    }
    var $d = $(
        '<span><strong><i class="icon-briefcase4"></i> ' + d.text.split('##')[0] + '</strong><br/><strong>' + fixedAmount
    );
    return $d;
};
/*        $(window).on('beforeunload', function(e){
              
              

              var c=confirm();
              if(c){
                return true;
              }
              else
              return false;
              }); */

function showDetailsOfClient(token) {
    $.ajax({
        url: 'getDetailsForPaymentEntry?token=' + token,
        dataType: 'json',
        type: 'GET',
        processData: false,
        contentType: false,
        error: function (jqXHR, textStatus, errorMessage) {
            console.log(errorMessage); // Optional
        },
        success: function (data) {
            console.log(data);
            $('#detailsDiv').html('');
            var detailToShow = '';
            detailToShow += '<p> Type : ' + data.type + '</p>\n';
            detailToShow += '<p> Route : ' + data.route + '</p>\n';
            detailToShow += '<p> Main : ' + data.main_balance + '</p>\n';
            detailToShow += '<p> Security : ' + data.security_balance + '</p>\n';
            $('#detailsDiv').append(detailToShow);
            //console.log(data.cfaddressPincode);

        }
    });
}
$(document).ready(function () {
    $('.confirm').click(function (e) {
        var url = $(this).attr('href');
        e.preventDefault();
        swal({
            title: "Are you want to go ahead ?",
            text: "Confirm your choice !",
            icon: "warning",
            buttons: [
                'No, cancel it!',
                'Yes, I am sure!'
            ],
            dangerMode: false,
        }).then(function (isConfirm) {
            if (isConfirm) {

                window.location = url;

            }
            else {

                e.stopPropagation();

            }
        })
        /*         
                   
                   e.preventDefault();
                   e.stopPropagation();
                   alert("hi"); */
    });
});
//exporte les données sélectionnées
var $table = $('#table');
$(function () {
    $('#toolbar').find('select').change(function () {
        $table.bootstrapTable('refreshOptions', {
            exportDataType: $(this).val()
        });
    });
})

var trBoldBlue = $("table");


$(trBoldBlue).on("click", "tr", function () {
    $(this).toggleClass("bold-blue");
});

