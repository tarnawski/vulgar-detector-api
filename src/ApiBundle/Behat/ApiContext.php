<?php

namespace ApiBundle\Behat;


use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\Symfony2Extension\Context\KernelAwareContext;
use Behat\Symfony2Extension\Context\KernelDictionary;
use Behat\WebApiExtension\Context\WebApiContext;
use Coduo\PHPMatcher\Factory\SimpleFactory;
use Coduo\PHPMatcher\Matcher;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\StringInput;
use VulgarDetectorBundle\Entity\Word;

/**
 * Defines application features from the specific context.
 */
class ApiContext extends WebApiContext implements Context, SnippetAcceptingContext, KernelAwareContext
{
    use KernelDictionary;

    /**
     * @BeforeScenario @cleanDB
     * @AfterScenario @cleanDB
     */
    public function cleanDB()
    {
        $application = new Application($this->getKernel());
        $application->setAutoExit(false);
        $application->run(new StringInput("doctrine:schema:drop --force -n -q"));
        $application->run(new StringInput("doctrine:schema:create -n -q"));
    }

    /**
     * @return EntityManager
     */
    protected function getManager()
    {
        return $this->getContainer()->get('doctrine.orm.entity_manager');
    }

    /**
     * @param PyStringNode $string
     * @Then the JSON response should match:
     */
    public function theJsonResponseShouldMatch(PyStringNode $string)
    {
        $factory = new SimpleFactory();
        $matcher = $factory->createMatcher();
        $match = $matcher->match($this->response->getBody()->getContents(), $string->getRaw());
        \PHPUnit_Framework_Assert::assertTrue($match, $matcher->getError());
    }

    /**
     * @Given There are the following words:
     */
    public function thereAreTheFollowingWords(TableNode $table)
    {
        foreach ($table->getColumnsHash() as $row) {
            $word = new Word();
            $word->setName($row['NAME']);
            $word->setLanguage($row['LANGUAGE']);
            $this->getManager()->persist($word);
        }

        $this->getManager()->flush();
        $this->getManager()->clear();
    }

}
