<?php
namespace ElementsKit\Modules\Parallax;

defined( 'ABSPATH' ) || exit;

class Init{
    private $dir;
    private $url;

    public function __construct(){

        // get current directory path
        $this->dir = dirname(__FILE__) . '/';

        // get current module's url
		$this->url = \ElementsKit::plugin_url() . 'modules/parallax/';
		
		// enqueue scripts
		add_action('wp_head', [$this, 'inline_script']);
		add_action('elementor/frontend/before_register_scripts', [$this, 'enqueue_frontend_scripts']);

		// include all necessary files
		$this->include_files();

		// calling the section parallax class
		new \Elementor\ElementsKit_Section_Effect_Controls();
		new \Elementor\ElementsKit_Widget_Effect_Controls();

		// add attributes to elements
		add_action('elementor/frontend/before_render', [$this, 'add_attributes_to_elements']);
	}
	
	public function include_files(){
		include $this->dir . 'section-controls.php';
		include $this->dir . 'widget-controls.php';
	}

	public function inline_script() {
		echo '<script type="text/javascript">';
		echo 'var elementskit_module_parallax_url = "' . esc_url($this->url) . '";';
		echo '</script>';
	}

	public function enqueue_frontend_scripts() {
		$assets =[
			'styles' => [
				'elementskit-parallax' => [
					'src' => $this->url . 'assets/css/style.css',
					'version' => \ElementsKit::version(),
					'dependencies' => [],
				],
			],
			'scripts' => [
				'jarallax' => [
					'src' => $this->url . 'assets/js/jarallax.js',
					'version' => \ElementsKit::version(),
					'dependencies' => [],
				],
				'elementskit-parallax-frontend' => [
					'src' => $this->url . 'assets/js/parallax-frontend.js',
					'version' => \ElementsKit::version(),
					'dependencies' => ['animejs'],
				],
				'elementskit-parallax-admin' => [
					'src' => $this->url . 'assets/js/parallax-admin.js',
					'version' => \ElementsKit::version(),
					'dependencies' => [],
				],
			],
		];

		if ( $assets ) {
			\Elementor\Plugin::$instance->assets_loader->add_assets( $assets );
		}
	}

	public function add_attributes_to_elements($element) {
		$settings = $element->get_settings();
	
		extract($settings);
	
		$data_settings = [];
	
		if (!empty($ekit_section_parallax_multi) && !empty($ekit_section_parallax_multi_items)) {
			$data_settings['ekit_section_parallax_multi'] = $ekit_section_parallax_multi;
			$data_settings['ekit_section_parallax_multi_items'] = $ekit_section_parallax_multi_items;
		}
	
		if (!empty($ekit_section_parallax_bg) && 'yes' === $ekit_section_parallax_bg) {
			$data_settings['ekit_section_parallax_bg'] = $ekit_section_parallax_bg;
			$data_settings['ekit_section_parallax_bg_speed'] = $ekit_section_parallax_bg_speed;
			$data_settings['elementor_lazy_load'] = get_option( 'elementor_lazy_load_background_images', '1' );
		}
	
		if (!empty($data_settings)) {
			$element->add_render_attribute(
				'_wrapper',
				[
					'data-ekitparallax' => wp_json_encode($data_settings)
				]
			);
		}
	}
}