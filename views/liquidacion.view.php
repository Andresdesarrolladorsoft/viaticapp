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
        <form id="liquidarViaticos" action="../liquidacion.php" method="POST">
            <h2>Liquidación</h2>
            <label for="id_referencia">ID referencia:</label>
            <input type="number" id="id_referencia" name="id_referencia" required>

            <label for="monto_usado">Monto Utilizado:</label>
            <input type="number" id="monto_usado" name="monto_usado" required>

            <label for="detalle">Detalles de los Gastos:</label>
            <input type="text" id="detalle" name="detalle" required>

            <label for="soportes">Soportes</label>
            <input type="text" id="soportes" name="soportes" required>

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
            document.getElementById("liquidarViaticos").addEventListener("submit", function(event) {
                event.preventDefault(); // Evita que el formulario se envíe automáticamente

                // Obtener los valores de los campos de entrada
                var id_referencia = document.getElementById("id_referencia").value.trim();
                var monto_usado = document.getElementById("monto_usado").value.trim();
                var detalle = document.getElementById("detalle").value.trim();
                var soportes = document.getElementById("soportes").value.trim();

                // Validar que los campos no estén vacíos
                if (!id_referencia || !monto_usado || !detalle || !soportes) {
                    alert("Por favor, complete todos los campos.");
                    return;
                }

                // Crear el objeto formData
                var formData = new URLSearchParams();
                formData.append('id_referencia', id_referencia);
                formData.append('monto_usado', monto_usado);
                formData.append('detalle', detalle);
                formData.append('soportes', soportes);

                // Hacer la petición HTTP al servidor
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "<?php echo $server_url; ?>/liquidacion.php");
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
                            $('#succesModal').modal('show');

                        } else {
                            //Configurar el modal de éxito
                            modalLabel.innerText = "Exito.";
                            modalMessage.innerText = "Liquidacion generada correctamente";
                            $('#successModal').modal('show');

                            //Redireccionar al cerrar el modal de éxito
                            $('#successModal').on('hidden.bs.modal', function() {
                                window.location.href = "home.view.php";
                            });
                        }
                    } else {
                        alert("Error al enviar la solicitud. Por favor, intente nuevamente.");
                    }
                };
                xhr.send(formData);
            });
        });
    </script>


</body>

</html>cessModa