<?php
namespace ElementsKit\Modules\Wrapper_Link;

defined( 'ABSPATH' ) || exit;

class Init {
	private $dir;
	private $url;

	public function __construct() {

		// get current directory path
		$this->dir = dirname(__FILE__) . '/';

		// get current module's url
		$this->url = \ElementsKit::plugin_url() . 'modules/wrapper-link/';

		// enqueue scripts
		add_action('elementor/frontend/before_register_scripts', [$this, 'enqueue_frontend_scripts']);

		// include all necessary files
		$this->include_files();

		// calling the wrapper controls
		new \Elementor\ElementsKit_Wrapper_Link();
		
	}

	public function include_files() {
		include $this->dir . 'wrapper-link.php';
	}

	public function enqueue_frontend_scripts(){
		$assets = [
			'scripts' => [
				'elementskit-wrapper' => [
					'src' => $this->url . 'assets/js/wrapper.js',
					'version' => \ElementsKit::version(),
					'dependencies' => ['jquery'],
				],
			],
		];
		if ($assets) {
			\Elementor\Plugin::$instance->assets_loader->add_assets($assets);
		}

	}
}