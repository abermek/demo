<?php

namespace App\Tests\Service\ParamConverter;

use App\DTO\Product\ProductDTO;
use App\Exception\BadRequest\BadRequestExceptionInterface;
use App\Form\Type\Product\ProductType as ProductType;
use App\Service\ParamConverter\DTOConverter;
use Codeception\Test\Unit;
use Mockery;
use Mockery\MockInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use stdClass;
use Symfony\Component\Form\FormErrorIterator;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

class DTOConverterTest extends Unit
{
    /** @var FormFactoryInterface|MockInterface */
    private $formFactory;

    protected function _before()
    {
        $this->formFactory = Mockery::mock(FormFactoryInterface::class);
    }

    public function getSystemUnderTest(): DTOConverter
    {
        return new DTOConverter($this->formFactory);
    }

    /** @dataProvider dataProviderForItSupports */
    public function testItSupports(array $options, bool $expectedResult)
    {
        /** @var ParamConverter|MockInterface $config */
        $config = Mockery::mock(ParamConverter::class);
        $config
            ->shouldReceive('getOptions')
            ->andReturn($options);

        self::assertEquals($this->getSystemUnderTest()->supports($config), $expectedResult);
    }

    public function dataProviderForItSupports(): array
    {
        return [
            [['form' => 'MyForm'], true],
            [[], false],
        ];
    }

    public function testItCreatesARequestAttributeFromSubmittedForm()
    {
        /** @var ParamConverter|MockInterface $configuration */
        $configuration  = Mockery::mock(ParamConverter::class);
        /** @var FormInterface|MockInterface $form */
        $form           = Mockery::mock(FormInterface::class);
        $attributeName  = 'dto';
        $attributeClass = stdClass::class;
        $options        = [
            'form'      => 'FormType',
            'required'  => true
        ];

        $configuration
            ->shouldReceive('getOptions')
            ->andReturn($options);

        $configuration
            ->shouldReceive('getClass')
            ->andReturn($attributeClass);

        $this->formFactory
            ->shouldReceive('create')
            ->andReturn($form);

        $form->shouldReceive('handleRequest');

        $form
            ->shouldReceive('isSubmitted')
            ->andReturn(true);

        $form
            ->shouldReceive('isValid')
            ->andReturn(true);

        $form->shouldNotReceive('getErrors');

        $configuration
            ->shouldReceive('getName')
            ->andReturn($attributeName);

        $request = new Request();

        $this->getSystemUnderTest()->apply($request, $configuration);

        self::assertNotNull($request->attributes->get($attributeName));
    }

    public function testItThrowsAnExceptionIfFormIsNotValid()
    {
        /** @var ParamConverter|MockInterface $configuration */
        $configuration  = Mockery::mock(ParamConverter::class);
        /** @var FormInterface|MockInterface $form */
        $form           = Mockery::mock(FormInterface::class);
        /** @var FormErrorIterator|MockInterface $errors */
        $errors         = Mockery::mock(FormErrorIterator::class);
        $attributeClass = stdClass::class;
        $options        = [
            'form'      => 'FormType',
            'required'  => true
        ];

        $configuration
            ->shouldReceive('getOptions')
            ->andReturn($options);

        $configuration
            ->shouldReceive('getClass')
            ->andReturn($attributeClass);

        $this->formFactory
            ->shouldReceive('create')
            ->andReturn($form);

        $form->shouldReceive('handleRequest');

        $form
            ->shouldReceive('isSubmitted')
            ->andReturn(true);

        $form
            ->shouldReceive('isValid')
            ->andReturn(false);

        $form
            ->shouldReceive('getErrors')
            ->with(true)
            ->andReturn($errors);

        self::expectException(BadRequestExceptionInterface::class);

        $this->getSystemUnderTest()->apply(new Request(), $configuration);
    }
}
