<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Administración de usuarios</title>

    <link rel="icon" type="image/png" href="/tienda/admin/usuarios/imagenes/RR.png">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.css" rel="stylesheet">

    <style type="text/css">
        /*CSS para no imprimir las etiquetas que tengan id="no_imprimir"*/
        @media print {
            #no_imprimir {
                display: none
            }
        }
        @import '/tienda/estilos/style_buttons/style_buttons.css';
        @import "/tienda/estilos/search/search.css";
    </style>

    <script type="text/javascript">
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
</head>

<body>
    <?php require_once "navbar.php"; ?>