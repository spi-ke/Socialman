<?php

namespace Herrera\Service\Update;

use Herrera\Service\Container;
use Herrera\Service\Update\UpdateServiceProvider;
use Herrera\PHPUnit\TestCase;
use Phar;

class UpdateServiceProviderTest extends TestCase
{
    private $cwd;
    private $dir;

    public function testRegister()
    {
        file_put_contents('manifest.json', '[]');

        $container = new Container();
        $container->register(new UpdateServiceProvider(), array(
            'update.url' => "file://{$this->dir}/manifest.json"
        ));

        $this->assertInstanceOf('Closure', $container['update']);
        $this->assertInstanceOf(
            'Herrera\\Phar\\Update\\Manager',
            $container['update.manager']
        );
        $this->assertInstanceOf(
            'Herrera\\Phar\\Update\\Manifest',
            $container['update.manifest']
        );
    }

    /**
     * @depends testRegister
     */
    public function testUpdate()
    {
        $phar = new Phar('running.phar');
        $phar->addFromString('go.php', '<?php echo 1;');
        $phar->setStub($phar->createDefaultStub('go.php'));

        unset($phar);

        $phar = new Phar('test-2.0.0-alpha.1.phar');
        $phar->addFromString('go.php', '<?php echo 2;');
        $phar->setStub($phar->createDefaultStub('go.php'));

        unset($phar);

        file_put_contents('manifest.json', json_encode(array(
            array(
                'name' => 'test.phar',
                'sha1' => sha1_file($this->dir . '/test-2.0.0-alpha.1.phar'),
                'url' => "file://{$this->dir}/test-2.0.0-alpha.1.phar",
                'version' => '2.0.0-alpha.1'
            )
        )));

        $container = new Container();
        $container->register(new UpdateServiceProvider(), array(
            'update.url' => 'manifest.json'
        ));

        $_SERVER['argv'][0] = $this->dir . DIRECTORY_SEPARATOR . 'running.phar';

        $container['update']('1.0.0', false, true);

        $this->assertEquals('2', exec('php running.phar'));
    }

    protected function setUp()
    {
        $this->cwd = getcwd();
        $this->dir = $this->createDir();

        chdir($this->dir);
    }

    protected function tearDown()
    {
        chdir($this->cwd);

        parent::tearDown();
    }
}