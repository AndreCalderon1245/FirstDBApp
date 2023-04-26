<?php
include("../../bd.php");

$sentencia = $conexion->prepare("SELECT tbl_pedidos.*, (SELECT payment FROM tbl_payment WHERE tbl_payment.id=tbl_pedidos.idpayment limit 1) as metododepago, (SELECT capacidad FROM tbl_productos WHERE tbl_productos.id=tbl_pedidos.idproducto limit 1) as capacidad, (SELECT precio FROM tbl_preciounico) as preciounico, (SELECT nombredelproducto FROM tbl_productos WHERE tbl_productos.id=tbl_pedidos.idproducto limit 1) as producto , (SELECT concat(primernombre, ' ', segundonombre, ' ', primerapellido, ' ', segundoapellido) FROM tbl_empleados WHERE tbl_empleados.id=tbl_pedidos.idempleado limit 1) as nombredelempleado, (SELECT status FROM tbl_status WHERE tbl_status.id=tbl_pedidos.idstatus limit 1) as status FROM tbl_pedidos, `tbl_preciounico`");
$sentencia->execute();
$lista_tbl_pedidos=$sentencia->fetchAll(PDO::FETCH_ASSOC);

?>
<?php
$medidaTicket = 180;
ob_start();
?>

<!DOCTYPE html>
<html>

<head>

    <style>
        * {
            font-size: 12px;
            font-family: 'DejaVu Sans', serif;
        }

        h1 {
            font-size: 18px;
        }

        .ticket {
            margin: 2px;
        }

        td,
        th,
        tr,
        table {
            border-top: 1px solid black;
            border-collapse: collapse;
            margin: 0 auto;
        }

        td.precio {
            text-align: right;
            font-size: 11px;
        }

        td.cantidad {
            font-size: 11px;
        }

        td.producto {
            text-align: center;
        }

        th {
            text-align: center;
        }


        .centrado {
            text-align: center;
            align-content: center;
        }

        .ticket {
            width: <?php echo $medidaTicket ?>px;
            max-width: <?php echo $medidaTicket ?>px;
        }

        img {
            max-width: inherit;
            width: inherit;
        }

        * {
            margin: 0;
            padding: 0;
        }

        .ticket {
            margin: 0;
            padding: 0;
        }

        body {
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="ticket centrado">
        <h1>NOMBRE DEL NEGOCIO</h1>
        <?php foreach($lista_tbl_pedidos as $registro){ ?>
        <h2>Ticket de venta #<?php echo $registro['id']?></h2>
        <h2><?php echo $registro['fechadepedido']?></h2>
        <?php
        $productos = [
            [
                "cantidad" => $registro['cantidad'],
                "descripcion" => $registro['producto'],
                "precio" => $registro['preciounico'] * $registro['capacidad'],
            ],
        ];
        ?>

        <table>
            <thead>
                <tr class="centrado">
                    <th class="cantidad">CANT</th>
                    <th class="producto">PRODUCTO</th>
                    <th class="precio">$$</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total = 0;
                foreach ($productos as $producto) {
                    $total += $producto["cantidad"] * $registro["preciounico"] * $registro["capacidad"];
                ?>
                    <tr>
                        <td class="cantidad"><?php echo number_format($producto["cantidad"], 2) ?></td>
                        <td class="producto"><?php echo $producto["descripcion"] ?></td>
                        <td class="precio">$<?php echo number_format($producto["precio"], 2) ?></td>
                    </tr>
                <?php } ?>
            </tbody>
            <tr>
                <td class="cantidad"></td>
                <td class="producto">
                    <strong>TOTAL</strong>
                </td>
                <td class="precio">
                    $<?php echo number_format($total, 2) ?>
                </td>
            </tr>
        </table>
        <p class="centrado">¡GRACIAS POR SU COMPRA!
        <?php break;} ?>
                </br>
    </div>
</body>

</html>

<?php 
$HTML=ob_get_clean();
require_once("../../libs/autoload.inc.php");
use Dompdf\Dompdf;
$dompdf = new Dompdf();
$opciones = $dompdf->getOptions();
$opciones->set(array("isRemoteEnabled"=>true));
$dompdf->setOptions($opciones);
$dompdf->loadHTML($HTML);
$dompdf->setPaper('letter');
$dompdf->render();
$dompdf->stream("archivo.pdf", array("Attachment"=>false));
?>