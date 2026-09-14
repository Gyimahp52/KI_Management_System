<?php 
function validateStudentInput($input) {
$errors = [];

if (!empty($input['new_password'])) {
if (strlen($input['new_password']) < 8) { $errors[]="Password must be at least 8 characters" ; } if
    ($input['new_password'] !==$input['confirm_password']) { $errors[]="Passwords do not match" ; } } if
    (!empty($_FILES['passport_picture'])) { $allowedTypes=['image/jpeg', 'image/png' ];
    $fileType=mime_content_type($_FILES['passport_picture']['tmp_name']); if (!in_array($fileType, $allowedTypes)) {
    $errors[]="Only JPG and PNG files are allowed" ; } } return $errors; }