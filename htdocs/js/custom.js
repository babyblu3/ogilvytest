function showChequeFormat() {
    
    //manually trigger validation
    if($("#the-form")[0].checkValidity()) {
        var xmlhttp = new XMLHttpRequest();
        var params = $('form').serialize();

        //Call output results to the page when the state (request) changes
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var parentNode = document.getElementById("form-results");
                parentNode.removeChild(parentNode.childNodes[0]);
                writeResults(parentNode);
                
                myObj = JSON.parse(this.responseText);
                document.getElementById("result_payeename").innerHTML = myObj.payeename;
                document.getElementById("currency-format-numeric").innerHTML = myObj.currencynumeric;
                document.getElementById("currency-format-words").innerHTML = myObj.currencywords;
            }
        };            

        //open a POST request and send the proper header information along with the request
        xmlhttp.open("POST", "process.php", true);
        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xmlhttp.send(params);
    }
    else {
        $("#the-form")[0].reportValidity();
    }
}

//write out dynamically the results block of the cheque format results
function writeResults(parentNode) {
    
    var div_card = document.createElement("div");
    div_card.className = "card";
    
    var div_cardbody = document.createElement("div");
    div_cardbody.className = "card-body";
    div_card.appendChild(div_cardbody);

    var h5 = document.createElement("h5");
    h5.className = "card-title";
    h5.innerText = "Cheque Format"
    div_cardbody.appendChild(h5);

    var p = document.createElement("p");
    p.id  = "result_payeename"
    p.className = "card-text";
    div_cardbody.appendChild(p);

    var p = document.createElement("p");
    p.id  = "currency-format-numeric"
    p.className = "card-text";
    div_cardbody.appendChild(p);

    var p = document.createElement("p");
    p.id  = "currency-format-words"
    p.className = "card-text";
    div_cardbody.appendChild(p);

    parentNode.appendChild(div_card);

}