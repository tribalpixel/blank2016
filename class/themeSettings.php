<?php
/**
 * register_setting( $option_group, $option_name, $sanitize_callback );
 * add_settings_section( $id, $title, $callback, $page ); 
 * add_settings_field( $id, $title, $callback, $page, $section, $args );
 */
class themeSettings {

    private $pageName;
    private $pageSlug;
    private $themeName;
    private $settings;
            
    function __construct($pageName, $pageSlug, $settings) {
        
        $this->pageName = $pageName;
        $this->pageSlug = $pageSlug;
        $this->themeName = wp_get_theme()->template;
        $this->settings = $settings;
        $this->db_options = $pageSlug .'_settings';
        
        add_action( 'admin_menu', array(&$this, 'add_settings_page' ));
        add_action( 'admin_init', array(&$this, 'init_settings' ));
    }

    function add_settings_page() {
        //https://developer.wordpress.org/reference/functions/add_submenu_page/
        add_submenu_page( 'themes.php', __($this->pageName), __($this->pageName), 'manage_options', $this->pageSlug, array(&$this, 'render_options_page' ) );
    }
    
    function init_settings(){
        
        $page = $this->pageSlug;
        register_setting( $page, $this->db_options );
        
        foreach ($this->settings as $key=>$setting) {    
            
            $section = $key.'_section';
            add_settings_section( $section, ucfirst($key), function(){}, $page );
            
            foreach ($setting as $args) {
                $id = $args['id'];
                $title = '<label for="'.$id.'">'.$args['title'].'</label>'; 
                switch($args['type']) {

                    default:
                       add_settings_field( $id, $title, array(&$this, 'render_input_options'), $page, $section, $args ); 
                    break;

                } // end switch
   
            } //end foreach

        } //end foreach
        
        
    }

    function render_input_options($args) {
        $option = get_option($this->db_options);
        var_dump($option);
        echo '<input type="text" name="'.$args['id'].'" id="'.$args['id'].'" value="" />';
    }
    
    /*
    function render_radio_options($setting) {
        $options = get_option($this->options_group);
        var_dump($options);
        var_dump($options[$setting[0]]);
        $name = "$this->options_group[$setting[0]]";
        foreach ($setting[1] as $k=>$v) {
            echo '<input type="radio" name="'.$name.'" '.checked( $options[$setting[0]]).' value="'.$k.'">'.$v;
            //echo '<input type="radio" name="A_settings[A_radio_field_0]" '.checked( $options['A_radio_field_0'], 1 ).' value="'.$k.'">';
        }
   
    }
 
    
    function render_color_picker() {
        add_control( new WP_Customize_Color_Control( $wp_customize, 'link_color', array(
                'label' => 'Link Color',
                'section' => 'bwpy_theme_colors',
                'settings' => 'link_color',
        ) ) );       
    }
    */
    function render_options_page() {
        ?>
	<form action='options.php' method='post'>
		
		<h2>Options page</h2>
		
		<?php
                var_dump($this->settings);
                settings_fields( $this->pageSlug );
		do_settings_sections( $this->pageSlug );
		submit_button();
		?>
		
	</form>
	<?php
    }
    
}

