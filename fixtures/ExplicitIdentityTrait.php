<?php

namespace Fixture;

use Doctrine\ORM\Id\AssignedGenerator;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\Persistence\ObjectManager;
use ReflectionClass;

trait ExplicitIdentityTrait
{
    protected int $id = 1;

    # https://stackoverflow.com/questions/5301285/explicitly-set-id-with-doctrine-when-using-auto-strategy
    protected function explicitIdentity(ObjectManager $manager, string $entityClass): void
    {
        /** @var ClassMetadata $metadata */
        $metadata = $manager->getClassMetadata($entityClass);

        $metadata->setIdGeneratorType(ClassMetadata::GENERATOR_TYPE_NONE);
        $metadata->setIdGenerator(new AssignedGenerator());
    }

    protected function setId($object, int $id = null): int
    {
        if (!$id) {
            $id = $this->id++;
        }

        $reflectionClass = new ReflectionClass(get_class($object));

        $reflectionProperty = $reflectionClass->getProperty('id');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($object, $id);

        return $id;
    }
}
