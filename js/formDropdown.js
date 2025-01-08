// JavaScript zum dynamischen Ändern der Abteilungs-Optionen basierend auf dem Standort
        
function formDropdown() {
    const standort = document.getElementById('standort').value;
    const firmenSelect = document.getElementById('firmen');
    const abteilungenSelect = document.getElementById('abteilungen');
    
    // Alle Firmenoptionen zurücksetzen
    firmenSelect.innerHTML = '';
    abteilungenSelect.innerHTML = '';

    if (standort === 'Berlin') {
        firmen = ['', 'All3Media', 'All3Media-Fiction', 'IT', 'Tower Productions'];
    } else if (standort === 'Hürth') {
        firmen = ['All3Media'];
    } else if (standort === 'Köln') {
        firmen = ['All3Media-Fiction', 'Tower Productions'];
    } else {
        firmen = ['Keine Firmen verfügbar'];
    }

// firmen = array_keys($_SESSION['allous'][standort])
    
    // Neue Optionen hinzufügen
    firmen.forEach(firma => {
        const opt = document.createElement('option');
        opt.textContent = firma;
        firmenSelect.appendChild(opt);
    });
    // Eventlistener für die Firma hinzufügen
    firmenSelect.addEventListener('change', function() {
        let firma = this.value;
        abteilungenSelect.getElementsByTagName('optionen').forEach(function () {
            if (this.firma == firma) {
                this.style.display = "block"
            } else {
                this.style.display = "none"
            }
        });

        
//
//        
//        abteilungenSelect.innerHTML = '';  // Reset der Abteilungen
//        let selectedFirma = firmenSelect.value;
//        let selectedStandort = standort;
//
//        // Berlin-Branch
//        if (selectedStandort === 'Berlin' && selectedFirma === 'All3Media') {
//            abteilungen = ['anderes', 'Buha', 'Controlling', 'Externe', 'Geschaeftsfuehrung', 'LittleDotGermany', 'Orga TP', 'Perso', 'Recht', 'Referendare'];
//        } else if (selectedStandort === 'Berlin' && selectedFirma === 'All3Media-Fiction') {
//            abteilungen = ['Content Creation', 'Editing', 'Postproduktion'];
//        } else if (selectedStandort === 'Berlin' && selectedFirma === 'IT') {
//            abteilungen = ['Development', 'Support', 'QA'];
//        } else if (selectedStandort === 'Berlin' && selectedFirma === 'Tower Productions') {
//            abteilungen = ['Filming', 'Editing', 'Production'];
//        } else {
//            abteilungen = ['Keine Abteilungen verfügbar'];
//        }
//
//        // Neue Abteilungsoptionen hinzufügen
//        abteilungen.forEach(abteilung=> {
//        const opt = document.createElement('option');
//        opt.textContent = abteilung;
//        abteilungenSelect.appendChild(opt);
//        });
//    });
}