<?php
namespace ElementsKit\Modules\Mouse_Cursor;

defined( 'ABSPATH' ) || exit;

class Init {
	private $dir;
	private $url;

	public function __construct() {

		$this->dir = dirname(__FILE__) . '/';
		// get current directory path
		$this->url = \ElementsKit::plugin_url() . 'modules/mouse-cursor/';
		add_action('elementor/frontend/before_register_scripts', [$this, 'enqueue_frontend_scripts']);
		
		// include all necessary files
		$this->include_files();

		// calling the wrapper controls
		new \Elementor\ElementsKit_Mouse_Cursor();

	}

	public function include_files() {
		include $this->dir . 'mouse-cursor.php';
	}

	public function enqueue_frontend_scripts(){
		$assets = [
			'styles' => [
				'cotton' => [
					'src' => $this->url . 'assets/css/style.css',
					'version' => \ElementsKit::version(),
					'dependencies' => [],
				],
			],
			'scripts' => [
				'cotton' => [
					'src' => $this->url . 'assets/js/cotton.min.js',
					'version' => \ElementsKit::version(),
					'dependencies' => ['jquery'],
				],
				'mouse-cursor' => [
					'src' => $this->url . 'assets/js/mouse-cursor-scripts.js',
					'version' => \ElementsKit::version(),
					'dependencies' => ['jquery', 'elementor-frontend'],
				],
			],
		];
		if ($assets) {
			\Elementor\Plugin::$instance->assets_loader->add_assets($assets);
		}

	}
}