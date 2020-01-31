<?php

$isSubmitted = false;

$lastName = $firstName = $birthDate = $phoneNumber = $mail = '';

$regexName = "/^[A-Za-zéÉ][A-Za-záàâäãåçéèêëíìîïñóòôöõúùûüýÿæœ]+((-| )[A-Za-záàâäãåçéèêëíìîïñóòôöõúùûüýÿæœ]+)?$/";
$regexPhoneNumber = "/^0[67](\.[0-9]{2}){4}$/";
$regexDate = "/^((?:19|20)[0-9]{2})-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/";

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $isSubmitted = true;
    //contôle du nom
    $firstName = trim(filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_STRING));
    if (empty($firstName)) {
        $errors['firstName'] = 'Veuillez renseigner un prénom';
    } elseif (!preg_match($regexName, $firstName)) {
        $errors['firstName'] = 'Le prénom contient des caractères non autorisés !';
    }
    //contôle du prénom
    $lastName = trim(filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_STRING));
    if (empty($lastName)) {
        $errors['lastName'] = 'Veuillez renseigner un nom';
    } elseif (!preg_match($regexName, $lastName)) {
        $errors['lastName'] = 'Le nom contient des caractères non autorisés !';
    }
    //contôle de la date d'anniversaire
    $birthDate = trim(htmlspecialchars($_POST['birthDate']));
    if (empty($birthDate)) {
        $errors['birthDate'] = 'Veuillez renseigner une date de naissance';
    } elseif (!preg_match($regexDate, $birthDate)) {
        $errors['birthDate'] = 'Le format valide est aaaa-mm-jj !';
    }
    // Contrôle du téléphone
   $phoneNumber = trim(htmlspecialchars($_POST['phoneNumber']));
    if (empty($phoneNumber)) {
      $errors['phoneNumber'] = 'Veuillez renseigner un numéro de téléphone';
    } elseif (!preg_match($regexPhoneNumber, $phoneNumber)) {
     $errors['phoneNumber'] = 'Le numéro saisi n\'est pas valide !';
    }    
         //contôle de l'email
     $mail = trim(htmlspecialchars($_POST['mail']));
    if (empty($mail)) {
        $errors['mail'] = 'Veuillez renseigner un email';
    } elseif (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        $errors['mail'] = 'L\' email  n\'est pas valide!';
    }
}