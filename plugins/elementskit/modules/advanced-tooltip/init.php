<?php
namespace ElementsKit\Modules\Advanced_Tooltip;

defined( 'ABSPATH' ) || exit;

class Init {
	private $dir;
	private $url;
	
	public function __construct() {
		global $post;

		// get current directory path
		$this->dir = dirname(__FILE__) . '/';

		// get current module's url
		$this->url = \ElementsKit::plugin_url() . 'modules/advanced-tooltip/';

		// Register Editor Scripts
		add_action('elementor/frontend/before_register_scripts', [$this, 'enqueue_frontend_scripts']);

		// include all necessary files
		$this->include_files();

		// calling the advanced tooltip
		new \Elementor\ElementsKit_Extend_Advanced_Tooltip();
	}

	public function include_files() {
		include $this->dir . 'extend-controls.php';
	}

	/**
	 * Always load on Editor
	 * !need optimization: similar method is also written on modules/advanced-tooltip/extend-controls.php file.
	 */
	public function enqueue_frontend_scripts() {
		$assets =[ 
			'styles' => [
				'ekit-adv-tooltip' => [
					'src' => $this->url . 'assets/css/tippy-custom.css',
					'version' => \ElementsKit::version(),
					'dependencies' => [],
				],
			],
			'scripts' => [
				'popper-defer' => [
					'src' => $this->url . 'assets/js/popper.min.js',
					'version' => \ElementsKit::version(),
					'dependencies' => ['jquery'],
				],
				'tippyjs-defer' => [
					'src' => $this->url . 'assets/js/tippy.min.js',
					'version' => \ElementsKit::version(),
					'dependencies' => ['jquery'],
				],
				'ekit-adv-tooltip-defer' => [
					'src' => $this->url . 'assets/js/init.js',
					'version' => \ElementsKit::version(),
					'dependencies' => ['jquery'],
				],
			],

		];
		
		if ($assets ){
			\Elementor\Plugin::$instance->assets_loader->add_assets($assets);
		}
	}
}
