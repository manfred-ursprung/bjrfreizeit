<?php
namespace Bjr\BjrLend\Tests;
/**
 * Created by PhpStorm.
 * User: manfred
 * Date: 06.05.14
 * Time: 20:07
 *
 *  Test case for class Tx_Bjr_lend_Controller_ArticleRepository.
 */


class ArticleRepositoryTest extends \TYPO3\CMS\Extbase\Tests\Unit\BaseTestCase  {

    /**
     * @var
     */
    protected $fixture;

    /**
     * @var
     */
    protected $testingFramework;

    public function setUp() {
        $this->fixture = new \Bjr\BjrLend\Domain\Repository\ArticleRepository();
        $this->testingFramework = new Tx_Phpunit_Framework('tx_bjrlend');
    }

    public function tearDown() {
        $this->testingFramework->cleanUp();
        unset($this->fixture);
        unset($this->testingFramework);
    }

    /**
     * @test
     */
    public function getArticleByUid(){
        $expectedTitle = 'Fotodrucker';
        $uid = $this->insertFotodrucker();
        $test = $this->fixture->findByUid($uid);

        $this->assertFalse(is_object($test), 'Artikel ist kein Objekt');
        //$this->assertTrue(true);
/*        $this->assertSame(
            $expectedTitle,
            $test->getUid()
        );
*/
    }

    protected function insertFotodrucker(){
        $pid = 0;

        $uid = $this->testingFramework->createRecord(
            'tx_bjrlend_domain_model_article',
            array(
                'pid' => $pid,
                'title' => 'Fotodrucker',
                'short_description' => 'Canon SELPHY CP750/CP740 Es ist möglich direkt ',
                'lend_conditions' => 'Ausleihgebühr: 0,35 Euro pro Foto',
                'fee'  => '0,35 Euro pro Foto'
            )
        );
        return $uid;
    }


}