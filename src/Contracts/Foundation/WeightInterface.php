<?php

namespace Jne\Contracts\Foundation;

interface WeightInterface
{
    /**
     * Create weight from grams.
     *
     * @param float $grams
     *
     * @return \Jne\Contracts\Foudation\WeightInterface
     */
    public static function fromGrams($grams);

    /**
     * Create weight from kilograms.
     *
     * @param float $kilograms
     *
     * @return \Jne\Contracts\Foudation\WeightInterface
     */
    public static function fromKilograms($kilograms);

    /**
     * Create weight from pounds.
     *
     * @param float $pounds
     *
     * @return \Jne\Contracts\Foudation\WeightInterface
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
