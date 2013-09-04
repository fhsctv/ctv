//zum Nachladen
//erzeugt XMLHTTP Request Objekt
//<= Ajax
function XMLHTTPREQUESTObjErzeugen()
{
    var XMLHTTP = null;

    if (window.XMLHttpRequest)
    {
        XMLHTTP = new XMLHttpRequest();
    }
    else if (window.ActiveXObject)
    {
        try
        {
            XMLHTTP = new ActiveXObject("Msxml2.XMLHTTP");
        }
        catch (ex)
        {
            try
            {
                XMLHTTP = new ActiveXObject("Microsoft.XMLHTTP");
            }
            catch (ex)
            {
            }
        }
    }

    return XMLHTTP;
}

//gibt die Sekunden an,
//wie lange eine Anzeige angezeigt wird
//Also alle Intervall * Sekunden
//wird eine neue Anzeige geladen
var Intervall;

var ACTIONS     = location.protocol + "//" + location.host + "/legacyctv/index";
var PUBLIC_PATH = location.protocol + "//" + location.host + "/ressources-legacyctv/php/";

var MIN_IN_SECONDS = 60;
var HOUR_IN_SECONDS = 60 * MIN_IN_SECONDS;


//XMLHTTPRequest readystates
//0 : request not initialized
//1 : server connection established
//2 : request received
//3 : processing request
//4: request finished and response is ready

var AJAX_STATE_READY = 4;

//XMLHTTPRequest statuses
//0   PROBLEM!
//200 OK


//initialisiert die globale Variable Intervall
function initIntervall()
{


    XMLHTTPIntervall = XMLHTTPREQUESTObjErzeugen();

    //XMLHTTPIntervall.open("POST", PATH + "init.php", true); //replaced for migration
    XMLHTTPIntervall.open("POST", ACTIONS + "/intervall", true);

    XMLHTTPIntervall.onreadystatechange = function()
    {

        if (XMLHTTPIntervall.readyState == AJAX_STATE_READY)
        {
//            alert("initIntervall(): XMLHTTPIntervall.responseText: " + XMLHTTPIntervall.responseText); //expected 20
            Intervall = XMLHTTPIntervall.responseText;
        }
    };



    XMLHTTPIntervall.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    XMLHTTPIntervall.send(null);


}






//= maximale Anzahl der Wiederholungen pro Zeitzone
//also bei der Dauer einer Zeitzone von 1h
//und einem Intervall von 20 Sekunden
//wären das maxmial 180 Wiederholungen
var maxAnzWied = 0;

//Feld, welches alle Zeitzonen des Standortes
//des Fernsehers speichert
Zeitzonen = new Array();

/*window.onload = function()
 {
 self.focus();
 }*/

//ermittelt die Zeitzonen
//und berechnet daraus
//die maximale Anzahl der Wiederholungen
//<- muss dringend refaktorisiert werden
//<- sehr uneffektiv
function ZeitzonenErmitteln()
{
    XMLHTTP = XMLHTTPREQUESTObjErzeugen();
//    XMLHTTP.open("POST", PATH + "ZeitzonenErmitteln.php", true);
    XMLHTTP.open("POST", ACTIONS + "/zeitzonen-ermitteln", true); //changed during migration

    XMLHTTP.onreadystatechange = function()
    {
        if (XMLHTTP.readyState == AJAX_STATE_READY)
        {
//            alert("ZeitzonenErmitteln():readyState: " + XMLHTTP.readyState);
//            alert("ZeitzonenErmitteln():responseText: " + XMLHTTP.responseText);
            Zeitzonen = XMLHTTP.responseText.split(";");

//            alert("ZeitzonenErmitteln():Zeitzonen.length: " + Zeitzonen.length);

            //löscht letztes Element, weil dieses leer ist
            Zeitzonen.pop();
//            alert("ZeitzonenErmitteln():Zeitzonen.length: " + Zeitzonen.length);

            maxAnzWied = ((Zeitzonen[1] - Zeitzonen[0]) * HOUR_IN_SECONDS) / Intervall;
//            alert("ZeitzonenErmitteln():maxAnzWied: " + maxAnzWied);
        }
    };


    XMLHTTP.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

//    alert("ZeitzonenErmitteln():ID from Url: " + window.location.search.split("=")[1]);
    XMLHTTP.send("Positions_ID=" + window.location.search.split("=")[1]); //sendet Positions_ID aus der url über POST Methode an Webserver
}

function AktuelleAnzeigenfuellen()
{
    var XMLHTTP = XMLHTTPREQUESTObjErzeugen();



    XMLHTTP.open("POST", ACTIONS + "/aktuelle-anzeigen-fuellen", true);
    XMLHTTP.onreadystatechange = function() {
//        alert("AktuelleAnzeigenFuellen(): " + XMLHTTP.status) //expected 200 OK
        AktuelleAnzeigenFuellenEventHandler(XMLHTTP);
    };
    XMLHTTP.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    XMLHTTP.send("Positions_ID=" + window.location.search.split("=")[1]); //sendet Positions_ID aus der url über POST Methode an Webserver
}

function AktuelleAnzeigenFuellenEventHandler(XMLHTTP)
{
    if (XMLHTTP.readyState == AJAX_STATE_READY)
    {
//        alert("AktuelleAnzeigenFuellenEventHandler(): " + XMLHTTP.status); //expected 200 OK
        if (XMLHTTP.responseText == 0)
        {
//            alert("AktuelleAnzeigenFuellenEventHandler():XMLHTTP.responseText: " + XMLHTTP.responseText);
            //gleich etwas anzeigen
            AktuelleAnzeigeErmitteln();
        }
    }
}

var AnzahlWiederholungen = 0;

function Aktuelle_Anzeigen_bereinigen()
{
    var XMLHTTP = XMLHTTPREQUESTObjErzeugen();

    XMLHTTP.open("POST", ACTIONS + "/aktuelle-anzeigen-bereinigen", true);
    XMLHTTP.onreadystatechange = function() {
        Aktuelle_Anzeigen_bereinigenEventHandler(XMLHTTP);
    };
    XMLHTTP.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    XMLHTTP.send("Positions_ID=" + window.location.search.split("=")[1]); //sendet Positions_ID aus der url über POST Methode an Webserver
}

function Aktuelle_Anzeigen_bereinigenEventHandler(XMLHTTP)
{
    if (XMLHTTP.readyState == AJAX_STATE_READY)
    {
        AnzahlWiederholungen = 0;
    }
}

function AktuelleAnzeigeErmitteln()
{

//    alert("AktuelleAnzeigeErmitteln()");
    var XMLHTTP = XMLHTTPREQUESTObjErzeugen();

    XMLHTTP.open("POST", ACTIONS + "/aktuelle-anzeige-ermitteln", true);

    XMLHTTP.onreadystatechange = function() {
//        alert("AktuelleAnzeigeErmitteln(): XMLHTTP.status: " + XMLHTTP.status);
//        alert("AktuelleAnzeigeErmitteln(): XMLHTTP.responseText " + XMLHTTP.responseText);
        AktuelleAnzeigeErmittelnEventHandler(XMLHTTP);
    };
    XMLHTTP.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");


//    alert("AktuelleAnzeigeErmitteln(): " + "Positions_ID=" + window.location.search.split("=")[1] + "&" + "Anzahl_Wiederholungen=" + AnzahlWiederholungen);

    XMLHTTP.send("Positions_ID=" + window.location.search.split("=")[1] + "&" + "Anzahl_Wiederholungen=" + AnzahlWiederholungen);
}

function AktuelleAnzeigeErmittelnEventHandler(XMLHTTP)
{

//    alert("AktuelleAnzeigeErmittelnEventHandler():XMLHTTP.readyState: " + XMLHTTP.readyState);
    if (XMLHTTP.readyState == AJAX_STATE_READY)
    {
//        alert("AktuelleAnzeigeErmittelnEventHandler():responseText: " + XMLHTTP.responseText);
        var Antwort = XMLHTTP.responseText.split("~");
//        alert("AktuelleAnzeigeErmittelnEventHandler():responseText: " + Antwort);

        var typ = Antwort[0];

        var link;

        if (typ == "News")
        {
//            alert("AktuelleAnzeigeErmittelnEventHandler(): " + Antwort[1]);
            document.getElementById("AnzeigeFrame").src = Antwort[1];
        }
        else if (typ == "Anzeige")
        {
            link = Antwort[1].split(",");

            document.getElementById("AnzeigeFrame").src = link[0];
        }
        else
        {
            document.getElementById("suchid").style.display = "none";

            //letztes Element muss gelöscht werden,
            //weil Array wegen letztem ";" ein leeres Element am Ende hat
            Antwort.pop();

            //Erstes Element muss gelöscht werden,
            //weil dieses den Typ angibt
            Antwort.shift();

            var URL = PUBLIC_PATH + "dummy.htm?";

            for (var i = 0; i < (Antwort.length / 3); i++)
            {
                if (i == 0)
                {
                    URL += Antwort[(i * 3)];
                    URL += "~" + Antwort[((i * 3) + 1)];
                    URL += "~" + Antwort[((i * 3) + 2)];
                }
                else if (i == (Antwort.length - 1))
                {
                    URL += "~" + Antwort[(i * 3)];
                    URL += "~" + Antwort[((i * 3) + 1)];
                    URL += Antwort[((i * 3) + 2)];
                }
                else
                {
                    URL += "~" + Antwort[(i * 3)];
                    URL += "~" + Antwort[((i * 3) + 1)];
                    URL += "~" + Antwort[((i * 3) + 2)];
                }

                //alert(Antwort[(i * 3)] + Antwort[((i * 3) + 1)] + Antwort[((i * 3) + 2)]);


            }

//            alert("AktuelleAnzeigeErmittelnEventHandler(): " + URL);
            document.getElementById("AnzeigeFrame").src = URL;
        }

        if (typ == "News")
            document.getElementById("suchid").style.display = "none";
        else if (typ == "Anzeige")
        {
            document.getElementById("suchid").style.display = "block";

            document.getElementById("suchid").innerHTML = "Diese Anzeige finden Sie auf &nbsp;&nbsp;&nbsp;&nbsp; www.FuThuer.de/campus-tv &nbsp;&nbsp;&nbsp;&nbsp; unter der &nbsp;&nbsp;&nbsp;&nbsp; ID: " + link[1];
        }
    }
}

function ZeitzoneVorhanden()
{
    if (Zeitzonen.length == 0)
        setTimeout("ZeitzoneVorhanden()", 1);
    else
    {
        //Es kann vorkommen, dass mitten in einer Zeitzone gestartet wird
        //dann soll auch von Anfang an etwas angezeigt werden
        //und nich erst beim nächsten Intervall
        var jetzt = new Date();

        var sek = jetzt.getSeconds();
        var min = jetzt.getMinutes();
        var h = jetzt.getHours();

        var aktZZ = 0;
        var nZZ = Zeitzonen[0];

        for (var i = 0; i <= Zeitzonen.length; i++)
        {
            if (Zeitzonen[i] == h)
            {
                aktZZ = Zeitzonen[i];

                if (i < (Zeitzonen.length - 1))
                    nZZ = Zeitzonen[i + 1];
            }
        }

        if (aktZZ == 0)
            AnzahlWiederholungen = 0;
        else if (aktZZ == Zeitzonen[(Zeitzonen.length - 1)] && nZZ == Zeitzonen[0])
        {
            AnzahlWiederholungen = ((min * MIN_IN_SECONDS) + sek) / Intervall;
        }
        else
        {
            AnzahlWiederholungen = maxAnzWied - ((((nZZ - h) * HOUR_IN_SECONDS) - (min * MIN_IN_SECONDS) - sek) / Intervall);
        }

        AnzahlWiederholungen = parseInt(AnzahlWiederholungen);

        AktuelleAnzeigeErmitteln();

        //rekursive Funktion für die Anzeige
        Anzeige();
    }
}

function Anzeige()
{
    var jetzt = new Date();

    var sek = jetzt.getSeconds();
    var min = jetzt.getMinutes();
    var h = jetzt.getHours();

    var aktZZ = 0;
    var nZZ = Zeitzonen[0];

    for (var i = 0; i <= Zeitzonen.length; i++)
    {
        if (Zeitzonen[i] == h)
        {
            aktZZ = Zeitzonen[i];

            if (i < (Zeitzonen.length - 1))
                nZZ = Zeitzonen[i + 1];
        }
    }

    //alert("aktZZ: " + aktZZ + " nZZ: " + nZZ);

    if (aktZZ == 0)
        AnzahlWiederholungen = 0;
    else if (aktZZ == Zeitzonen[(Zeitzonen.length - 1)] && nZZ == Zeitzonen[0])
    {
        AnzahlWiederholungen = ((min * MIN_IN_SECONDS) + sek) / Intervall;
    }
    else
    {
        AnzahlWiederholungen = maxAnzWied - ((((nZZ - h) * HOUR_IN_SECONDS) - (min * MIN_IN_SECONDS) - sek) / Intervall) + 1;
    }

    AnzahlWiederholungen = parseInt(AnzahlWiederholungen);
    //alert(AnzahlWiederholungen);

    var puffer = 5;

    var schluss = 0;

    if (((sek + puffer) % Intervall) == 0)
    {
        //alert("aktZZ: " + aktZZ + " nZZ: " + nZZ + " AnzahlWiederholungen: " + AnzahlWiederholungen);

        //wenn die letzte Zeitzone fertig,
        //dann bereinige Tabelle Aktuelle_Anzeigen
        //und Anzahl Wiederholungen auf 0 setzen
        //zum Testen muss es rausgenommen werden, da Programm jederzeit funktionieren soll
        /*if(aktZZ == Zeitzonen[(Zeitzonen.length - 1)]
         && nZZ == Zeitzonen[0]
         && AnzahlWiederholungen == maxAnzWied)
         {
         Aktuelle_Anzeigen_bereinigen();

         schluss = 1;
         }*/
        //x Sekunden vor Beginn der Tagesschaltung
        //else
        if (h == (Zeitzonen[0] - 1)
                && min == 59
                && sek == (60 - puffer))
        {
            AktuelleAnzeigenfuellen();
        }
        //x Sekunden vor der nächsten Zeitzone
        else if (min == 59
                && sek == (60 - puffer))
        {
            AktuelleAnzeigenfuellen();
        }
        /*else
         {
         AktuelleAnzeigeErmitteln();
         }*/
    }

    if ((sek % Intervall) == 0)
        AktuelleAnzeigeErmitteln();

    if (schluss == 0)
        setTimeout("Anzeige()", 1000);
}

function uhr() {
    var datum = new Date();
    var h = datum.getHours();
    var m = datum.getMinutes();

    if (m < 10) {
        m = "0" + m;
    }

    document.getElementById("Uhr").innerHTML = h + ":" + m;
    setTimeout("uhr()", 5000);
}