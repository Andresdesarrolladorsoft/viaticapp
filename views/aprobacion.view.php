<?php
include '../config.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Control de Viáticos</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        header {
            background-color: #4c87af;
            color: white;
            text-align: center;
            padding: 1rem;
        }

        main {
            padding: 2rem;
        }

        form {
            background-color: white;
            padding: 1.5rem;
            margin-bottom: 2rem;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #333;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            color: #555;
        }

        input[type="text"],
        input[type="number"],
        select {
            width: 100%;
            padding: 0.5rem;
            margin-bottom: 1rem;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #4c87af;
            color: white;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #4c87af;
        }
    </style>
</head>

<body>

    <header>
        <h1>ViaticApp A_A</h1>
    </header>

    <main>

        <!-- Formulario para aprobar viáticos -->

        <form id="aprobarViaticos" action="../aprobacion.php" method="POST">
            <h2>Aprobacion</h2>
            <label for="id_referencia">ID de la Solicitud:</label>
            <input type="number" id="id_referencia" name="id_referencia" required>

            <label for="estado">Estado de Aprobación:</label>
            <select name="estado" id="estado" required>
                <option value="aprobado">Aprobar</option>
                <option value="denegado">Denegar</option>
            </select>

            <button type="submit" class="btn btn-success">Guardar</button>
        </form>


        <div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="successModalLabel"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p id="successMessage"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>


    </main>


    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function() {
            document.getElementById("aprobarViaticos").addEventListener("submit", function(event) {
                event.preventDefault(); // Evita que el formulario se envíe automáticamente

                // Obtener los valores de los campos de entrada
                var estado = document.getElementById("estado").value.trim();
                var id_referencia = document.getElementById("id_referencia").value.trim();


                // Validar que los campos no estén vacíos
                if (!estado || !id_referencia) {
                    alert("Por favor, complete todos los campos.");
                    return;
                }

                // Crear el objeto formData
                var formData = new URLSearchParams();
                formData.append('estado', estado);
                formData.append('id_referencia', id_referencia);

                // Hacer la petición HTTP al servidor
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "<?php echo $server_url; ?>/aprobacion.php");
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=UTF-8");
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        // Verificar el contenido de la respuesta
                        var responseText = xhr.responseText.trim();
                        var modalLabel = document.getElementById("successModalLabel");
                        var modalMessage = document.getElementById("successMessage");

                        if (xhr.responseText === "Error al generar el resgistro") {
                            // Configurar el modal de error
                            modalLabel.innerText = "Un Error ha Ocurrido";
                            modalMessage.innerText = responseText;
                            $('#successModal').modal('show');

                        } else {
                            //Configurar el modal de éxito
                            modalLabel.innerText = "Exito.";
                            modalMessage.innerText = "Aprobacion generada correctamente";
                            $('#successModal').modal('show');

                            //Redireccionar al cerrar el modal de éxito
                            $('#successModal').on('hidden.bs.modal', function() {
                                window.location.href = "home.view.php";
                            });
                        }
                    } else {
                        alert("Error al enviar la aprobacion. Por favor, intente nuevamente.");
                    }
                };
                xhr.send(formData);
            });
        });
    </script>


</body>

</html>