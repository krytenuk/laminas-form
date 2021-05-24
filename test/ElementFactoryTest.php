<?php

namespace LaminasTest\Form;

use Interop\Container\ContainerInterface;
use Laminas\Form\ElementFactory;
use Laminas\ServiceManager\ServiceLocatorInterface;
use LaminasTest\Form\TestAsset\ArgumentRecorder;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

use function uniqid;

use const PHP_INT_MAX;

class ElementFactoryTest extends TestCase
{
    use ProphecyTrait;

    public function validCreationOptions()
    {
        yield 'array' => [['key' => 'value'], ['key' => 'value']];
        yield 'empty-array' => [[], []];
        yield 'null' => [null, []];
    }

    /**
     * @dataProvider validCreationOptions
     *
     * @param mixed $creationOptions
     * @param array $expectedValue
     */
    public function testValidCreationOptions($creationOptions, array $expectedValue)
    {
        $container = $this->prophesize(ServiceLocatorInterface::class)
            ->willImplement(ContainerInterface::class)
            ->reveal();

        $factory = new ElementFactory();
        $result = $factory->__invoke($container, ArgumentRecorder::class, $creationOptions);
        $this->assertInstanceOf(ArgumentRecorder::class, $result);
        $this->assertSame(['argumentrecorder', $expectedValue], $result->args);
    }
}
