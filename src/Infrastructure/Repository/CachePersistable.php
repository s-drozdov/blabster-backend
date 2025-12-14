<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Repository;

use Webmozart\Assert\Assert;
use Blabster\Domain\Entity\EntityInterface;
use Blabster\Domain\Repository\RepositoryInterface;
use Blabster\Domain\ValueObject\UuidInterface;
use Blabster\Library\Helper\String\StringHelperInterface;

/**
 * @template T of EntityInterface
 */
trait CachePersistable
{
    /**
     * @return T
     * @psalm-suppress MoreSpecificReturnType
     */
    public function getByUuid(UuidInterface $uuid): EntityInterface
    {
        /** @var T|null $entity */
        $entity = $this->cache->get(
            $this->getStringHelper()->getSlugForClass((string) $uuid, $this),
        );

        Assert::notNull(
            $entity, 
            $this->getNotFoundErrorMessage($uuid),
        );

        return $entity;
    }

    /**
     * @return T|null
     * @psalm-suppress MoreSpecificReturnType
     */
    public function findByUuid(UuidInterface $uuid): ?EntityInterface
    {
        /** @var T|null $entity */
        $entity = $this->cache->get(
            $this->stringHelper->getSlugForClass((string) $uuid, $this->getEntityFqcn()),
        );

        return $entity;
    }

    public function save(EntityInterface $entity): void
    {
        $this->cache->set(
            $this->getStringHelper()->getSlugForClass((string) $entity->getUuid(), $entity),
            $entity,
            $this->getTtl(),
        );
    }
    
    abstract private function getTtl(): ?int;

    abstract private function getStringHelper(): StringHelperInterface;

    /**
     * @return class-string<EntityInterface>
     */
    abstract private function getEntityFqcn(): string;

    private function getNotFoundErrorMessage(UuidInterface $uuid): string
    {
        return sprintf(
            RepositoryInterface::ERROR_NOT_FOUND, 
            $this->getStringHelper()->getClassShortName($this), 
            $uuid,
        );
    }
}
