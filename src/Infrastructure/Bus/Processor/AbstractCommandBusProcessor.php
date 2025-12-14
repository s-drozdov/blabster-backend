<?php

declare(strict_types=1);

namespace Blabster\Infrastructure\Bus\Processor;

use Blabster\Application\Bus\CqrsBusInterface;
use Symfony\Component\Console\Command\Command;
use Blabster\Application\Bus\CqrsResultInterface;
use Blabster\Application\Bus\CqrsElementInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;

/**
 * @template TElement of CqrsElementInterface
 * @template TResult of CqrsResultInterface
 */
abstract readonly class AbstractCommandBusProcessor
{
    public function __construct(
        
        /** @var CqrsBusInterface<TElement, TResult> $bus */
        private CqrsBusInterface $bus,

        private SerializerInterface $serializer,
    ){
        /*_*/
    }

    public function process(InputInterface $input, OutputInterface $output, string $useCaseClass): int
    {
        $result = $this->bus->execute(
            $this->serializer->deserialize(
                $this->serializer->serialize(
                    $input->getOptions(),
                    JsonEncoder::FORMAT,
                ),
                $useCaseClass,
                JsonEncoder::FORMAT,
            ),
        );

        $output->write(
            $this->serializer->serialize($result, JsonEncoder::FORMAT),
            true,
        );

        return Command::SUCCESS;
    }
}
