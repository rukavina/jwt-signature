<?php

declare(strict_types=1);

/*
 * The MIT License (MIT)
 *
 * Copyright (c) 2014-2018 Spomky-Labs
 *
 * This software may be modified and distributed under the terms
 * of the MIT license.  See the LICENSE file for details.
 */

namespace Jose\Component\Signature;

class Signature
{
    /**
     * @var null|string
     */
    private $encodedProtectedHeader;

    /**
     * @var array
     */
    private $protectedHeader;

    /**
     * @var array
     */
    private $header;

    /**
     * @var string
     */
    private $signature;

    /**
     * Signature constructor.
     *
     * @param string      $signature
     * @param array       $protectedHeader
     * @param null|string $encodedProtectedHeader
     * @param array       $header
     */
    private function __construct(string $signature, array $protectedHeader, ?string $encodedProtectedHeader, array $header)
    {
        $this->protectedHeader = null === $encodedProtectedHeader ? [] : $protectedHeader;
        $this->encodedProtectedHeader = $encodedProtectedHeader;
        $this->signature = $signature;
        $this->header = $header;
    }

    /**
     * Creates a new signature.
     *
     * @internal
     *
     * @param string      $signature
     * @param array       $protectedHeader
     * @param string|null $encodedProtectedHeader
     * @param array       $header
     *
     * @return Signature
     */
    public static function create(string $signature, array $protectedHeader, ?string $encodedProtectedHeader, array $header = []): self
    {
        return new self($signature, $protectedHeader, $encodedProtectedHeader, $header);
    }

    /**
     * The protected header associated with the signature.
     *
     * @return array
     */
    public function getProtectedHeader(): array
    {
        return $this->protectedHeader;
    }

    /**
     * The unprotected header associated with the signature.
     *
     * @return array
     */
    public function getHeader(): array
    {
        return $this->header;
    }

    /**
     * The protected header associated with the signature.
     *
     * @return null|string
     */
    public function getEncodedProtectedHeader(): ?string
    {
        return $this->encodedProtectedHeader;
    }

    /**
     * Returns the value of the protected header of the specified key.
     *
     * @param string $key The key
     *
     * @return mixed|null Header value
     */
    public function getProtectedHeaderParameter(string $key)
    {
        if ($this->hasProtectedHeaderParameter($key)) {
            return $this->getProtectedHeader()[$key];
        }

        throw new \InvalidArgumentException(\sprintf('The protected header "%s" does not exist', $key));
    }

    /**
     * Returns true if the protected header has the given parameter.
     *
     * @param string $key The key
     *
     * @return bool
     */
    public function hasProtectedHeaderParameter(string $key): bool
    {
        return \array_key_exists($key, $this->getProtectedHeader());
    }

    /**
     * Returns the value of the unprotected header of the specified key.
     *
     * @param string $key The key
     *
     * @return mixed|null Header value
     */
    public function getHeaderParameter(string $key)
    {
        if ($this->hasHeaderParameter($key)) {
            return $this->header[$key];
        }

        throw new \InvalidArgumentException(\sprintf('The header "%s" does not exist', $key));
    }

    /**
     * Returns true if the unprotected header has the given parameter.
     *
     * @param string $key The key
     *
     * @return bool
     */
    public function hasHeaderParameter(string $key): bool
    {
        return \array_key_exists($key, $this->header);
    }

    /**
     * Returns the value of the signature.
     *
     * @return string
     */
    public function getSignature(): string
    {
        return $this->signature;
    }
}
