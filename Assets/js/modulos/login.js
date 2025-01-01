document.addEventListener('DOMContentLoaded', () => {
    console.log('DOM Loaded');
    
    // Esperar a que el documento esté completamente cargado
    setTimeout(() => {
        const loginForm = document.getElementById('frmLogin');
        console.log('Formulario:', loginForm);
        
        if (loginForm) {
            loginForm.onsubmit = function(e) {
                e.preventDefault();
                console.log('Formulario enviado');
                
                const correo = document.getElementById('correo').value;
                const clave = document.getElementById('clave').value;
                
                if (!correo || !clave) {
                    alert('Todos los campos son obligatorios');
                    return;
                }
                
                const formData = new FormData(this);
                
                fetch(BASE_URL + 'auth/login', {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    if (data.type === 'success') {
                        alert(data.msg);
                        window.location = BASE_URL + 'admin';
                    } else {
                        alert(data.msg);
                    }
                })
                .catch(err => {
                    console.error('Error:', err);
                    alert('Error al procesar la solicitud');
                });
            };
        } else {
            console.error('No se encontró el formulario de login');
        }
    }, 100);
}); 