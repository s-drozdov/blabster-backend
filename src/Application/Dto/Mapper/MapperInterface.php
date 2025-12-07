<?php

declare(strict_types=1);

namespace Blabster\Application\Dto\Mapper;

use BadMethodCallException;
use Blabster\Library\Dto\DtoInterface;
use Blabster\Domain\DomainObjectInterface;

/**
 * @template TObject of DomainObjectInterface
 * @template TDto of DtoInterface
 */
interface MapperInterface
{
    /**
     * @param TObject $object
     * 
     * @return TDto
     * @throws BadMethodCallException
     */
    public function mapDomainObjectToDto(DomainObjectInterface $object): DtoInterface;

    /**
     * @param TDto $dto
     * 
     * @return TObject
     * @throws BadMethodCallException
     */
    public function mapDtoToDomainObject(DtoInterface $dto): DomainObjectInterface;

    /**
     * Getting inner type fqcn for serialization or null in case of simple types
     */
    public function getEntityType(): ?string;

    /**
     * Getting inner type fqcn for serialization or null in case of simple types
     */
    public function getDtoType(): ?string;
}
