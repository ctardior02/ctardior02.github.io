const headerContainer = document.getElementById('header-container');

// Utiliza AJAX o Fetch para cargar el contenido del encabezado desde "header.html"
fetch('./components/header.html')
    .then(response => response.text())
    .then(data => {
        headerContainer.innerHTML = data;
    })
    .catch(error => {
        console.error('Error al cargar el encabezado:', error);
    });

