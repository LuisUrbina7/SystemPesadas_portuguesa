<!DOCTYPE html>
<html>

<head>
    <title>Informe de Pesadas</title>
    <style>
        * {
            visibility: hidden;
        }

        h1 {
            text-align: center;
        }

        h2 {
            text-align: center;
        }

        body {
            text-transform: uppercase;
            font-family: Arial, sans-serif;
            padding-top: 0px;
            margin: 0px;
            /*  background-color: #f0f0f0;*/
        }

        .header {
            font-size: 4px;
            display: flex;
            padding: 18px;
        }

        .header img {
            height: 50px;
        }

        .header h1 {
            margin: 0;
        }

        .content {
            margin-top: -30px;
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            width: 100%;
            padding: 3px;
            font-size: 5px;

        }

        th {
            background-color: #f2f2f2;

        }

        .left {
            text-align: center;
        }

        .total {
            font-weight: bold;
        }

        .footer {
            padding: 20px;
            text-align: center;
            font-size: 0.8em;
            color: #888;
        }



        .divider {
            border: none;
            border-top: 2px solid black;
            width: 100%;
            margin: 0;
        }

        @page {
            margin: 0;
        }

        @media print {
            body {
                width: 100mm;
                /* Ajusta el ancho a las dimensiones de tu impresora */
                margin: 0;
                padding: 0;
            }

            @page {
                margin: 0;
            }

            .printable-content {
                break-after: always;
            }

            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="header">
        <?php if (is_array($data['page_data']) && !empty($data['page_data'])) : ?>
            <!--   <img src="" alt="Logo">-->
            <h1><?= strtoupper($data['page_data'][0]['EMP_NOMBRE']) ?></h1>
            <h2><?= strtoupper($data['page_data'][0]['EMP_RIF']) ?></h2>
            <h2 style="color:gray;"><?= strtoupper($data['page_data'][0]['EMP_DIRECCION1']) ?><h2>
                    <hr>

                    <table>
                        <tr>
                            <td>
                                <p><strong>Teléfono: </strong> <?= $data['page_data'][0]['EMP_TELEFONO1'] ?> </p>
                                <p><strong>Email: </strong><?= $data['page_data'][0]['EMP_EMAIL'] ?> </p>
                                <p><strong> Numero Guia:</strong> <?= $data['page_data'][0]['PDA_NUMERO'] ?> </p>
                                <p><strong>Transportista: </strong><?= $data['page_data'][0]['TRA_NOMBRE'] ?> </p>
                                <p><strong>Fecha: </strong> <?= $data['page_data'][0]['PDA_FECHA'] ?> </p>
                            </td>

                        </tr>
                        <br>
                        <hr>
                        <tr>
                            <td>
                                <p><strong>Placa: </strong> <?= $data['page_data'][0]['DCG_VEH_PLACA'] ?> </p>
                                <p><strong>Estación: </strong> <?= $data['page_data'][0]['DCG_ESTACION'] ?> </p>
                                <p><strong>Ruta: </strong> <?= $data['page_data'][0]['DCG_RUTA'] ?> </p>

                            </td>

                        </tr>
                    </table>
    </div>

    <div class="content">

        <hr>
        <table>
            <tbody>
                <tr>
                    <td>Codigo producto: </td>
                    <td><?= $data['page_data'][0]['PDA_UPP_PDT_CODIGO'] ?></td>
                </tr>
                <tr>
                    <td>Neto: </td>
                    <td><?= $data['page_data'][0]['NETO'] ?></td>
                </tr>
                <tr>
                    <td>UND | KG (Bruto): </td>
                    <td class="left"><?= $row['KG_UND'] ?></td>
                </tr>
                <tr>
                    <td>NETO: </td>
                    <td class="left"><?= $row['PDA_CANTIDAD'] ?></td>
                </tr>
                <tr>
                    <td>Extra: </td>
                    <td><?= $data['page_data'][0]['EXTRA'] ?> </td>
                </tr>
                <tr>
                    <td>Unidad: </td>
                    <td><?= $data['page_data'][0]['PDA_UPP_UND_ID'] ?> </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <hr class="divider">
                    </td>
                </tr>
                <?php foreach ($data['page_data'] as $row) : ?>


                    <tr>
                        <td>Extra: </td>
                        <td class="left"><?= $row['PDA_EXTRA'] ?></td>
                    </tr>
                    <tr>
                        <td>Taras: </td>
                        <td class="left"><?= $row['PDA_CANASTA'] ?></td>
                    </tr>
                    <tr>
                        <td>UND | KG (Neto): </td><td class="left"><?=$row['KG_UND']?></td>
                    </tr>
                    <tr>
                        <td>Bruto: </td><td class="left"><?=$row['PDA_CANTIDAD']?></td>
                    </tr>
                    <tr>
                        <td>Hora Inicio: </td>
                        <td class="left"><?= $row['PDA_INICIO'] ?></td>
                    </tr>
                    <tr>
                        <td>Hora Fin: </td>
                        <td class="left"><?= $row['PDA_FIN'] ?></td>
                    </tr>
                    <td colspan="2">
                        <hr class="divider">
                    </td>
                    <br>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else : ?>
        <p>No hay datos disponibles para mostrar.</p>
    <?php endif; ?>
    </div>
    <div class="footer">
        <p>Sistema patentado por ADN SOFTWARE!</p>
    </div>

    <script>
        const base_url = "<?= base_url(); ?>";
        const numero = "<?= $_GET['id'] ?>";
        const codigo = "<?= $_GET['tr'] ?>";
        const producto = "<?= $_GET['pdt'] ?>";

        document.addEventListener("DOMContentLoaded", function() {
            var bodyHeight = document.body.offsetHeight;
            console.log("Altura del body: " + bodyHeight + "px");
            // Ahora puedes usar bodyHeight según sea necesario


            var ajaxUrl = base_url + '/DocumentGuia/generatePdfDetailsPesada?id=' + numero + '&tr=' + codigo + '&height=' + bodyHeight + '&pdt=' + producto;
            window.location.href = ajaxUrl;
        });
    </script>
</body>

</html>