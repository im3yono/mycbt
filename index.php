<?php
date_default_timezone_set('Asia/Makassar');
echo date("Y-m-d H:i:s") . " PHP";
?>

<div id="tampil"></div>
<div id="php"></div>
<div id="hasil"></div>
<div id="rt"></div>

<script>
    var x = setInterval(function() {
        var xmlHttp;

        function srvTime() {
            try {
                //FF, Opera, Safari, Chrome
                xmlHttp = new XMLHttpRequest();
            } catch (err1) {
                //IE
                try {
                    xmlHttp = new ActiveXObject('Msxml2.XMLHTTP');
                } catch (err2) {
                    try {
                        xmlHttp = new ActiveXObject('Microsoft.XMLHTTP');
                    } catch (eerr3) {
                        //AJAX not supported, use CPU time.
                        alert("AJAX not supported");
                    }
                }
            }
            xmlHttp.open('HEAD', window.location.href.toString(), false);
            xmlHttp.setRequestHeader("Content-Type", "text/html");
            xmlHttp.send('');
            return xmlHttp.getResponseHeader("Date");
        }

        var st = srvTime();
        var date = new Date(st);





        var tanggal = new Date();

        var jamS = new Date("<?php date_default_timezone_set('Asia/Makassar');echo date("Y-m-d H:i:s") ?>");
        // var jamS = new Date(date);
        var hasil = tanggal - date;
        document.getElementById("tampil").innerHTML = tanggal;
        document.getElementById("php").innerHTML = jamS;
        document.getElementById("hasil").innerHTML = hasil;

        document.getElementById("rt").innerHTML = date;
    }, 1000);
</script>

<script language="javascript">
    //   var localTime = new Date();
    //   document.write("Local machine time is: " + localTime + "<br>");
    //   document.write("Server time is: " + date1);
</script>