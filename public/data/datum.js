function getAktuellesDatum()
{
         //Objekt aktuelles Datum
         var heute = new Date();

         //Feld mit Bezeichnung der Wochentage
         var Wochentag = new Array("Sonntag","Montag","Dienstag","Mittwoch","Donnerstag","Freitag","Samstag");

         var Tag = parseInt(heute.getDate());
         
         if(Tag < 10)
        	 Tag = "0" + Tag;
         
         var Monat = parseInt(heute.getMonth() + 1);
         
         if(Monat < 10)
        	 Monat = "0" + Monat;
         
         var aktuellesDatum = Wochentag[heute.getDay()] + ", " + Tag + "." + Monat + "." + heute.getFullYear();

         return aktuellesDatum;
}