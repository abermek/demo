<?php

namespace App\Tests\Service\Product;

use App\DTO\Product\ProductDTO;
use App\Entity\Product;
use App\Money\MoneyInterface;
use App\Service\Product\UpdateProduct;
use Codeception\Test\Unit;
use Mockery;
use Mockery\MockInterface;

class UpdateProductTest extends Unit
{
    public function getSystemUnderTest(): UpdateProduct
    {
        return new UpdateProduct();
    }

    public function testUpdateName()
    {
        /** @var Product|MockInterface $product */
        $product = Mockery::mock(Product::class);
        $dto     = new ProductDTO();
        $name    = 'Test';

        $dto->setName($name);

        $product
            ->shouldReceive('updateName')
            ->with($name);

        $this->getSystemUnderTest()->execute($product, $dto);
    }

    public function testUpdatePrice()
    {
        /** @var Product|MockInterface $product */
        $product = Mockery::mock(Product::class);
        /** @var MoneyInterface|MockInterface $price */
        $price   = Mockery::mock(MoneyInterface::class);
        $dto     = new ProductDTO();

        $dto->setPrice($price);

        $product
            ->shouldReceive('updatePrice')
            ->with($price);

        $this->getSystemUnderTest()->execute($product, $dto);
    }

    public function testEmptyPropertyDoesNotGetUpdated()
    {
        /** @var Product|MockInterface $product */
        $product = Mockery::mock(Product::class);

        $product
            ->shouldNotReceive('updateName')
            ->shouldNotReceive('updatePrice');

        $this->getSystemUnderTest()->execute($product, new ProductDTO());
    }
}
