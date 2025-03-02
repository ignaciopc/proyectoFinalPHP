<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Cargar PHPMailer si no usas Composer
require 'vendor/autoload.php'; // Si usas Composer
// require 'ruta_a_phpmailer/PHPMailer.php'; // Si lo descargaste manualmente

function enviarCorreoPedido($emailDestino, $nombreCliente, $pedido)
{
    $mail = new     (true);
    try {
        // Configurar SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Servidor SMTP (Gmail, Outlook, etc.)
        $mail->SMTPAuth = true;
        $mail->Username = 'enviarcorreo71@gmail.com'; // Tu correo
        $mail->Password = 'tgvz djpc ayvq gvbc'; // Contraseña o App Password si usas Gmail
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587; // Puerto de salida

        // Configuración del correo
        $mail->setFrom('enviarcorreo71@gmail.com', 'Tienda Online');
        $mail->addAddress($emailDestino, $nombreCliente); // Destinatario
        $mail->Subject = 'Confirmación de Pedido - Tienda Online';

        // Construir el cuerpo del email
        $mensaje = "<h2>Hola $nombreCliente,</h2>";
        $mensaje .= "<p>Gracias por tu compra. Aquí están los detalles de tu pedido:</p>";
        $mensaje .= "<ul>";
        foreach ($pedido['productos'] as $producto) {
            $mensaje .= "<li>{$producto['nombre']} - Cantidad: {$producto['cantidad']} - Precio: {$producto['precio']}€</li>";
        }
        $mensaje .= "</ul>";
        $mensaje .= "<p>Total: {$pedido['total']}€</p>";
        $mensaje .= "<p>Esperamos verte pronto.</p>";

        // Enviar email en formato HTML
        $mail->isHTML(true);
        $mail->Body = $mensaje;

        // Enviar el correo
        $mail->send();
        return true;
    } catch (Exception $e) {
        return "Error al enviar el correo: {$mail->ErrorInfo}";
    }
}

?>