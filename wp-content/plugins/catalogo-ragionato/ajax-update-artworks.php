<?php
add_action( 'admin_enqueue_scripts', 'enqueue_artworks_js' );
function enqueue_artworks_js() {
	wp_enqueue_script( 'ajax-script', plugins_url( '/ajax-update-artworks.js', __FILE__ ), array('jquery') );
}
function update_artworks_submenu_page_callback() {
  echo '<div class="wrap">';
  echo '<h1>update artworks (very beta!)</h1>';


	echo '<div class="card">';
	if ($_SERVER['HTTP_HOST'] != 'www.fondazionefaustomelotti.org') {
		echo '<h4>Hey, un attimo di attenzione!<br>Stai per aggiornare i contenuti del catalogo da un file CSV!</h4>';
		if(function_exists( 'wp_enqueue_media' )) {
	    wp_enqueue_media();
		} else {
	    wp_enqueue_style('thickbox');
	    wp_enqueue_script('media-upload');
	    wp_enqueue_script('thickbox');
		}
		echo '<strong>Carica il file CSV:</strong><br />';

		echo '<input class="custom_media_url regular-text" type="text" name="attachment_url" value="">';
		echo '&nbsp;&nbsp;<a href="#" class="custom_media_upload button">Scegli file</a>';

		echo '<div class="custom_media_file" style="display:none;"></div>';
		//echo '<pre>'.var_dump( wp_get_mime_types() ).'</pre>';
		echo '<br /><br /><button id="startbutton" class="button button-primary" disabled="disabled">Sei sicuro?</button>';
		echo '</div><br>';
		echo '<div id="insert-result"></div><br>';
	} else {
		echo '<h4>Volevi aggiornare il db direttamente in produzione?</h4>';
		echo '<p>sicuramente ti sarai sbagliato!</p>';
	}

	echo '<table id="run_update_content" class="wp-list-table widefat striped tags" >';
	echo '<tr id="loading" style="display:none; text-align: center;"><td><p>Aggiornamento contenuti in corso...</p></td></tr>';
	echo '</table>';

  echo '</div>';

}


add_action('wp_ajax_run_update', 'run_update_callback');
function run_update_callback() {
	// Set path to CSV file
	$csvFile = $_POST['file'];
	$csv = readCSV($csvFile);

	echo '<thead>';
	echo '<tr>';

	echo '<th scope="col" id="ID" class="manage-column column-name column-primary"><span>ID</span></th>';
	echo '<th scope="col" id="code" class="manage-column column-name column-primary"><span>code</span></th>';
	echo '<th scope="col" id="title" class="manage-column column-name column-primary"><span>title</span></th>';
	echo '<th scope="col" id="tipologia_opera" class="manage-column column-name column-primary"><span>tipologia_opera</span></th>';
	echo '<th scope="col" id="tipo_opera" class="manage-column column-name column-primary"><span>tipo_opera</span></th>';
	echo '<th scope="col" id="subtipo_opera" class="manage-column column-name column-primary"><span>subtipo_opera</span></th>';
	echo '<th scope="col" id="subtipo_opera" class="manage-column column-name column-primary"><span>RESULT</span></th>';

	echo '</tr>';
	echo '</thead>';
	echo '<tbody>';

	$i = 0;
	foreach ($csv as $csvitem) {
		if ($i > 0) {
			$csvitem['post_type'] = $csvitem[0];
			$csvitem['ID'] = $csvitem[1];
			$csvitem['codice_electa'] = $csvitem[2];
			$csvitem['post_title'] = $csvitem[3];
			$csvitem['post_content'] = '';
			$csvitem['anno_opera'] = $csvitem[4];
			$csvitem['tax_materiali'] = $csvitem[5];
			$csvitem['misure_opera'] = $csvitem[6];
			$csvitem['tax_tipologia_opera'] = $csvitem[7];
			$csvitem['tax_tipo_opera'] = $csvitem[8];
			$csvitem['tax_subtipo_opera'] = $csvitem[9];
			$csvitem['esemplari_opera'] = $csvitem[10];
			$csvitem['file_immagine'] = $csvitem[11];
			$csvitem['id_import'] = $csvitem[1];
			$csvitem['codice_opera'] = $csvitem[13];
			$csvitem['post_status'] = $csvitem[14];


			unset($csvitem[0]);
			unset($csvitem[1]);
			unset($csvitem[2]);
			unset($csvitem[3]);
			unset($csvitem[4]);
			unset($csvitem[5]);
			unset($csvitem[6]);
			unset($csvitem[7]);
			unset($csvitem[8]);
			unset($csvitem[9]);
			unset($csvitem[10]);
			unset($csvitem[11]);
			unset($csvitem[12]);
			unset($csvitem[13]);
			unset($csvitem[14]);

			// Update the post into the database (!)

			$post_id = wp_insert_post( $csvitem, true );


			$PRE_post_tax_tipologia_opera = wp_get_post_terms( $csvitem["ID"], 'tipologia_opera' );
			if ($PRE_post_tax_tipo_opera != $csvitem['tax_tipologia_opera']) {
				$post_tax_tipologia_opera = wp_set_post_terms( $csvitem["ID"], $csvitem['tax_tipologia_opera'], 'tipologia_opera',true );
			}


			$PRE_post_tax_tipo_opera = wp_get_post_terms( $csvitem["ID"], 'tipo_opera' );
			if ($PRE_post_tax_tipo_opera != $csvitem['tax_tipo_opera']) {
				$post_tax_tipo_opera = wp_set_post_terms( $csvitem["ID"], $csvitem['tax_tipo_opera'], 'tipo_opera',true );
			}

			$PRE_post_tax_subtipo_opera = wp_get_post_terms( $csvitem["ID"], 'subtipo_opera' );
			if ($PRE_post_tax_subtipo_opera != $csvitem['tax_subtipo_opera']) {
				$post_tax_subtipo_opera = wp_set_post_terms( $csvitem["ID"], $csvitem['tax_subtipo_opera'], 'subtipo_opera',true );
			}

			echo '<tr>';
			echo '<td><b>'.$csvitem['ID'].'</b></td>';
			echo '<td>'.$csvitem['codice_electa'].'</td>';
			echo '<td>'.$csvitem['post_title'].'</td>';


			if (is_wp_error($post_tax_tipologia_opera)) {
					$errors = $post_tax_tipologia_opera->get_error_messages();
					foreach ($errors as $error) {
						echo '<td>'.$error.'</td>';
					}
			} else {
					echo '<td>'.$csvitem['tax_tipologia_opera'].'</td>';
			}

			if (is_wp_error($post_tax_tipo_opera)) {
					$errors = $post_tax_tipo_opera->get_error_messages();
					foreach ($errors as $error) {
						echo '<td>'.$error.'</td>';
					}
			} else {
					echo '<td>'.$csvitem['tax_tipo_opera'].'</td>';
			}

			if (is_wp_error($post_tax_subtipo_opera)) {
					$errors = $post_tax_subtipo_opera->get_error_messages();
					foreach ($errors as $error) {
						echo '<td>'.$error.'</td>';
					}
			} else {
					$PRE_post_tax_subtipo_opera = wp_get_post_terms( $csvitem["ID"], 'subtipo_opera' );

					if (!is_wp_error($PRE_post_tax_subtipo_opera) && !empty($PRE_post_tax_subtipo_opera)) {
						echo '<td>'.$PRE_post_tax_subtipo_opera[0]->name.' -> '.$csvitem['tax_subtipo_opera'].'</td>';
					} else {
						echo '<td>'.$csvitem['tax_subtipo_opera'].'</td>';
					}
			}




			if (is_wp_error($post_id)) {
					$errors = $post_id->get_error_codes();
					foreach ($errors as $error) {
							echo '<td class="result result-error"><b style="color:#f00">'.$error.'</b> <small><a href="edit.php?s=%22'.$csvitem['codice_electa'].'%22&post_status=all&post_type=catalogo" target="_blank"  class="dashicons dashicons-search" alt="locate artwork by CODE_ELECTA">&nbsp</a></td>';
					}
			} else {
					echo '<td class="result result-ok"><b>aggiornato!</b> <small><a href="post.php?post='.$csvitem['ID'].'&action=edit" target="_blank" class="dashicons dashicons-visibility" alt="wiew artwork entry">&nbsp</a></small></td>';
			}


			echo '</tr>';

		}
		$i++;
	}

	echo '</tbody>';
}


function readCSV($csvFile){
		$file_handle = fopen($csvFile, 'r');
		while (!feof($file_handle) ) {
				$line_of_text[] = fgetcsv($file_handle, 1024);
		}
		fclose($file_handle);
		return $line_of_text;
}

function my_theme_custom_upload_mimes( $existing_mimes ) {
	// add webm to the list of mime types
	$existing_mimes['csv'] = 'text/csv';
	// return the array back to the function with our added mime type
	return $existing_mimes;
}
add_filter( 'mime_types', 'my_theme_custom_upload_mimes' );
?>
