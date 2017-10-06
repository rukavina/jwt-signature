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

namespace Jose\Component\Signature\Tests;

use Jose\Component\Checker\HeaderCheckerManagerFactory;
use Jose\Component\Checker\UnencodedPayloadChecker;
use Jose\Component\Core\Converter\StandardJsonConverter;
use Jose\Component\Core\AlgorithmManagerFactory;
use Jose\Component\Signature\Algorithm;
use Jose\Component\Signature\JWSBuilderFactory;
use Jose\Component\Signature\JWSLoaderFactory;
use Jose\Component\Signature\Serializer;
use PHPUnit\Framework\TestCase;

/**
 * Class AbstractSignatureTest.
 */
abstract class AbstractSignatureTest extends TestCase
{
    /**
     * @var AlgorithmManagerFactory
     */
    private $algorithmManagerFactory;

    /**
     * @return AlgorithmManagerFactory
     */
    protected function getAlgorithmManagerFactory(): AlgorithmManagerFactory
    {
        if (null === $this->algorithmManagerFactory) {
            $this->algorithmManagerFactory = new AlgorithmManagerFactory();
            $this->algorithmManagerFactory
                ->add('HS256', new Algorithm\HS256())
                ->add('HS384', new Algorithm\HS384())
                ->add('HS512', new Algorithm\HS512())
                ->add('ES256', new Algorithm\ES256())
                ->add('ES384', new Algorithm\ES384())
                ->add('ES512', new Algorithm\ES512())
                ->add('RS256', new Algorithm\RS256())
                ->add('RS384', new Algorithm\RS384())
                ->add('RS512', new Algorithm\RS512())
                ->add('PS256', new Algorithm\PS256())
                ->add('PS384', new Algorithm\PS384())
                ->add('PS512', new Algorithm\PS512())
                ->add('none', new Algorithm\None())
                ->add('EdDSA', new Algorithm\EdDSA());
        }

        return $this->algorithmManagerFactory;
    }

    /**
     * @var JWSBuilderFactory
     */
    private $jwsBuilderFactory;

    /**
     * @return JWSBuilderFactory
     */
    protected function getJWSBuilderFactory(): JWSBuilderFactory
    {
        if (null === $this->jwsBuilderFactory) {
            $this->jwsBuilderFactory = new JWSBuilderFactory(
                new StandardJsonConverter(),
                $this->getAlgorithmManagerFactory()
            );
        }

        return $this->jwsBuilderFactory;
    }

    /**
     * @var JWSLoaderFactory
     */
    private $jwsLoaderFactory;

    /**
     * @return JWSLoaderFactory
     */
    protected function getJWSLoaderFactory(): JWSLoaderFactory
    {
        if (null === $this->jwsLoaderFactory) {
            $this->jwsLoaderFactory = new JWSLoaderFactory(
                $this->getAlgorithmManagerFactory(),
                $this->getHeaderCheckerManagerFactory(),
                $this->getJWSSerializerManagerFactory()
            );
        }

        return $this->jwsLoaderFactory;
    }

    /**
     * @var HeaderCheckerManagerFactory
     */
    private $headerCheckerManagerFactory;

    /**
     * @return HeaderCheckerManagerFactory
     */
    protected function getHeaderCheckerManagerFactory(): HeaderCheckerManagerFactory
    {
        if (null === $this->headerCheckerManagerFactory) {
            $this->headerCheckerManagerFactory = new HeaderCheckerManagerFactory();
            $this->headerCheckerManagerFactory
                ->add('b64', new UnencodedPayloadChecker())
            ;
        }

        return $this->headerCheckerManagerFactory;
    }

    /**
     * @var null|Serializer\JWSSerializerManagerFactory
     */
    private $jwsSerializerManagerFactory = null;

    /**
     * @return Serializer\JWSSerializerManagerFactory
     */
    protected function getJWSSerializerManagerFactory(): Serializer\JWSSerializerManagerFactory
    {
        if (null === $this->jwsSerializerManagerFactory) {
            $this->jwsSerializerManagerFactory = new Serializer\JWSSerializerManagerFactory();
            $this->jwsSerializerManagerFactory->add(new Serializer\CompactSerializer(new StandardJsonConverter()));
            $this->jwsSerializerManagerFactory->add(new Serializer\JSONFlattenedSerializer(new StandardJsonConverter()));
            $this->jwsSerializerManagerFactory->add(new Serializer\JSONGeneralSerializer(new StandardJsonConverter()));
        }

        return $this->jwsSerializerManagerFactory;
    }

    /**
     * @var null|Serializer\JWSSerializerManager
     */
    private $jwsSerializerManager = null;

    /**
     * @return Serializer\JWSSerializerManager
     */
    protected function getJWSSerializerManager(): Serializer\JWSSerializerManager
    {
        if (null === $this->jwsSerializerManager) {
            $this->jwsSerializerManager = Serializer\JWSSerializerManager::create([
                new Serializer\CompactSerializer(new StandardJsonConverter()),
                new Serializer\JSONFlattenedSerializer(new StandardJsonConverter()),
                new Serializer\JSONGeneralSerializer(new StandardJsonConverter()),
            ]);
        }

        return $this->jwsSerializerManager;
    }
}
