<!DOCTYPE html>
<html>

    <title>Informe de Pesadas</title>
    <style>
        *{
            visibility: hidden;
        }
       
        h1{
            text-align:center;
        }
        h2{
            text-align:center;
        }
        body {
            text-transform: uppercase;
            font-family: Arial, sans-serif;
            
           /* padding-top: 10px;
            background-color: #f0f0f0;*/
        }

        .header {
            font-size: 7px;
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
            width:100%;
            padding: 3px;
            font-size: 10px;
        }

        th {
            background-color: #f2f2f2;
        }


      .left{
            text-align:center;
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

        
    </style>
</head>

<body class="">
<div class="container">
    <div class="header">
   <?php if (is_array($data['page_data']) && !empty($data['page_data'])) : ?>
     <!--   <img src="" alt="Logo">-->
        <h1><?= strtoupper($data['page_data'][0]['EMP_NOMBRE']) ?></h1>
        <h2></h2>
        <h2 style="color:gray;"><?= strtoupper($data['page_data'][0]['EMP_DIRECCION1'])?></h2>
        <hr>

        <table>
                <tr>
                    <td>
                       
                        
                        <p><strong>Teléfono: </strong> <?= $data['page_data'][0]['EMP_TELEFONO1'] ?> </p>
                        <p><strong>Email: </strong><?= $data['page_data'][0]['EMP_EMAIL'] ?> </p>
                        <p><strong> Numero Orden:</strong> <?= $data['page_data'][0]['PDA_NUMERO'] ?> </p>
                        <p><strong>Proveedor: </strong> <?= $data['page_data'][0]['PVD_NOMBRE'] ?> </p>
                        <p><strong>Fecha: </strong> <?= $data['page_data'][0]['PDA_FECHA'] ?> </p>
                    </td>
                   
                </tr>
                <br><hr>
                <tr>
                    <td>
                        <p><strong>TermoK: </strong> <?= $data['page_data'][0]['PDA_TK'] ?> </p>
                        <p><strong>TermoP: </strong> <?= $data['page_data'][0]['PDA_TA'] ?> </p>
                        <p><strong>Hora llegada: </strong> <?= $data['page_data'][0]['PDA_LLEGADA'] ?> </p>

                    </td>
                   
                </tr>
            </table>
    </div>
    
</div>


    <div class="content">
            <hr>
        <table>
            <tbody>
                <?php foreach ($data['page_data'] as $row) : ?>
                
                    <tr>
                        <td>Codigo producto: </td><td><?= $row['PDA_UPP_PDT_CODIGO'] ?> </td>
                    </tr>

                    <tr>
                        <td colspan="2"><hr class="divider"></td>
                    </tr>
                
                    <tr>
                        <td>Descripción: </td><td class="left"><?= $row['PDT_DESCRIPCION'] ?> </td>
                    </tr>
                    <tr>
                        <td>Unidad: </td><td class="left"><?= $row['PDA_UPP_UND_ID'] ?> </td>
                    </tr>
                    <tr>
                        <td>Cantidad: </td><td class="left"><?= $row['CANTIDAD'] ?> </td>
                    </tr>
                    <tr>
                        <td>Recibido: </td><td class="left"><?= $row['RECIBIDO'] ?> </td>
                    </tr>
                    <tr>
                        <td>Canastas: </td><td class="left"><?= $row['CANASTAS'] ?> </td>
                    </tr>
                    <tr>
                        <td>Extra: </td><td class="left"><?= $row['EXTRA'] ?> </td>
                    </tr>
                    <tr>
                        <td>Hora Inicio: </td><td class="left"><?= $row['INICIO'] ?> </td>
                    </tr>
                    <tr>
                        <td>Hora Fin: </td><td class="left"><?= $row['FIN'] ?> </td>
                    </tr>
                    <tr>
                        <td>Duración: </td><td class="left"><?= $row['DURACION'] ?> </td>
                    </tr>
                        <td colspan="2"><hr class="divider"></td>
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
const codigo = "<?= $_GET['pv'] ?>";
const sucursal = "<?= $_GET['scs'] ?>";

    document.addEventListener("DOMContentLoaded", function() {
    var bodyHeight = document.body.offsetHeight;
    console.log("Altura del body: " + bodyHeight + "px");
    // Ahora puedes usar bodyHeight según sea necesario

           
    var ajaxUrl = base_url + '/Document/generatePdf?id=' + numero + '&pv=' + codigo + '&scs=' + sucursal + '&height=' + bodyHeight;
    window.location.href = ajaxUrl;
});
</script>
</body>

</html>