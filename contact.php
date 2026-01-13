<?php
$success = false;
$errors = [];

$name = $email = $message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    function clean($data) {
        return htmlspecialchars(trim($data));
    }

    $name = clean($_POST["name"] ?? "");
    $email = clean($_POST["email"] ?? "");
    $message = clean($_POST["message"] ?? "");

    if (empty($name)) {
        $errors[] = "Le nom est obligatoire.";
    }

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Email invalide.";
    }

    if (empty($message)) {
        $errors[] = "Le message est obligatoire.";
    }

    if (empty($errors)) {
        $to = "kenny.dodey@gmail.com";
        $subject = "Message depuis le portfolio";
        $body = "Nom : $name\nEmail : $email\n\nMessage :\n$message";
        $headers = "From: $email";

        mail($to, $subject, $body, $headers);
        $success = true;

        $name = $email = $message = "";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Contact</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSS -->
    <link rel="stylesheet" href="css/contact.css">
</head>

<body>
<?php include 'header.html'; ?>

<div class="contact-container">
    <h2>Contactez-moi</h2>

    <?php if ($success): ?>
        <p class="success">Votre message a bien été envoyé ✅</p>
    <?php endif; ?>

    <?php foreach ($errors as $error): ?>
        <p class="error"><?= $error ?></p>
    <?php endforeach; ?>

    <form method="post">
        <input type="text" name="name" placeholder="Votre nom" value="<?= $name ?>">
        <input type="email" name="email" placeholder="Votre email" value="<?= $email ?>">
        <textarea name="message" placeholder="Votre message"><?= $message ?></textarea>
        <button type="submit">Envoyer</button>
    </form>
</div>

</body>
</html>
