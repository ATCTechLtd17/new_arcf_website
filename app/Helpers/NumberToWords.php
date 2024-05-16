<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class NumberToWords
{
    public function convertToWords($number): ?string
    {
        if (!is_numeric($number)) {
            return null;
        }

        return self::numberToWords($number);
    }

    private function numberToWords($number): string
    {
        // Basic implementation for demonstration purposes
        // You may want to replace this with a more robust library for production

        $ones = ["", "one", "two", "three", "four", "five", "six", "seven", "eight", "nine"];
        $teens = ["", "eleven", "twelve", "thirteen", "fourteen", "fifteen", "sixteen", "seventeen", "eighteen", "nineteen"];
        $tens = ["", "ten", "twenty", "thirty", "forty", "fifty", "sixty", "seventy", "eighty", "ninety"];
        $thousands = ["", "thousand", "million", "billion", "trillion"];

        $num = abs($number);
        $words = "";

        for ($i = 0; $i < count($thousands) && $num > 0; $i++) {
            $chunk = $num % 1000;
            $num = floor($num / 1000);

            if ($chunk !== 0) {
                $chunkWords = self::convertChunkToWords($chunk, $ones, $teens, $tens);
                $words = $chunkWords . " " . $thousands[$i] . " " . $words;
            }
        }

        return $words ?: "zero";
    }

    private function convertChunkToWords($chunk, $ones, $teens, $tens): string
    {
        $words = "";

        // Convert hundreds place
        $hundreds = floor($chunk / 100);
        if ($hundreds > 0) {
            $words .= $ones[$hundreds] . " hundred";
        }

        // Convert tens and ones places
        $remainder = $chunk % 100;
        if ($remainder > 0) {
            if ($hundreds > 0) {
                $words .= " and ";
            }

            if ($remainder < 10) {
                $words .= $ones[$remainder];
            } elseif ($remainder < 20) {
                $words .= $teens[$remainder - 10];
            } else {
                $tensDigit = floor($remainder / 10);
                $onesDigit = $remainder % 10;
                $words .= $tens[$tensDigit];
                if ($onesDigit > 0) {
                    $words .= " " . $ones[$onesDigit];
                }
            }
        }

        return $words;
    }
}
