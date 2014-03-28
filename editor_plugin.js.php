<?php 
	
	if ( ! is_user_logged_in() )
		die('You must be logged in to access this script.');
	
	if(!isset($shortcodesXYZEH))
		$shortcodesXYZEH = new XYZ_Insert_Html_TinyMCESelector();
	
	global $wpdb;

	$xyz_snippets = array(
                'title'   =>'Insert HTML Snippet',
				'url'	=> plugins_url('insert-html-snippet/images/logo.png'),
                'xyz_ihs_snippets' => $wpdb->get_results($wpdb->prepare( "SELECT id,title FROM ".$wpdb->prefix."xyz_ihs_short_code WHERE status=%d  ORDER BY id DESC",1,ARRAY_A ))
            );

if(count($xyz_snippets[ 'xyz_ihs_snippets'])==0)
die;

?>

var tinymce_<?php echo $shortcodesXYZEH->buttonName; ?> =<?php echo json_encode($xyz_snippets) ?>;


(function() {
	//******* Load plugin specific language pack

	tinymce.create('tinymce.plugins.<?php echo $shortcodesXYZEH->buttonName; ?>', {
		/**
		 * Initializes the plugin, this will be executed after the plugin has been created.
		 * This call is done before the editor instance has finished it's initialization so use the onInit event
		 * of the editor instance to intercept that event.
		 *
		 * @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
		 * @param {string} url Absolute URL to where the plugin is located.
		 */
		init : function(ed, url) {

         tinymce_<?php echo $shortcodesXYZEH->buttonName; ?>.insert = function(){
                if(this.v != ''){
                tinymce.execCommand('mceInsertContent', false, '[xyz-ihs snippet="'+tinymce_<?php echo $shortcodesXYZEH->buttonName; ?>.xyz_ihs_snippets[this.v]['title']+'"]');
				}
            };
			
		},

		/**
		 * Creates control instances based in the incomming name. This method is normally not
		 * needed since the addButton method of the tinymce.Editor class is a more easy way of adding buttons
		 * but you sometimes need to create more complex controls like listboxes, split buttons etc then this
		 * method can be used to create those.
		 *
		 * @param {String} n Name of the control to create.
		 * @param {tinymce.ControlManager} cm Control manager to use inorder to create new control.
		 * @return {tinymce.ui.Control} New control instance or null if no control was created.
		 */
		createControl : function(n, cm) {
			if(n=='<?php echo $shortcodesXYZEH->buttonName; ?>'){
                var c = cm.createSplitButton('<?php echo $shortcodesXYZEH->buttonName; ?>', {
                     title : tinymce_<?php echo $shortcodesXYZEH->buttonName; ?>.title,
					 image :  tinymce_<?php echo $shortcodesXYZEH->buttonName; ?>.url,
                     onclick : tinymce_<?php echo $shortcodesXYZEH->buttonName; ?>.insert
                });

                // Add some values to the list box
              

				c.onRenderMenu.add(function(c, m){
		                 for (var id in tinymce_<?php echo $shortcodesXYZEH->buttonName; ?>.xyz_ihs_snippets){
                            m.add({
                                v : id,
                                title : tinymce_<?php echo $shortcodesXYZEH->buttonName; ?>.xyz_ihs_snippets[id]['title'],
                                onclick : tinymce_<?php echo $shortcodesXYZEH->buttonName; ?>.insert
                            });
                        }
                    });


                // Return the new listbox instance
                return c;
             }
             
             return null;
		},

		
	});

	// Register plugin
	tinymce.PluginManager.add('<?php echo $shortcodesXYZEH->buttonName; ?>', tinymce.plugins.<?php echo $shortcodesXYZEH->buttonName; ?>);
})();

