function navigateTo(page) {
    window.location.href = page + ".html";
}

 /**
         * Muestra una notificación en la pantalla.
         * @param {string} areaName - El nombre del área.
         * @param {string} message - El mensaje a mostrar.
         * @param {string} type - Tipo de notificación ('success' o 'danger').
         */
 function showNotification(areaName, message, type) {
    const toastContainer = document.querySelector('.toast-container');

    // Crear el HTML de la notificación
    const toastHTML = `
        <div class="toast align-items-center text-bg-${type} border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <strong>${areaName}</strong>: ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    `;

    // Insertar la notificación en el contenedor
    const toastElement = document.createElement('div');
    toastElement.innerHTML = toastHTML;
    toastContainer.appendChild(toastElement);

    // Inicializar y mostrar la notificación
    const toast = new bootstrap.Toast(toastElement.querySelector('.toast'), { delay: 3000 });
    toast.show();

    // Eliminar el elemento del DOM después de que desaparezca
    toastElement.querySelector('.toast').addEventListener('hidden.bs.toast', () => {
        toastElement.remove();
    });
}