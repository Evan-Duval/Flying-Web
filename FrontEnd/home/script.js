const typeSelectionne = document.getElementById('type');
const dateRetour = document.getElementById('date-retour');
const dateRetourLabel = document.getElementById('date-retour-label');

typeSelectionne.addEventListener('change', () => {
    if (typeSelectionne.value === 'aller-retour') {
        dateRetour.style.display = 'block'; //vu
        dateRetourLabel.style.display = 'block'; //vu
    } else {
        dateRetour.style.display = 'none'; //cacher
        dateRetourLabel.style.display = 'none'; //cacher
    }
});


// Calendrier Personnailé, bibliotheque js (flatpickr)
flatpickr("#date", {
    dateFormat: "Y-m-d",  
    minDate: "today",     
    locale: "fr",       
});

flatpickr("#date-retour", {
    dateFormat: "Y-m-d",  
    minDate: "today",    
    locale: "fr",         
    enableTime: false,   
    disable: [
        function(date) { 
            return date < new Date(document.getElementById('date').value);
        }
    ]
});
