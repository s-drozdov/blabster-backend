<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Http\ValueResolver;

use Override;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\Validator\Exception\ValidationFailedException;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Blabster\Application\Bus\CqrsElementInterface;

/**
 * @template T of CqrsElementInterface
 */
abstract readonly class AbstractValueResolver implements ValueResolverInterface
{
    public function __construct(
        private ValidatorInterface $validator,
    ) {
        /*_*/
    }

    /**
     * @return iterable<T>
     */
    #[Override]
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        if ($argument->getType() !== $this->getTargetClass()) {
            return [];
        }
        
        $command = $this->createFromRequest($request);
        
        $errors = $this->validator->validate($command);

        if (count($errors) > 0) {
            throw new ValidationFailedException($command, $errors);
        }

        yield $command;
    }

    /**
     * @return class-string
     */
    abstract protected function getTargetClass(): string;

    /**
     * @return T
     */
    abstract protected function createFromRequest(Request $request): CqrsElementInterface;
}