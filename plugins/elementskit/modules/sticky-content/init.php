<?php
namespace ElementsKit\Modules\Sticky_Content;

defined( 'ABSPATH' ) || exit;

class Init {
    private $dir;
    private $url;

    public function __construct(){

        // get current directory path
        $this->dir = dirname(__FILE__) . '/';

        // get current module's url
		$this->url = \ElementsKit::plugin_url() . 'modules/sticky-content/';
		
		//enqueue scripts
		add_action('elementor/frontend/before_register_scripts', [$this, 'before_register_scripts']);

		// // include all necessary files
		$this->include_files();

		// // calling the sticky controls
		new \Elementor\ElementsKit_Extend_Sticky();

	}
	
	public function include_files(){
		include $this->dir . 'extend-controls.php';
	}

	public function before_register_scripts(){
		$assets =[
			'scripts' => [
				'elementskit-sticky-content' => [
					'src' => $this->url . 'assets/js/elementskit-sticky-content.js',
					'version' => \ElementsKit::version(),
					'dependencies' => [],
				],
			],
		];
		if($assets) {
			\Elementor\Plugin::$instance->assets_loader->add_assets($assets);
		}

	}
}
