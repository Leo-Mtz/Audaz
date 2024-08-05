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
    $reporte = $this->getReportePorFecha($fecha);

    $mpdf = new Mpdf();
    $mpdf->WriteHTML('<h1>Reporte de Ventas del ' . Html::encode($fecha) . '</h1>');
    
    $html = '<table border="1" cellpadding="10">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Evento</th>
                <th>ID Venta</th>
                <th>Producto Vendido</th>
                <th>Cantidad Vendida</th>
                <th>Precio Total Vendido</th>
                <th>Total Vendido de ese Producto</th>
                <th>Tipo de Venta</th>
                <th>Forma de Pago</th>
            </tr>
        </thead>
        <tbody>';
        
    foreach ($reporte as $row) {
        $html .= '<tr>
            <td>' . Html::encode($row['fecha']) . '</td>
            <td>' . Html::encode($row['evento']) . '</td>
            <td>' . Html::encode($row['id_venta']) . '</td>
            <td>' . Html::encode($row['id_producto']) . '</td>
            <td>' . Html::encode($row['cantidad_vendida']) . '</td>
            <td>' . Html::encode($row['precio_total_vendido']) . '</td>
            <td>' . Html::encode($row['total_vendido_producto']) . '</td>
            <td>' . Html::encode($row['tipo_de_venta']) . '</td>
            <td>' . Html::encode($row['forma_de_pago']) . '</td>
        </tr>';
    }
    
    $html .= '</tbody></table>';
    
    $mpdf->WriteHTML($html);

    // Set headers to open PDF in browser
    Yii::$app->response->format = Response::FORMAT_RAW;
    Yii::$app->response->headers->add('Content-Type', 'application/pdf');
    Yii::$app->response->headers->add('Content-Disposition', 'inline; filename="reporte_' . $fecha . '.pdf"');

    return $mpdf->Output('', 'S'); // S = Return as string
}

    public function actionDescargarPdf($fecha)
    {
     
        $reporte = $this->getReportePorFecha($fecha);
    
        $mpdf = new Mpdf();
        $mpdf->WriteHTML('<h1>Reporte de Ventas del ' . Html::encode($fecha) . '</h1>');
        
        $html = '<table border="1" cellpadding="10">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Evento</th>
                    <th>ID Venta</th>
                    <th>Producto Vendido</th>
                    <th>Cantidad Vendida</th>
                    <th>Precio Total Vendido</th>
                    <th>Total Vendido de ese Producto</th>
                    <th>Tipo de Venta</th>
                    <th>Forma de Pago</th>
                </tr>
            </thead>
            <tbody>';
            
        foreach ($reporte as $row) {
            $html .= '<tr>
                <td>' . Html::encode($row['fecha']) . '</td>
                <td>' . Html::encode($row['evento']) . '</td>
                <td>' . Html::encode($row['id_venta']) . '</td>
                <td>' . Html::encode($row['id_producto']) . '</td>
                <td>' . Html::encode($row['cantidad_vendida']) . '</td>
                <td>' . Html::encode($row['precio_total_vendido']) . '</td>
                <td>' . Html::encode($row['total_vendido_producto']) . '</td>
                <td>' . Html::encode($row['tipo_de_venta']) . '</td>
                <td>' . Html::encode($row['forma_de_pago']) . '</td>
            </tr>';
        }
        
        $html .= '</tbody></table>';
        
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
