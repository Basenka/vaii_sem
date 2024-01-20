<?php

namespace App\Validators;

class ProductValidator
{
    public static function validateName($name): string
    {
        $minLength = 3;
        $maxLength = 50;

        if (empty($name)) {
            return 'Názov produktu je povinný.';
        } elseif (preg_match('/[!@#$%^&*()_+={}[\]:;<>,.?~\\/-]/', $name)) {
            return 'Názov produktu nemôže obsahovať špeciálne znaky.';
        } elseif (strlen($name) < $minLength || strlen($name) > $maxLength) {
            return 'Názov produktu musí byť medzi ' . $minLength . ' a ' . $maxLength . ' znakmi.';
        }

        return '';
    }

    public static function validatePicture($file): string
    {
        if (empty($file)) {
            return 'Obrázok produktu je povinný.';
        }

        $allowedExtensions = ['jpg', 'jpeg', 'png'];  // Add more if needed
        $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (!in_array($fileExtension, $allowedExtensions)) {
            return 'Nepovolený formát obrázka. Povolené sú len súbory s koncovkami ' . implode(', ', $allowedExtensions) . '.';
        }

        return '';
    }

    public static function validatePrice($price): string
    {
        $minValue = 0;
        $maxValue = 10000;

        if (empty($price)) {
            return 'Cena produktu je povinná.';
        } elseif (!is_numeric($price) || floatval($price) < $minValue || floatval($price) > $maxValue) {
            return 'Cena produktu musí byť číslo medzi ' . $minValue . ' a ' . $maxValue . '.';
        }

        return '';
    }

    public static function validateDescription($description): string
    {
        $minLength = 10;
        $maxLength = 800;

        if (empty($description)) {
            return 'Popis produktu je povinný.';
        } elseif (strlen($description) < $minLength || strlen($description) > $maxLength) {
            return 'Popis produktu musí byť medzi ' . $minLength . ' a ' . $maxLength . ' znakmi.';
        }

        return '';
    }

    public static function validateCare($care): string
    {
        $minLength = 10;
        $maxLength = 1500;

        if (empty($care)) {
            return 'Starostlivosť o produkt je povinná.';
        } elseif (strlen($care) < $minLength || strlen($care) > $maxLength) {
            return 'Starostlivosť o produkt musí byť medzi ' . $minLength . ' a ' . $maxLength . ' znakmi.';
        }

        return '';
    }
}
