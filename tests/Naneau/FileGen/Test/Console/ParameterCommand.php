<?php
namespace Naneau\FileGen\Test\Console;

use Naneau\FileGen\Structure;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * A simple command that uses the filegenParameters helper to ask for
 * parameters for a supplied Structure
 */
class ParameterCommand extends Command
{
    /**
     * The structure
     *
     * @var Structure
     */
    private $structure;

    /**
     * the receive params
     *
     * @var string[]
     */
    private $received = [];

    /**
     * Configure the command
     */
    protected function configure(): void
    {
        $this->setName('filegen:test:filegen-parameters');
    }

    /**
     * Get the structure
     */
    public function getStructure(): Structure
    {
        return $this->structure;
    }

    /**
     * The structure
     */
    public function setStructure(Structure $structure): self
    {
        $this->structure = $structure;

        return $this;
    }

    /**
     * Get the received parameters
     *
     * @return string[]
     */
    public function getReceived(): array
    {
        return $this->received;
    }

    /**
     * Set the received parameters
     *
     * @param string[] $received
     */
    public function setReceived(array $received): self
    {
        $this->received = $received;

        return $this;
    }

    /**
     * Execute the command
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $received = $this->getHelper('filegenParameters')->askParameters(
            $this->getStructure(),
            $input,
            $output
        );

        $this->setReceived($received);

        return 0;
    }
}
