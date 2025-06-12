<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Gestión de Usuarios</title>
</head>

<body>
    <h1>Gestión de Usuarios</h1>

    <button onclick="listarUsuarios()">Listar usuarios</button>
    <button onclick="crearUsuario()">Crear usuario</button>
    <button onclick="verUsuario(1)">Ver usuario ID 1</button>
    <button onclick="editarUsuario()">Editar usuario ID 1</button>
    <button onclick="eliminarUsuario(1)">Eliminar usuario ID 1</button>

    <pre id="resultado"></pre>

    <script>
        const apiUrl = 'usuarios.php'; // Asegúrate de que la ruta sea correcta en tu servidor

        function mostrarResultado(data) {
            document.getElementById('resultado').textContent = JSON.stringify(data, null, 2);
        }

        // CREAR USUARIO
        function crearUsuario() {
            const formData = new FormData();
            formData.append('accion', 'crear');
            formData.append('nombre', 'Laura');
            formData.append('apellido', 'Martínez');
            formData.append('correo', 'laura@example.com');
            formData.append('contraseña', '123456');
            formData.append('id_perfil', 2); // Cliente
            formData.append('direccion', 'Av. Libertad 101');
            formData.append('telefono', '123456789');
            formData.append('identificacion', '987654321');

            fetch(apiUrl, {
                    method: 'POST',
                    body: formData
                })
                .then(async res => {
                    try {
                        return await res.json();
                    } catch {
                        const text = await res.text();
                        return {
                            raw: text
                        };
                    }
                })
                .then(data => mostrarResultado(data))
                .catch(err => console.error('Error:', err));
        }

        // LISTAR USUARIOS
        function listarUsuarios() {
            const formData = new FormData();
            formData.append('accion', 'listar');
            formData.append('estado', 'activo');

            fetch(apiUrl, {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.json())
                .then(data => mostrarResultado(data))
                .catch(err => console.error('Error:', err));
        }

        // VER USUARIO
        function verUsuario(id) {
            const formData = new FormData();
            formData.append('accion', 'ver');
            formData.append('id_usuario', id);

            fetch(apiUrl, {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.json())
                .then(data => mostrarResultado(data))
                .catch(err => console.error('Error:', err));
        }

        // EDITAR USUARIO
        function editarUsuario() {
            const formData = new FormData();
            formData.append('accion', 'editar');
            formData.append('id_usuario', 1); // Cambia por el ID real
            formData.append('nombre', 'Laura Editada');
            formData.append('apellido', 'Martínez Gómez');
            formData.append('correo', 'lauraedit@example.com');
            formData.append('contraseña', 'nuevaclave');
            formData.append('id_perfil', 2);
            formData.append('estado', 'activo');
            formData.append('direccion', 'Calle Nueva 123');
            formData.append('telefono', '5550000');
            formData.append('identificacion', 'ID999999');

            fetch(apiUrl, {
                    method: 'POST',
                    body: formData
                })
                .then(async res => {
                    try {
                        return await res.json();
                    } catch {
                        const text = await res.text();
                        return {
                            raw: text
                        };
                    }
                })
                .then(data => mostrarResultado(data))
                .catch(err => console.error('Error:', err));
        }

        // ELIMINAR USUARIO
        function eliminarUsuario(id) {
            const formData = new FormData();
            formData.append('accion', 'eliminar');
            formData.append('id_usuario', id);

            fetch(apiUrl, {
                    method: 'POST',
                    body: formData
                })
                .then(async res => {
                    try {
                        return await res.json();
                    } catch {
                        const text = await res.text();
                        return {
                            raw: text
                        };
                    }
                })
                .then(data => mostrarResultado(data))
                .catch(err => console.error('Error:', err));
        }
    </script>
</body>

</html>