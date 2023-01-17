const { lastIndexOf, sum } = require("lodash");

$(document).ready(function () {
    var plant = [
        "Australia",
        "Bangladesh",
        "Denmark",
        "Hong Kong",
        "Indonesia",
        "Netherlands",
        "New Zealand",
        "South Africa",
    ];
    $("#plant").select2({
        data: plant,
    });
});
$(document).ready(function () {
    var clientgroup = [
        "Australia",
        "Bangladesh",
        "Denmark",
        "Hong Kong",
        "Indonesia",
        "Netherlands",
        "New Zealand",
        "South Africa",
    ];
    $("#clientgroup").select2({
        data: clientgroup,
    });
});
$(document).ready(function () {
    var clienttype = [
        "Australia",
        "Bangladesh",
        "Denmark",
        "Hong Kong",
        "Indonesia",
        "Netherlands",
        "New Zealand",
        "South Africa",
    ];
    $("#clienttype").select2({
        data: clienttype,
    });
});
$(document).ready(function () {
    var executive = [
        "Australia",
        "Bangladesh",
        "Denmark",
        "Hong Kong",
        "Indonesia",
        "Netherlands",
        "New Zealand",
        "South Africa",
    ];
    $("#executive").select2({
        data: executive,
    });
});
$(document).ready(function () {
    var parentClient = [
        "Australia",
        "Bangladesh",
        "Denmark",
        "Hong Kong",
        "Indonesia",
        "Netherlands",
        "New Zealand",
        "South Africa",
    ];
    $("#parentClient").select2({
        data: parentClient,
    });
});
$(document).ready(function () {
    var oldClient = [
        "Australia",
        "Bangladesh",
        "Denmark",
        "Hong Kong",
        "Indonesia",
        "Netherlands",
        "New Zealand",
        "South Africa",
    ];
    $("#oldClient").select2({
        data: oldClient,
    });
});
$(document).ready(function () {
    var pharmaClient = [
        "Australia",
        "Bangladesh",
        "Denmark",
        "Hong Kong",
        "Indonesia",
        "Netherlands",
        "New Zealand",
        "South Africa",
    ];
    $("#pharmaClient").select2({
        data: pharmaClient,
    });
});
$(document).ready(function () {
    var state = [
        "Australia",
        "Bangladesh",
        "Denmark",
        "Hong Kong",
        "Indonesia",
        "Netherlands",
        "New Zealand",
        "South Africa",
    ];
    $("#state").select2({
        data: state,
    });
});
$(document).ready(function () {
    var district = [
        "Australia",
        "Bangladesh",
        "Denmark",
        "Hong Kong",
        "Indonesia",
        "Netherlands",
        "New Zealand",
        "South Africa",
    ];
    $("#district").select2({
        data: district,
    });
});
$(document).ready(function () {
    var state1 = [
        "Australia",
        "Bangladesh",
        "Denmark",
        "Hong Kong",
        "Indonesia",
        "Netherlands",
        "New Zealand",
        "South Africa",
    ];
    $("#state1").select2({
        data: state1,
    });
});
$(document).ready(function () {
    var district1 = [
        "Australia",
        "Bangladesh",
        "Denmark",
        "Hong Kong",
        "Indonesia",
        "Netherlands",
        "New Zealand",
        "South Africa",
    ];
    $("#district1").select2({
        data: district1,
    });
});
$(document).ready(function () {
    var sendBill = ["To Parent Group", "To Client", "To Both"];
    $("#sendBill").select2({
        data: sendBill,
    });
});
$(document).ready(function () {
    var bilingType = ["Fixed Amount", "Per Bed", "Fixed Bed", "Per KG"];
    $("#bilingType").select2({
        data: bilingType,
    });
});
$(document).ready(function () {
    var enabled = ["YES", "NO"];
    $("#enabled").select2({
        data: enabled,
    });
});
$(document).ready(function () {
    var paymentType = ["CASH", "CHEQUE", "NEFT", "NETBANKING"];
    $("#paymentType").select2({
        data: paymentType,
    });
});
$(document).ready(function () {
    var typeConcern = [
        "Australia",
        "Bangladesh",
        "Denmark",
        "Hong Kong",
        "Indonesia",
        "Netherlands",
        "New Zealand",
        "South Africa",
    ];
    $("#typeConcern").select2({
        data: typeConcern,
    });
});
$(document).ready(function () {
    var isgstAplicable = ["Yes", "No"];
    $("#isgstAplicable").select2({
        data: isgstAplicable,
    });
});

function addFunction(dataTable) {
    var i;
    for (i = 0; i < 5; i++) {
        var table = document.getElementById(dataTable);
        var rowCount = table.rows.length + 1;
        var row = table.insertRow();

        var cell1 = row.insertCell(0);
        cell1.innerHTML = rowCount;
        document.getElementById("rowcount").innerHTML = rowCount;

        var cell2 = row.insertCell(1);
        var element2 = document.createElement("select");
        element2.type = "option";
        element2.name = "[Select]";
        element2.className = "form-control";
        element2.innerHTML = "<option value='client'>Select an option</option>";
        cell2.appendChild(element2);

        var cell3 = row.insertCell(2);
        var element3 = document.createElement("tr");
        element3.innerHTML =
            "<input type='checkbox' name='security'>Security ? <br><input type='checkbox' name='registration'>Registration ?";
        cell3.appendChild(element3);

        var cell4 = row.insertCell(3);
        var element4 = document.createElement("input");
        element4.type = "text";
        element4.name = "cheque[]";
        element4.className = "form-control";
        element4.placeholder = "Cheque No";
        cell4.appendChild(element4);

        var cell5 = row.insertCell(4);
        var element5 = document.createElement("input");
        element5.type = "date";
        element5.name = "date[]";
        element5.className = "form-control";
        cell5.appendChild(element5);

        var cell6 = row.insertCell(5);
        var element6 = document.createElement("select");
        element6.type = "option";
        element6.name = "client[]";
        element6.className = "form-control";
        element6.innerHTML = "<option value='client'>Select an option</option>";
        cell6.appendChild(element6);

        var cell7 = row.insertCell(6);
        var element7 = document.createElement("input");
        element7.type = "text";
        element7.name = "amount[]";
        element7.className = "form-control";
        element7.placeholder = "Amount";
        cell7.appendChild(element7);

        var cell8 = row.insertCell(7);
        var element8 = document.createElement("input");
        element8.type = "text";
        element8.name = "bill[]";
        element8.className = "form-control";
        element8.placeholder = "Bill No's";
        cell8.appendChild(element8);

        var cell9 = row.insertCell(8);
        var element9 = document.createElement("input");
        element9.type = "text";
        element9.name = "transaction[]";
        element9.className = "form-control";
        element9.placeholder = "Transaction";
        cell9.appendChild(element9);
    }
}

function deleteFunction(dataTable) {
    var table = document.getElementById(dataTable);
    var rowCount = table.rows.length - 1;
    table.deleteRow(rowCount);

    document.getElementById("rowcount").innerHTML = rowCount;
}

/* MouseOver And MouseOut Button */

function mouseover(id) {
    document.getElementById("submit_" + id).style.background =
        "rgb(89, 204, 138)";
}
function mouseOut(id) {
    document.getElementById("submit_" + id).style.background =
        "rgb(29, 181, 156)";
}

function toggle(id) {
    a = document.getElementById("hide_" + id);
    b = document.getElementById("show_" + id);
    if (a.style.display == "block") {
        a.style.display = "none";
        b.innerHTML = '<i class="fas fa-chevron-down"></i>';
    } else {
        a.style.display = "block";
        b.innerHTML = '<i class="fas fa-chevron-up"></i>';
    }
}
