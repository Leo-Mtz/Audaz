<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\helpers\Html;
use Mpdf\Mpdf;


class ReportesController extends Controller
{
    public function actionIndex()
    {
        $ventasDiarias = $this->getVentasDiarias();

        return $this->render('index', [
            'ventasDiarias' => $ventasDiarias,
        ]);
    }

    public function actionVerReporte($fecha)
    {
        $reporte = $this->getReportePorFecha($fecha);
        return $this->render('ver-reporte', [
            'reporte' => $reporte,
            'fecha' => $fecha,
        ]);
    }

    public function actionDescargarReporte($fecha)
    {
        $reporte = $this->getReportePorFecha($fecha);
        $fileName = "reporte_$fecha.csv";

        Yii::$app->response->format = Response::FORMAT_RAW;
        Yii::$app->response->headers->add('Content-Type', 'text/csv');
        Yii::$app->response->headers->add('Content-Disposition', "attachment; filename=\"$fileName\"");

        $output = fopen('php://output', 'w');
        fputcsv($output, ['Fecha', 'Evento', 'ID Venta', 'Producto Vendido', 'Cantidad Vendida', 'Precio Total Vendido', 'Total Vendido de ese Producto', 'Tipo de Venta', 'Forma de Pago']);
        foreach ($reporte as $row) {
            fputcsv($output, $row);
        }
        fclose($output);
        Yii::$app->end();
    }


    public function actionGenerarPdf($fecha)
{
    // Fetch all sales data for the given date, grouped by event
    $ventas = Yii::$app->db->createCommand("
        SELECT 
            v.id_venta,
            v.fecha,
            v.precio_total_venta,
            v.id_evento,
            v.id_vendedor,
            v.cantidad_total_vendida,
            v.forma_de_pago,
            v.tipo_de_venta,
            v.productos_totales,
            e.evento
        FROM ventas v
        JOIN cat_eventos e ON v.id_evento = e.id_evento
        WHERE DATE(v.fecha) = :fecha
        ORDER BY e.evento, v.id_venta
    ")->bindValue(':fecha', $fecha)
      ->queryAll();

    // Initialize PDF
    $mpdf = new Mpdf();
    
    // CSS styling
    $css = '
        <style>
            body {
                font-family: Arial, sans-serif;
            }
            .header, .details, .summary {
                margin-bottom: 20px;
            }
            .header h1, .details h2 {
                margin: 0;
                padding: 0;
            }
            .header p, .details p {
                margin: 5px 0;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 20px;
            }
            th, td {
                border: 1px solid #dddddd;
                text-align: left;
                padding: 8px;
            }
            th {
                background-color: #f2f2f2;
            }
            .summary p {
                margin: 5px 0;
                font-weight: bold;
            }
            .evento-header {
                margin-top: 20px;
                margin-bottom: 10px;
                font-size: 16px;
                font-weight: bold;
            }
            .venta-separator {
                margin: 20px 0;
                border-top: 2px solid #000;
            }
        </style>
    ';
    
    $title = '<div class="title">Reporte de Ventas ' . Html::encode($fecha) . '</div>';
    $mpdf->WriteHTML($title);
    $html = $css;
    
    // Group ventas by evento
    $currentEvento = '';
    $ventasGrouped = [];

    foreach ($ventas as $venta) {
        $evento = $venta['evento'];

        // If this is a new evento, initialize the group
        if ($evento !== $currentEvento) {
            if (!empty($ventasGrouped)) {
                // Process the previous evento group
                $html .= $this->generateEventoHtml($ventasGrouped);
            }
            $ventasGrouped = [];
            $currentEvento = $evento;
            $html .= '<div class="evento-header">Evento: ' . Html::encode($currentEvento) . '</div>';
        }

        // Add current venta to the group
        $ventasGrouped[] = $venta;
    }

    // Process the last group
    if (!empty($ventasGrouped)) {
        $html .= $this->generateEventoHtml($ventasGrouped);
    }

    // Write the HTML content to the PDF
    $mpdf->WriteHTML($html);

    // Configure the response to show the PDF in the browser
    Yii::$app->response->format = Response::FORMAT_RAW;
    Yii::$app->response->headers->add('Content-Type', 'application/pdf');
    Yii::$app->response->headers->add('Content-Disposition', 'inline; filename="reporte_' . $fecha . '.pdf"');

    return $mpdf->Output('', 'S'); // S = Return as string
}

private function generateEventoHtml($ventasGrouped)
{
    $html = '';
    
    foreach ($ventasGrouped as $venta) {
        // Fetch products data for the current venta
        $productos = Yii::$app->db->createCommand("
            SELECT 
                p.id_producto AS producto_vendido,
                pr.presentacion,
                s.sabor,
                pv.cantidad_vendida,
                pv.precio_unitario,
                pv.subtotal_producto
            FROM productos_por_venta pv
            JOIN cat_productos p ON pv.id_producto = p.id_producto
            JOIN cat_presentaciones pr ON p.id_presentacion = pr.id_presentacion
            JOIN cat_sabores s ON p.id_sabor = s.id_sabor
            WHERE pv.id_venta = :id_venta
        ")->bindValue(':id_venta', $venta['id_venta'])
          ->queryAll();

        $details = '
            <div class="details">
                <h2>Detalles de la Venta</h2>
                <p>Número de Venta: ' . Html::encode($venta['id_venta']) . '</p>
                <p>Forma de Pago: ' . Html::encode($venta['forma_de_pago']) . '</p>
                <p>Tipo de Venta: ' . Html::encode($venta['tipo_de_venta']) . '</p>
            </div>
        ';
        
        $table = '
            <table border="1" cellpadding="10" cellspacing="0">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad Vendida</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>';
        
        $totalProductos = 0;
        $totalCantidadVendida = 0;
        $totalMontoVendido = 0;
        
        foreach ($productos as $row) {
            $totalProductos++;
            $totalCantidadVendida += $row['cantidad_vendida'];
            $totalMontoVendido += $row['subtotal_producto'];
            
            $productoVendido = Html::encode($row['sabor']) . ' ' . Html::encode($row['presentacion']);
            
            $table .= '<tr>
                <td>' . $productoVendido . '</td>
                <td>' . Html::encode($row['cantidad_vendida']) . '</td>
                <td>' . Html::encode(number_format($row['subtotal_producto'], 2)) . '</td>
            </tr>';
        }
        
        $table .= '</tbody></table>';
        
        $summary = '
            <div class="summary">
                <h2>Resumen</h2>
                <p>Total de Productos Vendidos: ' . Html::encode($totalProductos) . '</p>
                <p>Cantidad Total Vendida: ' . Html::encode($totalCantidadVendida) . '</p>
                <p>Monto Total Vendido: $' . Html::encode(number_format($totalMontoVendido, 2)) . '</p>
            </div>
        ';
        
        // Combine sections for current venta
        $html .= $details . $table . $summary . '<div class="venta-separator"></div>';
    }

    return $html;
}



    public function actionDescargarPdf($fecha)
    {
        // Fetch sale data from the ventas table
        $venta = Yii::$app->db->createCommand("
            SELECT 
                v.id_venta,
                v.fecha,
                v.precio_total_venta,
                v.id_evento,
                v.id_vendedor,
                v.cantidad_total_vendida,
                v.forma_de_pago,
                v.tipo_de_venta,
                e.evento
            FROM ventas v
            JOIN cat_eventos e ON v.id_evento = e.id_evento
            WHERE DATE(v.fecha) = :fecha
        ")->bindValue(':fecha', $fecha)
        ->queryOne();

        // Fetch products data from the productos_por_venta table with product details
        $productos = Yii::$app->db->createCommand("
            SELECT 
                p.id_producto AS producto_vendido,
                pr.presentacion,
                s.sabor,
                pv.cantidad_vendida,
                pv.precio_unitario,
                pv.subtotal_producto
            FROM productos_por_venta pv
            JOIN cat_productos p ON pv.id_producto = p.id_producto
            JOIN cat_presentaciones pr ON p.id_presentacion = pr.id_presentacion
            JOIN cat_sabores s ON p.id_sabor = s.id_sabor
            WHERE pv.id_venta = :id_venta
        ")->bindValue(':id_venta', $venta['id_venta'])
        ->queryAll();

        // Initialize PDF
        $mpdf = new Mpdf();
        
        // CSS styling
        $css = '
            <style>
                body {
                    font-family: Arial, sans-serif;
                }
                .header, .details, .summary {
                    margin-bottom: 20px;
                }
                .header h1, .details h2 {
                    margin: 0;
                    padding: 0;
                }
                .header p, .details p {
                    margin: 5px 0;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-bottom: 20px;
                }
                th, td {
                    border: 1px solid #dddddd;
                    text-align: left;
                    padding: 8px;
                }
                th {
                    background-color: #f2f2f2;
                }
                .summary p {
                    margin: 5px 0;
                    font-weight: bold;
                }
            </style>
        ';
        
        $header = '
            <div class="header">
                <h1>Reporte de Ventas del ' . Html::encode($fecha) . '</h1>
                <p>Evento: ' . Html::encode($venta['evento']) . '</p>
            </div>
        ';
        
        $details = '
            <div class="details">
                <h2>Detalles de la Venta</h2>
                <p>Número de Venta: ' . Html::encode($venta['id_venta']) . '</p>
                <p>Forma de Pago: ' . Html::encode($venta['forma_de_pago']) . '</p>
                <p>Tipo de Venta: ' . Html::encode($venta['tipo_de_venta']) . '</p>
            </div>
        ';
        
        $table = '
            <table border="1" cellpadding="10" cellspacing="0">
                <thead>
                    <tr>
                        <th>Producto Vendido (Presentación y Sabor)</th>
                        <th>Cantidad Vendida</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>';
        
        $totalProductos = 0;
        $totalCantidadVendida = 0;
        $totalMontoVendido = 0;
        
        foreach ($productos as $row) {
            $totalProductos++;
            $totalCantidadVendida += $row['cantidad_vendida'];
            $totalMontoVendido += $row['subtotal_producto'];
            
            
            $productoVendido = Html::encode($row['sabor']) .  ' ' . Html::encode($row['presentacion']) ;
       
            $table .= '<tr>
                <td>' . $productoVendido . '</td>
                <td>' . Html::encode($row['cantidad_vendida']) . '</td>
                <td>' . Html::encode(number_format($row['subtotal_producto'], 2)) . '</td>
            </tr>';
        }
        
        $table .= '</tbody></table>';
        
        $summary = '
            <div class="summary">
                <h2>Resumen</h2>
                <p>Total de Productos Vendidos: ' . Html::encode($totalProductos) . '</p>
                <p>Cantidad Total Vendida: ' . Html::encode($totalCantidadVendida) . '</p>
                <p>Monto Total Vendido: $' . Html::encode(number_format($totalMontoVendido, 2)) . '</p>
            </div>
        ';
        
        // Combine all sections
        $html = $css . $header . $details . $table . $summary;
        
        $mpdf->WriteHTML($html);
        $mpdf->Output('reporte_' . $fecha . '.pdf', 'D'); // D = Download
    }


    private function getVentasDiarias()
    {
        return Yii::$app->db->createCommand("
            SELECT DATE(v.fecha) AS fecha
            FROM ventas v
            GROUP BY DATE(v.fecha)
        ")->queryAll();
    }

    private function getReportePorFecha($fecha)
    {
        return Yii::$app->db->createCommand("
            SELECT 
                v.fecha AS fecha,
                e.evento AS evento,
                v.id_venta AS id_venta,
                p.id_producto AS id_producto,
                pv.cantidad_vendida AS cantidad_vendida,
                (pv.cantidad_vendida * pv.precio_unitario) AS precio_total_vendido,
                SUM(pv.cantidad_vendida * pv.precio_unitario) OVER (PARTITION BY pv.id_producto) AS total_vendido_producto,
                v.tipo_de_venta AS tipo_de_venta,
                v.forma_de_pago AS forma_de_pago
            FROM ventas v
            JOIN productos_por_venta pv ON v.id_venta = pv.id_venta
            JOIN cat_productos p ON pv.id_producto = p.id_producto
            JOIN cat_eventos e ON v.id_evento = e.id_evento
            WHERE DATE(v.fecha) = :fecha
        ")->bindValue(':fecha', $fecha)
          ->queryAll();
    }
}
