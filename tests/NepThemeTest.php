<?php 

use Coolpraz\NepTheme\Theme;
use Orchestra\Testbench\TestCase;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamDirectory;
use org\bovigo\vfs\visitor\vfsStreamStructureVisitor;

class NepThemeTest extends TestCase
{
	/**
	 * @var vfsStreamDirectory
	 */
	private $root;

	/**
	 * Added Service Provider
	 */
	protected function getPackageProviders($app)
	{
		return [
			Coolpraz\NepTheme\NepThemeServiceProvider::class
		];
	}

	/**
	 * Added Facade
	 */
	protected function getPackageAliases($app)
	{
		return [
			'ThemeFacade' => Coolpraz\NepTheme\Facades\Theme::class
		];
	}

	public function setUp()
	{
		parent::setUp();

		$this->structure = [
			'default' => [
				'assets' => [
					'css' => [
						'main.css' => 'This is main.css'
					],
					'js' => [
						'main.js' => 'This is main.js'
					]
				],
				'views' => [
					'layouts' => [
						'app.blade.php' => 'This is layout'
					],
					'partials' => [
						'nav.blade.php' => 'This is nav partials'
					],
					'index.blade.php' => 'This is index page'
				]
			]
		];

		$this->root = vfsStream::setup('theme', null, $this->structure);

		$this->theme = new Theme;
	}

	protected function getEnvironmentSetUp($app)
	{
		$app['config']->set('theme.themeDefault', 'default');
		$app['config']->set('theme.themePath', vfsStream::url('theme'));
	}

	/** @test */
	function test_theme()
	{
		// dd(vfsStream::inspect(new vfsStreamStructureVisitor())->getStructure());
		// dd(config('themes.themePath'));
	    $this->assertInstanceOf(Theme::class, $this->theme);
	}

	/** @test */
	function can_check_theme_exists()
	{
	    $this->assertTrue($this->theme->exists('default'));
	    $this->assertFalse($this->theme->exists('socio'));
	}

	/** @test */
	function can_set_theme_permanently()
	{
		vfsStream::newDirectory('naya/views')->at($this->root);
	    $themeName = $this->theme->set('naya')->presist();

	    $this->assertInstanceOf(Theme::class, $themeName);
		$this->assertEquals(config('theme.themeDefault'), $themeName->get());
		$this->assertEquals($this->theme->get(), $themeName->get());
		$this->assertNotEquals('default', config('theme.themeDefault'));
	}

	/** @test */
	function can_change_theme_permanently()
	{
	    vfsStream::newDirectory('naya/views')->at($this->root);

	    $themeName = $this->theme->set('naya')->presist();

	    $this->assertInstanceOf(Theme::class, $themeName);
		$this->assertEquals($themeName->get(), $this->theme->get());

	    $themeName = $this->theme->set('default');
	    $this->assertNotEquals($this->theme->get(), config('theme.themeDefault'));
	    $this->assertEquals('naya', config('theme.themeDefault'));
	}

	/** @test */
	function can_set_and_change_theme_on_fly()
	{
	    vfsStream::newDirectory('naya/views')->at($this->root);
	    vfsStream::newDirectory('oldTheme/views')->at($this->root);
	    
	    $this->theme->beforeDefaultTheme(function ($theme) {
	    	$this->assertEquals($theme->set('naya')->get(), $this->theme->get());
	    });

	    $this->assertEquals('oldTheme', $this->theme->set('oldTheme')->get());
	    $this->assertEquals('default', config('theme.themeDefault'));
	    $this->assertNotEquals('naya', config('theme.themeDefault'));
	    $this->assertNotEquals('oldTheme', config('theme.themeDefault'));
	}

	/** @test */
	function can_set_theme_path_permanently()
	{
	    $newPath = vfsStream::newDirectory('naya/views')->at($this->root)->url();

	    $themePath = $this->theme->setPath($newPath)->presist();

		$this->assertEquals(config('theme.themePath'), $themePath->getPath());
		$this->assertEquals($this->theme->getPath(), $themePath->getPath());
		$this->assertNotEquals(vfsStream::url('theme'), config('theme.themePath'));
	}

	/** @test */
	function can_change_theme_path_permanently()
	{
	    $newPath = vfsStream::newDirectory('naya/views')->at($this->root)->url();

	    $themePath = $this->theme->setPath($newPath)->presist();

		$this->assertEquals($themePath->getPath(), $this->theme->getPath());

	    $themePath = $this->theme->setPath(vfsStream::url('theme'));
	    $this->assertNotEquals($this->theme->getPath(), config('theme.themePath'));
	    $this->assertEquals($newPath, config('theme.themePath'));
	}

	/** @test */
	function can_set_and_change_theme_path_on_fly()
	{
		$newPath = vfsStream::newDirectory('naya/views')->at($this->root)->url();
		$newPath1 = vfsStream::newDirectory('oldTheme/views')->at($this->root)->url();
	    
	    $this->theme->beforeDefaultPath(function ($theme) use ($newPath) {
	    	$this->assertEquals($theme->setPath($newPath)->getPath(), $this->theme->getPath());
	    });

	    $this->assertEquals($newPath1, $this->theme->setPath($newPath1)->getPath());
	    $this->assertEquals(vfsStream::url('theme'), config('theme.themePath'));
	    $this->assertNotEquals($newPath, config('theme.themePath'));
	    $this->assertNotEquals($newPath1, config('theme.themePath'));
	}

	/** @test */
	function can_render_the_theme()
	{
		$this->assertEquals($this->theme->render('index'), 'This is index page');
	}

	/** @test */
	function can_get_default_assets_path()
	{
	    $this->assertEquals($this->root->getChild($this->theme->get()."/assets")->url(), $this->theme->getAssetsPath());
	}

	/** @test */
	function can_set_default_assets_path()
	{
	    vfsStream::newDirectory('mero')->at($this->root->getChild($this->theme->get()));

	    $assetsPath = $this->root->getChild($this->theme->get()."/mero")->url();

	    $this->assertEquals($assetsPath, $this->theme->setAssetsPath('mero')->getAssetsPath());
	}

	/** @test */
	function can_get_asstes_from_default_path()
	{
	    $assetsContent = $this->root->getChild($this->theme->get()."/assets/css/main.css")->url();

	    // with directory seperator at begining
	    $this->assertEquals($assetsContent, $this->theme->assets('/css/main.css'));
	    // without directory seperator at begining
	    $this->assertEquals($assetsContent, $this->theme->assets('css/main.css'));
	}
}