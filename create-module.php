<?php

if(file_exists(plugin_dir_path( __FILE__ ) . 'tgm/include-tgm.php')){
  require_once(plugin_dir_path( __FILE__ ) . 'tgm/include-tgm.php');
}


/*======================= CREATE A POST TYPE ==============================*/

function divimaker_register_post_type() {
  $labels = array(
    'name' 				=> _x( 'DIVI Maker', 'post type general name' ),
    'singular_name'		=> _x( 'Module', 'post type singular name' ),
    'add_new' 			=> __( 'Add New' ),
    'add_new_item' 		=> __( 'Add New' ),
    'edit_item' 		=> __( 'Edit' ),
    'new_item' 			=> __( 'New' ),
    'view_item' 		=> __( 'View' ),
    'search_items' 		=> __( 'Search' ),
    'not_found' 		=> __( 'Not found' ),
    'not_found_in_trash'=> __( 'Not found in trash' ),
    'parent_item_colon' => __( 'Module' ),
    'menu_name'			=> __( 'DIVI Maker' ),

  );

  $taxonomies = array('');

  $supports = array('title','editor');

  $post_type_args = array(
    'labels' 			=> $labels,
    'singular_label' 	=> __('Module'),
    'public' 			=> true,
    'show_ui' 			=> true,
    'publicly_queryable'=> false,
    'query_var'			=> true,
    'capability_type' 	=> 'post',
    'has_archive' 		=> false,
    'hierarchical' 		=> false,
    'rewrite' 			=> array('slug' => 'module', 'with_front' => false ),
    'supports' 			=> $supports,
    'menu_position' 	=> 33,
    'menu_icon' 		=> 'dashicons-layout',
    'taxonomies'		=> $taxonomies
   );
   register_post_type('divimaker',$post_type_args);
}
add_action('init', 'divimaker_register_post_type');

/*========================== VALUES ========================*/


/*======================= ADD METABOXES =========================*/
add_action( 'cmb2_admin_init', 'divimaker_metaboxes' );
/**
 * Define the metabox and field configurations.
 */
function divimaker_metaboxes() {

	// Start with an underscore to hide fields from custom fields list
	$dmprefix = 'divimaker_';

	/**
	 * Initiate the metabox
	 */
   $cmb1 = new_cmb2_box( array(
 		'id'            => $dmprefix.'main',
 		'title'         => __( 'Module Settings', 'cmb2' ),
 		'object_types'  => array( 'divimaker', ), // Post type
 		'context'       => 'side',
 		'priority'      => 'low',
 		'show_names'    => true, // Show field names on the left
 		// 'cmb_styles' => false, // false to disable the CMB stylesheet
 		// 'closed'     => true, // Keep the metabox closed by default
 	) );
  $cmb1->add_field( array(
		'name' => 'Module VB Support',
		'desc' => '',
		'id'   => $dmprefix.'vb',
		'type' => 'select',
    'options'          => array(
  		'off' => __( 'Not supported', 'divimaker' ),
  		'partial'   => __( 'Partially supported', 'divimaker' ),
  	),
	) );

	$cmb2 = new_cmb2_box( array(
		'id'            => $dmprefix.'fields',
		'title'         => __( 'Module Fields', 'cmb2' ),
		'object_types'  => array( 'divimaker', ), // Post type
		'context'       => 'side',
		'priority'      => 'low',
		'show_names'    => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // Keep the metabox closed by default
	) );

  $field_group_id = $cmb2->add_field( array(
    'id'          => $dmprefix.'field_group',
    'type'        => 'group',
    'repeatable'  => true,
    'options'     => array(
      'group_title'   => 'Field',
      'add_button'    => 'Add Another Field',
      'remove_button' => 'Remove Field',
      'closed'        => true,  // Repeater fields closed by default - neat & compact.
      'sortable'      => true,  // Allow changing the order of repeated groups.
    ),
  ) );
  $cmb2->add_group_field( $field_group_id, array(
		'name' => 'Field ID',
		'desc' => 'this is the field identifier. must be unique and no contains spaces.',
		'id'   => $dmprefix.'id',
		'type' => 'text',
	) );
	$cmb2->add_group_field( $field_group_id, array(
		'name' => 'Field Type',
		'desc' => 'Choose field type',
		'id'   => $dmprefix.'type',
		'type' => 'select',
    'options'          => array(
  		'text' => __( 'Text', 'divimaker' ),
  		'color'   => __( 'Color Picker', 'divimaker' ),
      'upload'   => __( 'Upload', 'divimaker' ),
      'textarea'   => __( 'Textarea', 'divimaker' ),
      'codemirror'   => __( 'Code', 'divimaker' ),
      'et_font_icon_select'   => __( 'Iconpicker', 'divimaker' ),
      'tiny_mce' => __( 'Editor (Field ID must be "content")', 'divimaker' ),

  	),
	) );
	$cmb2->add_group_field( $field_group_id, array(
		'name' => 'Field Label',
		'desc' => 'The Label above the field',
		'id'   => $dmprefix.'label',
		'type' => 'text',
	) );
	$cmb2->add_group_field( $field_group_id, array(
		'name' => 'Field Description',
		'desc' => 'Explanation of how affects the field to the module',
		'id'   => $dmprefix.'description',
		'type' => 'text',
	) );
	$cmb2->add_group_field( $field_group_id, array(
		'name' => 'toggle',
		'default' => 'main_content',
		'desc' => 'Where it will appear the field inside the modal box',
		'id'   => $dmprefix.'toggle',
		'type' => 'text',
	) );



	// Add other metaboxes as needed
  $cmb3 = new_cmb2_box( array(
		'id'            => $dmprefix.'code',
		'title'         => __( 'Module Editors', 'cmb2' ),
		'object_types'  => array( 'divimaker', ), // Post type
		'context'       => 'normal',
		'priority'      => 'low',
		'show_names'    => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		// 'closed'     => true, // Keep the metabox closed by default
	) );

  $cmb3->add_field( array(
  	'name' => 'PHP',
  	'desc' => 'This field also input the module render content, right after the main editor content. Can be used altogether with the default editor or instead it.',
  	'default' => '',
  	'id' => $dmprefix.'cod',
  	'type' => 'textarea_code'
  ) );
  $cmb3->add_field( array(
  	'name' => 'CSS',
  	'desc' => 'Here you can add all Module CSS',
  	'default' => '',
  	'id' => $dmprefix.'css',
  	'type' => 'textarea_code'
  ) );
  $cmb3->add_field( array(
  	'name' => 'Javascript',
  	'desc' => 'Here you can insert all Module javascript content',
  	'default' => '',
  	'id' => $dmprefix.'js',
  	'type' => 'textarea_code'
  ) );
	$cmb3->add_field( array(
		'name' => 'Default Editor(Module Output)',
		'default'	=> 'off',
		'desc' => 'Visual may change the formatting used under HTML Tab',
		'id'   => $dmprefix.'default_editor',
		'type' => 'select',
    'options'          => array(
  		'off' => __( 'Only HTML', 'divimaker' ),
  		'on'   => __( 'HTML & Visual', 'divimaker' ),
  	),
	) );


  // new metabox
  $cmb4 = new_cmb2_box( array(
    'id'            => $dmprefix.'dependencies',
    'title'         => __( 'Module Dependencies', 'cmb2' ),
    'object_types'  => array( 'divimaker', ), // Post type
    'context'       => 'side',
    'priority'      => 'low',
    'show_names'    => true, // Show field names on the left
    // 'cmb_styles' => false, // false to disable the CMB stylesheet
    // 'closed'     => true, // Keep the metabox closed by default
  ) );

  $dependency_group_id = $cmb4->add_field( array(
    'id'          => $dmprefix.'dependencies_group',
    'type'        => 'group',
    'repeatable'  => true,
    'options'     => array(
      'group_title'   => 'Dependency',
      'add_button'    => 'Add Another Dependency',
      'remove_button' => 'Remove Dependency',
      'closed'        => true,  // Repeater fields closed by default - neat & compact.
      'sortable'      => true,  // Allow changing the order of repeated groups.
    ),
  ) );
  $cmb4->add_group_field( $dependency_group_id, array(
    'name' => 'Dependency Type',
    'desc' => 'Choose Dependency type',
    'id'   => $dmprefix.'dependency_type',
    'type' => 'select',
    'options'          => array(
      'css' => __( 'CSS', 'divimaker' ),
      'js'   => __( 'Javascript', 'divimaker' ),
    ),
  ) );
  $cmb4->add_group_field( $dependency_group_id, array(
    'name' => 'Dependency ID',
    'desc' => 'this is the field identifier. must be unique and no contains spaces.',
    'id'   => $dmprefix.'dependency_id',
    'type' => 'text',
  ) );
  $cmb4->add_group_field( $dependency_group_id, array(
    'name' => 'Dependency URL',
    'desc' => 'Insert the dependency link here',
    'id'   => $dmprefix.'dependency_url',
    'type' => 'text',
  ) );

	//another Box
	$cmb5 = new_cmb2_box( array(
		'id'            => $dmprefix.'help',
		'title'         => __( 'Help Tips', 'cmb2' ),
		'object_types'  => array( 'divimaker', ), // Post type
		'context'       => 'side',
		'priority'      => 'high',
		'show_names'    => true, // Show field names on the left
		// 'cmb_styles' => false, // false to disable the CMB stylesheet
		 'closed'     => true, // Keep the metabox closed by default
	) );
	$cmb5->add_field( array(
		'name' => 'Retrieve Values',
		'desc' => 'To retrieve values from fields added, you must insert the value id between divimaker tags (dmp=%value%=dmp) like the example below </br></br> <strong>'.esc_html('<h1>').' dmp=%idfield%=dmp'.esc_html('</h1>').'</strong>',
		'type' => 'title',
		'id'   => $dmprefix.'retrieve'
	) );
	$cmb5->add_field( array(
		'name' => 'Insert PHP',
		'desc' => 'To insert PHP Inside the editor, you must use this opening and closing tags [php*][*php] See the example below: </br></br> <strong>[php*]echo "Hello World";[*php]</strong>
		</br><span style="font-size: 20px; color: red;">Be Careful!!! An incorrect use may cause conflicts at your site. </span>
		',
		'type' => 'title',
		'id'   => $dmprefix.'use_php'
	) );



}

function divimaker_class($settings){
  $output = '';

  $options = '$fields  = array(';

  $moduleid = 'divimaker_module_'.rand(0, 10000);
  if(isset($settings['id']) && !empty($settings['id'])){$moduleid = $settings['id'];}
  $modulename = 'Module without name';
  if(isset($settings['name']) && !empty($settings['name'])){$modulename = $settings['name'];}
  $modulecontent = '';
  if(isset($settings['content']) && !empty($settings['content'])){$modulecontent = $settings['content'];}
  $modulevb = '"off"';
  if(isset($settings['settings']['vb']) && !empty($settings['settings']['vb'])){$modulevb = '"'.$settings['settings']['vb'].'"';}
	$customphp = '';
	if(isset($settings['php']) && !empty($settings['php'])){$customphp = '"'.$settings['php'].'"';}


  foreach($settings['fields'] as $field) {
    $iconadditional = '';

    if($field['type'] == 'et_font_icon_select'){
      $iconadditional =
      '"renderer"            => "et_pb_get_font_icon_list",
        "renderer_with_field" => true,';
    }

		if(!empty($field['id'])){
	    $options .= sprintf(
	      '
	        "%1$s" => array(
	          "label"  => esc_html__( "%2$s", "divimaker" ),
	          "type"  => esc_html__( "%3$s", "divimaker" ),
						"toggle_slug"  => esc_html__( "%5$s", "divimaker" ),
						"description"  => esc_html__( "%4$s", "divimaker" ),
	          %6$s
	        ),
	      ',
	      $field['id'],
	      $field['label'],
	      $field['type'],
				$field['description'],
				$field['toggle'],
	      $iconadditional
	    );
		}

  }
  $options .= '); return $fields;';

  $output .= sprintf('<?php
    function divimaker_initialize_%1$s(){
    if ( ! class_exists( \'ET_Builder_Module\' ) ) { return; }

    class DIVIMAKER_%1$s extends ET_Builder_Module {
      public function init() {
        $this->slug = \'%1$s\';
        $this->name = esc_html__( "%2$s", "%1$s" );
        $this->vb_support = %5$s;
      }

      public function get_fields() {
         %4$s
      }


      public function render( $attrs, $content = null, $render_slug) {
				ob_start();
			?>

					%3$s
					%6$s

			<?php
      return ob_get_clean();

      }

    }
    new DIVIMAKER_%1$s;
    }
    add_action(\'et_builder_ready\', \'divimaker_initialize_%1$s\');
    ?>',
    $moduleid,
    $modulename,
    $modulecontent,
    $options,
    $modulevb,
		trim($customphp, '"')

  );

  return $output;
}

function divimaker_modules_values(){
  global $post;
  $modules = array();
  $options = array();
  $dependencies = array();

  $args = array('post_type'=> 'divimaker');
  $the_query = get_posts($args);



  foreach($the_query as $module){
      $content = $module->post_content;

      //replace tag with divi modal values
      preg_match_all('/dmp=%([a-z_]+)%=dmp/', $module->post_content, $matches, PREG_PATTERN_ORDER);
      if(isset($matches[1])){
        foreach($matches[1] as $match){
          $content = preg_replace('/dmp=%'.$match.'%=dmp/', '<?php echo $this->props["'.$match.'"]; ?>', $content);
        }
      }

      //replace tag with php
      $content = str_replace('[php*]', '<?php ', $content);
			$content = str_replace('[*php]', ' ?>', $content);

      //replace tag per divi modal values



      if(isset($module->divimaker_field_group) && !empty($module->divimaker_field_group)){
        foreach($module->divimaker_field_group as $field){
					$fieldid = $fieldlabel = $fieldtype = $fielddescription = $fieldtoggle = '';
					if(isset($field['divimaker_id']) && !empty($field['divimaker_id'])){$fieldid = $field['divimaker_id'];}
					if(isset($field['divimaker_label']) && !empty($field['divimaker_label'])){$fieldlabel = $field['divimaker_label'];}
					if(isset($field['divimaker_type']) && !empty($field['divimaker_type'])){$fieldtype = $field['divimaker_type'];}
					if(isset($field['divimaker_description']) && !empty($field['divimaker_description'])){$fielddescription = $field['divimaker_description'];}
					if(isset($field['divimaker_toggle']) && !empty($field['divimaker_toggle'])){$fieldtoggle = $field['divimaker_toggle'];}
					$options[] = array(
            'id' => $fieldid,
            'label' => $fieldlabel,
            'type' => $fieldtype,
						'description' => $fielddescription,
						'toggle' => $fieldtoggle,
          );
        }
      }

      if(isset($module->divimaker_dependencies_group) && !empty($module->divimaker_dependencies_group)){
        foreach($module->divimaker_dependencies_group as $dependency){
          $id = $type = $url = '';
          if(isset($dependency['divimaker_dependency_type']) && !empty($dependency['divimaker_dependency_type'])){
            $type = $dependency['divimaker_dependency_type'];
          }
          if(isset($dependency['divimaker_dependency_id']) && !empty($dependency['divimaker_dependency_id'])){
            $id = $dependency['divimaker_dependency_id'];
          }
          if(isset($dependency['divimaker_dependency_url']) && !empty($dependency['divimaker_dependency_url'])){
            $url = $dependency['divimaker_dependency_url'];
          }
          $dependencies[] = array(
            'type' => $type,
            'id' => $id,
            'url' => $url,
          );
        }
      }

      $modules[] = array(
        'id' =>str_replace('-', '_', $module->post_name),
        'name' => $module->post_title,
        'fields' => $options,
        'dependencies' => $dependencies,
        'content' => $content,
        'settings' => array(
          'vb' => $module->divimaker_vb,
        ),
        'css' => $module->divimaker_css,
        'js' => $module->divimaker_js,
				'php' => $module->divimaker_cod,
      );


  }

  return $modules;
}

function divimaker_css($settings){
  $output = '';
  $output .= $settings['css'];

  return $output;
}

function divimaker_js($settings){
  $output = '';
  $output .= $settings['js'];

  return $output;
}

function divimaker_create_files(){
  $dmkval = 'dmk';
  $modules = divimaker_modules_values();
	$modulesnumb = 0;

  if(isset($modules) && !empty($modules)){

    foreach($modules as $module) {


      if(!empty($module) && $modulesnumb < strlen($dmkval)){

        if(!file_exists(plugin_dir_path( __FILE__ ) . 'includes/modules/'.$module['id'])){
          mkdir(plugin_dir_path( __FILE__ ) . 'includes/modules/'.$module['id']);
        }
        file_put_contents(plugin_dir_path( __FILE__ ) . 'includes/modules/'.$module['id'].'/'.$module['id'].'.php', divimaker_class($module));


        if(file_exists(plugin_dir_path( __FILE__ ) . 'includes/modules/'.$module['id'].'/'.$module['id'].'.php')){
          file_put_contents(plugin_dir_path( __FILE__ ) . 'includes/modules/'.$module['id'].'/'.$module['id'].'.css', divimaker_css($module));

          file_put_contents(plugin_dir_path( __FILE__ ) . 'includes/modules/'.$module['id'].'/'.$module['id'].'.js', divimaker_js($module));

        }
      }
			$modulesnumb++;
    } // End of foreach $modules

  }

}

add_action('init', 'divimaker_create_files');



function divimaker_register_scripts(){
  $modules = divimaker_modules_values();

  if(isset($modules) && !empty($modules)){
    foreach ($modules as $module){
      if(isset($module['dependencies']) && !empty($module['dependencies'])){
        foreach($module['dependencies'] as $dependency){
          if($dependency['type'] == 'css'){
            wp_enqueue_style($dependency['id'], $dependency['url']);
          }
          else {
            wp_enqueue_script($dependency['id'], $dependency['url']);
          }
        }
      }
    }
  }

  //load css files from all modules
  $module_css = glob(plugin_dir_path( __FILE__ ) . 'includes/modules/*/*.css' );

  foreach($module_css as $cssfile) {
    $pathcss = plugin_dir_url($cssfile);
    $namecss = str_replace('.css', '', basename($cssfile));
    wp_enqueue_style($namecss, $pathcss.basename($cssfile));
  }

  //load js files from all modules
  $module_js = glob(plugin_dir_path( __FILE__ ) . 'includes/modules/*/*.js' );

  foreach($module_js as $jsfile) {
    $pathjs = plugin_dir_url($jsfile);
    $namejs = str_replace('.css', '', basename($jsfile));
    wp_enqueue_script($namejs, $pathjs.basename($jsfile));
  }
}

add_action('wp_enqueue_scripts', 'divimaker_register_scripts', 9999);


function divimaker_disable_visual_editor( $default ) {
    global $post;
    if ( 'divimaker' == get_post_type( $post ) ){
			if($post->divimaker_default_editor == '' || $post->divimaker_default_editor == 'off'){
				return false;
			}
			else {
				return $default;
			}

		}
    else {
    	return $default;
		}
}
add_filter( 'user_can_richedit', 'divimaker_disable_visual_editor' );


function divimaker_delete_modules(){
	global $post;
  $dmkval = 'dmk';
	$modulesavailable = array();
	$args = array('post_type'=> 'divimaker');
  $the_query = get_posts($args);
	foreach($the_query as $module) {
		$moduleid = str_replace('-', '_', $module->post_name);
		$modulesavailable[] = $moduleid;
	}

	//check
	$directories = glob(plugin_dir_path( __FILE__ ) . 'includes/modules/*' , GLOB_ONLYDIR);
	foreach($directories as $directory){
		$pathdirectory = basename($directory);
		$folderkey = array_search($pathdirectory, $modulesavailable);

		//check with glob files created
	  $filescreated = glob($directory . '/*' );

	  foreach($filescreated as $file) {
				$pathfile = pathinfo($file);
				$key = array_search($pathfile['filename'], $modulesavailable);

				if(in_array($pathfile['filename'], $modulesavailable)){
					if($key >= strlen($dmkval)){
						unlink($file);
					}
				}
				else{
		    	unlink($file);
				}
	  }
		if(in_array($pathdirectory, $modulesavailable)){
			if($folderkey >= strlen($dmkval)){
				rmdir($directory);
			}
		}
		else {
			rmdir($directory);
		}


	}


}
add_action('init', 'divimaker_delete_modules', 9999);

?>
