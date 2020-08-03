<?php
namespace Naneau\FileGen\Console\Helper;

use Naneau\FileGen\Structure;
use Naneau\FileGen\Parameter\Parameter;

use Symfony\Component\Console\Helper\HelperInterface;
use Symfony\Component\Console\Helper\HelperSet;
use Symfony\Component\Console\Helper\QuestionHelper;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

/**
 * Asks questions on the console
 */
class ParameterHelper implements HelperInterface
{
    /**
     * The helperset
     *
     * @var HelperSet|null
     */
    private $helperSet;

    /**
     * Ask for a parameter's value
     *
     * @return string[] the parameter set as a key/value hash for use in a generator
     */
    public function askParameters(Structure $structure, InputInterface $input, OutputInterface $output): array
    {
        $parameters = [];
        foreach ($structure->getParameterDefinition() as $parameter) {
            $parameters[$parameter->getName()] = $this->askParameter(
                $parameter,
                $input,
                $output
            );
        }
        return $parameters;
    }

    /**
     * Ask for a parameter's value
     */
    public function askParameter(Parameter $parameter, InputInterface $input, OutputInterface $output): string
    {
        if ($parameter->hasDefaultValue()) {
            $question = new Question($parameter->getDescription(), $parameter->getDefaultValue());
        } else {
            $question = new Question($parameter->getDescription());
        }

        return $this->getQuestionHelper()->ask($input, $output, $question);
    }

    /**
     * Sets the helper set associated with this helper.
     *
     * @param HelperSet $helperSet A HelperSet instance
     */
    public function setHelperSet(HelperSet $helperSet = null): void
    {
        $this->helperSet = $helperSet;
    }

    /**
     * Gets the helper set associated with this helper.
     */
    public function getHelperSet(): ?HelperSet
    {
        return $this->helperSet;
    }

    /**
     * Returns the canonical name of this helper.
     */
    public function getName(): string
    {
        return 'filegenParameters';
    }

    /**
     * Get the question helper
     */
    private function getQuestionHelper(): QuestionHelper
    {
        $helperSet = $this->getHelperSet();
        assert($helperSet instanceof HelperSet);

        $helper = $helperSet->get('question');
        assert($helper instanceof QuestionHelper);

        return $helper;
    }
}
