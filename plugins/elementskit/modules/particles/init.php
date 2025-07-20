<?php
namespace ElementsKit\Modules\Particles;

defined( 'ABSPATH' ) || exit;

class Init {

	private $dir;
	private $url;

	public function __construct() {

		// get current directory path
		$this->dir = dirname(__FILE__) . '/';

		// get current module's url
		$this->url = \ElementsKit::plugin_url() . 'modules/particles/';

		// enqueue script , styles
		add_action('elementor/frontend/before_register_scripts', [$this, 'before_register_scripts']);

		// include all necessary files
		$this->include_files();

		// calling the particles controls
		new \Elementor\ElementsKit_Particles();
	}

	public function before_register_scripts() {
		$assets = [
			'scripts' => [
				'particles' => [
					'src' => $this->url . 'assets/js/particles.min.js',
					'version' => \ElementsKit::version(),
					'dependencies' => [],
				],
				'ekit-particles' => [
					'src' => $this->url . 'assets/js/ekit-particles.js',
					'version' => \ElementsKit::version(),
					'dependencies' => ['particles'],
				],
			],
			'styles' => [
				'ekit-particles' => [
					'src' => $this->url . 'assets/css/particles.css',
					'version' => \ElementsKit::version(),
					'dependencies' => [],
				],
			],
		];
		if ($assets) {
			\Elementor\Plugin::$instance->assets_loader->add_assets($assets);
		}
	}


	public function include_files() {
		include $this->dir . 'particles.php';
	}
}
