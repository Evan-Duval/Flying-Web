document.addEventListener('DOMContentLoaded', function() {
    // Récupérer tous les éléments list-item
    const listItems = document.querySelectorAll('.list-item');
    
    // Fonction pour extraire le nom du dossier pertinent de l'URL
    function getFolderName(path) {
        // Diviser le chemin en segments
        const segments = path.split('/');
        // Filtrer les segments vides
        const validSegments = segments.filter(segment => segment.length > 0);
        
        // Parcourir les segments pour trouver les dossiers principaux
        for (let segment of validSegments) {
            if (['home', 'connexion', 'profil', 'boutique'].includes(segment)) {
                return segment;
            }
        }
        return '';
    }
    
    // Pour chaque élément de la liste
    listItems.forEach(item => {
        const link = item.querySelector('a');
        
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Retirer la classe active de tous les éléments
            listItems.forEach(item => {
                item.classList.remove('active');
            });
            
            // Ajouter la classe active à l'élément cliqué
            item.classList.add('active');
            
            // Rediriger vers la nouvelle page
            setTimeout(() => {
                window.location.href = this.href;
            }, 100);
        });
    });
    
    // Marquer le lien actif en fonction du dossier actuel
    const currentPath = window.location.pathname;
    const currentFolder = getFolderName(currentPath);
    
    listItems.forEach(item => {
        const link = item.querySelector('a');
        const href = link.getAttribute('href');
        const fullPath = new URL(href, window.location.href).pathname;
        const linkFolder = getFolderName(fullPath);
        
        // Si le dossier actuel correspond au dossier du lien
        if (currentFolder && linkFolder && currentFolder === linkFolder) {
            // Retirer la classe active des autres éléments
            listItems.forEach(otherItem => {
                otherItem.classList.remove('active');
            });
            // Ajouter la classe active à cet élément
            item.classList.add('active');
        }
    });
});