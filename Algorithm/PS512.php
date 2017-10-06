<?php

declare(strict_types=1);

/*
 * The MIT License (MIT)
 *
 * Copyright (c) 2014-2017 Spomky-Labs
 *
 * This software may be modified and distributed under the terms
 * of the MIT license.  See the LICENSE file for details.
 */

namespace Jose\Component\Signature\Algorithm;

use Jose\Component\Signature\Util\RSA as JoseRSA;

/**
 * Class PS512.
 */
final class PS512 extends RSA
{
    /**
     * @return string
     */
    protected function getAlgorithm(): string
    {
        return 'sha512';
    }

    /**
     * @return int
     */
    protected function getSignatureMethod(): int
    {
        return JoseRSA::SIGNATURE_PSS;
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return 'PS512';
    }
}