        <?php
        session_start();
        if (!isset($_GET['id'])) exit("No hay id de solicitud");
        $id_solicitud = $_GET['id'];

        include_once "../conex.php";
        require_once "solicitud.php";
        require_once "../user/gestorsesion.php";

        GestorSesiones::iniciar();
        $nombre = GestorSesiones::get('nombre_completo');
        // Obtener solicitud
        $solicitudObj = new Solicitud($conexion);
        $solicitud = $solicitudObj->obtener($id_solicitud);
        if (!$solicitud) exit("No existe la solicitud");

        // Obtener detalles de materiales
        $detalles = $solicitudObj->obtenerDetalle($id_solicitud);

        // Obtener firma del trabajador emisor
        $firmaRuta = null;
        // Obtener firma del usuario logueado
        $firmaRuta = GestorSesiones::get('firma');
    ?>
        <!DOCTYPE html>
        <html>
        <head>
        <meta charset="utf-8">
        <title>Solicitud de Insumos #<?= $id_solicitud ?></title>
        <link rel="stylesheet" href="/lugopata/assets/css.css">
        <style>
            body { font-family: Arial, sans-serif; font-size: 14px; margin: 20px; }
            .contenedor { width: 700px; margin: auto; border: 2px solid #000; padding: 15px; }
            h1 { text-align: center; }
            .info { display: flex; justify-content: space-between; margin-bottom: 10px; }
            .info div { width: 48%; }
            table { width: 100%; border-collapse: collapse; margin-top: 10px; }
            table, th, td { border: 1px solid #000; }
            th, td { padding: 5px; text-align: center; }
            th { background-color: #f0f0f0; }
            .firma { margin-top: 20px; display: flex; justify-content: space-between; }
            .firma div { text-align: center; width: 45%; }
            .firma img { max-width: 200px; max-height: 100px; border:1px solid #000; }
        </style>
        </head>
        <body>
        <div class="contenedor">
            <h1>Solicitud de Insumos #<?= $id_solicitud ?></h1>

            <div class="info">
                <div>
                    <strong>Fecha:</strong> <?= $solicitud->fecha ?><br>
                    <strong>Emisor:</strong> <?= $nombre ?><br>
                    <strong>Departamento emisor:</strong> <?= $solicitud->nombre_departamento_emisor ?>
                </div>
                <div>
                    <strong>Receptor:</strong> <?= $solicitud->receptor ?><br>
                    <strong>Departamento destino:</strong> <?= $solicitud->nombre_departamento_destino ?><br>
                </div>
            </div>

            <div>
                <strong>Descripción general:</strong><br>
                <p><?= nl2br($solicitud->descripcion) ?></p>
            </div>

            <h3>Materiales</h3>
            <table>
                <thead>
                    <tr>
                        <th>Código / Nombre</th>
                        <th>Unidad</th>
                        <th>Cant. pedida</th>
                        <th>Cant. recibida</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($detalles as $d): ?>
                        <tr>
                            <td><?= $d->id_insumo . " - " . $d->nombre ?></td>
                            <td><?= $d->unidad ?></td>
                            <td><?= $d->cantidad_pedida ?></td>
                            <td><?= $d->cantidad_recibida ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

    <div class="firma">
        <div>
            <strong>Firma del Emisor</strong><br>
            <?php if ($firmaRuta): ?>
                <img src="<?= $firmaRuta ?>" alt="Firma del Emisor">
                <div class="linea-firma"></div>
            <?php else: ?>
                <p>No hay firma</p>
            <?php endif; ?>
        </div>
        <div>
            <strong>Firma del Receptor</strong><br><br><br><br><br><br><br>
            <div class="linea-firma"></div>
        </div>
    </div>



        <script>
        document.addEventListener("DOMContentLoaded", () => {
            window.print();
            setTimeout(() => { window.close(); }, 1000);
        });
        </script>
        </body>
        </html>
