composer require phpmailer/phpmailer
<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Opravený název souboru

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $recipient = $_POST["email"];
    $subject = $_POST["subject"];
    $message = $_POST["message"];
    $count = (int)$_POST["count"];

    if ($count > 0 && filter_var($recipient, FILTER_VALIDATE_EMAIL)) {
        $mail = new PHPMailer(true);

        try {
            // SMTP nastavení
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com'; // SMTP server (např. Gmail)
            $mail->SMTPAuth   = true;
            $mail->Username   = 'tvuj@gmail.com'; // Tvůj e-mail
            $mail->Password   = 'tvojeheslo'; // Použij App Password (Google)
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            // Odesílatel
            $mail->setFrom('tvuj@gmail.com', 'Tvé jméno');

            // Odeslání e-mailů v cyklu
            for ($i = 0; $i < $count; $i++) {
                $mail->clearAddresses(); // Vyčistí předchozí adresy
                $mail->addAddress($recipient);
                $mail->Subject = $subject;
                $mail->Body    = $message;
                $mail->send();
                echo "E-mail č. " . ($i + 1) . " byl odeslán!<br>";
            }
        } catch (Exception $e) {
            echo "Chyba při odesílání e-mailu: {$mail->ErrorInfo}";
        }
    } else {
        echo "Neplatný e-mail nebo počet e-mailů.";
    }
}
?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <meta charset="UTF-8">
    <title>Hromadné odesílání e-mailů</title>
</head>