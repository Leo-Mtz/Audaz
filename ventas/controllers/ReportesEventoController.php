<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\helpers\Html;
use Mpdf\Mpdf;

class ReportesEventoController extends Controller
{ public function actionIndex()
    {
        return $this->render('index', [
           
        'ventasPorEvento' => $this->getVentasPorEvento(), 
         ]);
    }

    public function actionVerReporteEvento($id_evento)
    {
        $reporte_evento = $this->getReportePorFecha($id_evento);
        return $this->render('ver-reporte-evento', [
            'reporte_evento' => $reporte_evento,
            'id_evento' => $id_evento,
        ]);
    }

       private function getVentasPorEvento()
    {
        return Yii::$app->db->createCommand("
            SELECT e.evento AS evento, e.id_evento AS id_evento
            FROM ventas v
            INNER JOIN cat_eventos e ON v.id_evento = e.id_evento
            GROUP BY e.id_evento, e.evento
        ")->queryAll();
    }

    public function actionDescargarReporte($id_evento)
    {
        // Fetch the report data for the specified event
        $reporte_evento = $this->getReportePorEvento($id_evento);
        $eventoNombre = $this->getEventoNombre($id_evento);
        $fileName = "reporte_evento_$id_evento.csv";
    
        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        Yii::$app->response->headers->add('Content-Type', 'text/csv');
        Yii::$app->response->headers->add('Content-Disposition', "attachment; filename=\"$fileName\"");
    
        // Open output stream
        $output = fopen('php://output', 'w');
    
        // Add event name header
        fputcsv($output, ["Reporte del Evento: " . htmlspecialchars($eventoNombre)]);
        fputcsv($output, []); // Add an empty row for spacing
    
        // Add CSV headers
        fputcsv($output, [
            'ID Venta', 
            'Producto', 
            'Cantidad Vendida', 
            'Monto Total', 
            'Forma de Pago', 
            'Tipo de Venta'
        ]);
    
        // Initialize totals
        $totalCantidadVendida = 0;
        $totalMontoTotal = 0;
    
        // Add data rows and calculate totals
        foreach ($reporte_evento as $row) {
            fputcsv($output, [
                $row['id_venta'],
                $row['producto'],
                $row['cantidad_vendida'],
                $row['monto_total'],
                $row['forma_de_pago'],
                $row['tipo_de_venta']
            ]);
    
            // Sum up totals
            $totalCantidadVendida += $row['cantidad_vendida'];
            $totalMontoTotal += $row['monto_total'];
        }
    
        // Add totals row
        fputcsv($output, []); // Add an empty row for spacing
        fputcsv($output, [
            '', '', '', '', // Empty cells for alignment
            'Total Cantidad Vendida:', $totalCantidadVendida
        ]);
        fputcsv($output, [
            '', '', '', '', // Empty cells for alignment
            'Total Monto Total:', $totalMontoTotal
        ]);
    
        // Close output stream
        fclose($output);
        Yii::$app->end();
    }
       

    private function getReportePorEvento($id_evento)
    {
        return Yii::$app->db->createCommand("
            SELECT 
                v.id_venta AS id_venta,
                p.id_producto AS id_producto,
                CONCAT(s.sabor, ' - ', pr.presentacion) AS producto,
                pv.cantidad_vendida AS cantidad_vendida,
                (pv.cantidad_vendida * pv.precio_unitario) AS monto_total,
                v.forma_de_pago AS forma_de_pago,
                v.tipo_de_venta AS tipo_de_venta,
                v.fecha AS fecha
            FROM ventas v
            JOIN productos_por_venta pv ON v.id_venta = pv.id_venta
            JOIN cat_productos p ON pv.id_producto = p.id_producto
            JOIN cat_presentaciones pr ON p.id_presentacion = pr.id_presentacion
            JOIN cat_sabores s ON p.id_sabor = s.id_sabor
            WHERE v.id_evento = :id_evento
            GROUP BY v.id_venta, p.id_producto, s.sabor, pr.presentacion, pv.cantidad_vendida, pv.precio_unitario, v.forma_de_pago, v.tipo_de_venta, v.fecha
            ORDER BY v.id_venta ASC
        ")->bindValue(':id_evento', $id_evento)
          ->queryAll();
    }
    

    private function getEventoNombre($id_evento)
    {
        return Yii::$app->db->createCommand("
            SELECT evento FROM cat_eventos WHERE id_evento = :id_evento
        ")->bindValue(':id_evento', $id_evento)
          ->queryScalar();
    }

    public function actionDescargarPdf($id_evento)
    {
        $reporte_evento = $this->getReportePorEvento($id_evento);
        $eventoNombre = $this->getEventoNombre($id_evento);

        // Initialize mPDF
        $mpdf = new Mpdf();

        // Build the HTML content for the PDF
        $html = "
        <h1>Reporte de Evento: " . htmlspecialchars($eventoNombre) . "</h1>
        <p><strong>Fecha de inicio:</strong> " . date('Y-m-d', strtotime(min(array_column($reporte_evento, 'fecha')))) . "</p>
        <p><strong>Fecha de término:</strong> " . date('Y-m-d', strtotime(max(array_column($reporte_evento, 'fecha')))) . "</p>

        <h3>Detalles del Reporte</h3>
        <table border='1' cellpadding='10'>
            <thead>
                <tr>
                    <th>ID Venta</th>
                    <th>Producto</th>
                    <th>Cantidad Vendida</th>
                    <th>Monto Total</th>
                    <th>Forma de Pago</th>
                    <th>Tipo de Venta</th>
                </tr>
            </thead>
            <tbody>";

        foreach ($reporte_evento as $item) {
            $html .= "
            <tr>
                <td>" . htmlspecialchars($item['id_venta']) . "</td>
                <td>" . htmlspecialchars($item['producto']) . "</td>
                <td>" . htmlspecialchars($item['cantidad_vendida']) . "</td>
                <td>" . htmlspecialchars($item['monto_total']) . "</td>
                <td>" . htmlspecialchars($item['forma_de_pago']) . "</td>
                <td>" . htmlspecialchars($item['tipo_de_venta']) . "</td>
            </tr>";
        }

        $html .= "
            </tbody>
        </table>

        <h3>Resumen</h3>
        <p><strong>Cantidad de Productos Vendidos:</strong> " . array_sum(array_column($reporte_evento, 'cantidad_vendida')) . "</p>
        <p><strong>Monto Total Vendido:</strong> " . array_sum(array_column($reporte_evento, 'monto_total')) . "</p>";

        // Write HTML to the PDF
        $mpdf->WriteHTML($html);

        // Output the PDF as a download
        $mpdf->Output('reporte_evento_' . $id_evento . '.pdf', 'D');
    }


    
    public function actionVerPdf($id_evento)
{
    $reporte_evento = $this->getReportePorEvento($id_evento);
    $eventoNombre = $this->getEventoNombre($id_evento);

    // Initialize mPDF
    $mpdf = new \Mpdf\Mpdf(); // Make sure to include the namespace if needed

    // Build the HTML content for the PDF
    $html = "
    <h1>Reporte de Evento: " . htmlspecialchars($eventoNombre) . "</h1>
    <p><strong>Fecha de inicio:</strong> " . date('Y-m-d', strtotime(min(array_column($reporte_evento, 'fecha')))) . "</p>
    <p><strong>Fecha de término:</strong> " . date('Y-m-d', strtotime(max(array_column($reporte_evento, 'fecha')))) . "</p>

    <h3>Detalles del Reporte</h3>
    <table border='1' cellpadding='10'>
        <thead>
            <tr>
                <th>ID Venta</th>
                <th>Producto</th>
                <th>Cantidad Vendida</th>
                <th>Monto Total</th>
                <th>Forma de Pago</th>
                <th>Tipo de Venta</th>
            </tr>
        </thead>
        <tbody>";

    foreach ($reporte_evento as $item) {
        $html .= "
        <tr>
            <td>" . htmlspecialchars($item['id_venta']) . "</td>
            <td>" . htmlspecialchars($item['producto']) . "</td>
            <td>" . htmlspecialchars($item['cantidad_vendida']) . "</td>
            <td>" . htmlspecialchars($item['monto_total']) . "</td>
            <td>" . htmlspecialchars($item['forma_de_pago']) . "</td>
            <td>" . htmlspecialchars($item['tipo_de_venta']) . "</td>
        </tr>";
    }

    $html .= "
        </tbody>
    </table>

    <h3>Resumen</h3>
    <p><strong>Cantidad de Productos Vendidos:</strong> " . array_sum(array_column($reporte_evento, 'cantidad_vendida')) . "</p>
    <p><strong>Monto Total Vendido:</strong> " . array_sum(array_column($reporte_evento, 'monto_total')) . "</p>";

    // Write HTML to the PDF
    $mpdf->WriteHTML($html);

    // Output the PDF to the browser
    $mpdf->Output('reporte_evento_' . $id_evento . '.pdf', 'I'); // 'I' for inline display
}


}


