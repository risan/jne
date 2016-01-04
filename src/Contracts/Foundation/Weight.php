<?php

namespace Jne\Contracts\Foundation;

interface Weight
{
    /**
     * Create weight from grams.
     *
     * @param float $grams
     *
     * @return Jne\Contracts\Foudation\Weight
     */
    public static function fromGrams($grams);

    /**
     * Create weight from kilograms.
     *
     * @param float $kilograms
     *
     * @return Jne\Contracts\Foudation\Weight
     */
    public static function fromKilograms($kilograms);

    /**
     * Create weight from punds.
     *
     * @param float $punds
     *
     * @return Jne\Contracts\Foudation\Weight
     */
    public static function fromPounds($pounds);

    /**
     * Get weight in grams.
     *
     * @return float
     */
    public function grams();

    /**
     * Get weight in kilograms.
     *
     * @return float
     */
    public function kilograms();

    /**
     * Get weight in pounds.
     *
     * @return float
     */
    public function pounds();
}
