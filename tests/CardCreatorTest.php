<?php
namespace raphiz\passwordcards;

class CardCreatorTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException     \Exception
     * @expectedExceptionMessage     The given $configuration is null!
     */
    public function testConstructorDeclinesNull()
    {
        new CardCreator(null);
    }

    /**
    * @expectedException     \Exception
    * @expectedExceptionMessage     The given $configuration is not a valid Configuration object.
    */
    public function testConstructorDeclinesNonConfigurationInstances()
    {
        new CardCreator('fooBaa');
    }

    public function testGetSvgFilePath()
    {
        $creator = new CardCreator($this->testConfiguration);
        $file = $creator->getSvgFilePath('abc');
        $this->assertStringEndsWith('/templates/abc.svg', $file);
    }

    public function testCreateHappyPath()
    {
        $creator = new CardCreator($this->testConfiguration);
        $creator->render($creator->getSvgFilePath('simple_front'));
    }



    public function setUp()
    {
        $this->testConfiguration = new Configuration(10, null, null, 8, '', '#000000', '#ffffff');
    }
}
