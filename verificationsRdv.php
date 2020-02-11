<?php

$isSubmitted = false;

$patients = $appointmentDate = $appointmentHour = '';

$regexName = "/^[A-Za-zéÉ][A-Za-záàâäãåçéèêëíìîïñóòôöõúùûüýÿæœ]+((-| )[A-Za-záàâäãåçéèêëíìîïñóòôöõúùûüýÿæœ]+)?$/";
$regexDate = "/^((?:19|20)[0-9]{2})-(0[1-9]|1[0-2])-(0[1-9]|[12][0-9]|3[01])$/";
// Regex qui accepte les heures de 09:00 à 18:00
$regexHour = "/^((09)|(1[0-8]))\:(([0]{2})|(30))$/";

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $isSubmitted = true;
    // contrôle de l'id
   $patients = trim(filter_input(INPUT_POST, 'patients', FILTER_SANITIZE_STRING));
//    if (empty($patients)) {
//        $errors['patient'] = 'Veuillez séléctionner un patient';
//    } 
    //contôle de la date de rendez-vous
    $appointmentDate = trim(htmlspecialchars($_POST['appointmentDate']));
    if (empty($appointmentDate)) {
        $errors['appointmentDate'] = 'Veuillez renseigner une date de rendez-vous';
    } elseif (!preg_match($regexDate, $appointmentDate)) {
        $errors['appointmentDate'] = 'Le format valide est aaaa-mm-jj !';
    }
    $appointmentHour = trim(htmlspecialchars($_POST['appointmentHour']));
    if (empty($appointmentHour)) {
        $errors['appointmentHour'] = 'Veuillez renseigner une heure de rendez-vous';
    } elseif (!preg_match($regexHour, $appointmentHour)) {
        $errors['appointmentHour'] = 'Veuillez entrer une heure de rendez-vous comprise entre 09:00 et 18:00';
    }
}