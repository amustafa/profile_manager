<?php

/**
 * Events for Profile Manager
 */

/**
 * Registes all custom field types
 *
 * @return void
 */
function profile_manager_register_custom_field_types() {
	// registering profile field types
	$profile_options = [
		'show_on_register' => true,
		'mandatory' => true,
		'user_editable' => true,
		'output_as_tags' => true,
		'admin_only' => true,
		'count_for_completeness' => true,
	];

	$location_options = $profile_options;
	unset($location_options['output_as_tags']);

	$dropdown_options = $profile_options;
	$dropdown_options['blank_available'] = true;

	$radio_options = $profile_options;
	$radio_options['blank_available'] = true;

	//$file_options = array(
	//	'user_editable' => true,
	//	'admin_only' => true
	//);

	$pm_rating_options = $profile_options;
	unset($pm_rating_options['output_as_tags']);

	$social_options = $profile_options;
	$social_options['output_as_tags'] = false;

	profile_manager_add_custom_field_type('custom_profile_field_types', 'text', elgg_echo('profile:field:text'), $profile_options);
	profile_manager_add_custom_field_type('custom_profile_field_types', 'longtext', elgg_echo('profile:field:longtext'), $profile_options);
	profile_manager_add_custom_field_type('custom_profile_field_types', 'tags', elgg_echo('profile:field:tags'), $profile_options);
	profile_manager_add_custom_field_type('custom_profile_field_types', 'location', elgg_echo('profile:field:location'), $location_options);
	profile_manager_add_custom_field_type('custom_profile_field_types', 'url', elgg_echo('profile:field:url'), $profile_options);
	profile_manager_add_custom_field_type('custom_profile_field_types', 'email', elgg_echo('profile:field:email'), $profile_options);
	profile_manager_add_custom_field_type('custom_profile_field_types', 'date', elgg_echo('profile:field:date'), $profile_options);
	profile_manager_add_custom_field_type('custom_profile_field_types', 'dropdown', elgg_echo('profile_manager:admin:options:dropdown'), $dropdown_options);
	profile_manager_add_custom_field_type('custom_profile_field_types', 'radio', elgg_echo('profile_manager:admin:options:radio'), $radio_options);
	profile_manager_add_custom_field_type('custom_profile_field_types', 'multiselect', elgg_echo('profile_manager:admin:options:multiselect'), $profile_options);
	profile_manager_add_custom_field_type('custom_profile_field_types', 'pm_rating', elgg_echo('profile_manager:admin:options:pm_rating'), $pm_rating_options);
	profile_manager_add_custom_field_type('custom_profile_field_types', 'pm_twitter', elgg_echo('profile_manager:admin:options:pm_twitter'), $social_options);
	profile_manager_add_custom_field_type('custom_profile_field_types', 'pm_facebook', elgg_echo('profile_manager:admin:options:pm_facebook'), $social_options);
	profile_manager_add_custom_field_type('custom_profile_field_types', 'pm_linkedin', elgg_echo('profile_manager:admin:options:pm_linkedin'), $social_options);
	//profile_manager_add_custom_field_type('custom_profile_field_types', 'pm_file', elgg_echo('profile_manager:admin:options:file'), $file_options);

  //Extended Items
  $extra_profile_fields =  elgg_trigger_plugin_hook("profile_manager:custom_field_register", "profile", array());

  foreach ($extra_profile_fields as $extra_profile_field){
    $field_type = $extra_profile_field["type"];
    $display_name = $extra_profile_field["display_name"];
    $field_options = $extra_profile_field["options"];
    profile_manager_add_custom_field_type('custom_profile_field_types', $field_type, $display_name, $field_options);
  }

	// registering group field types
	$group_options = [
		'output_as_tags' => true,
		'admin_only' => true,
	];

	$dropdown_options = $group_options;
	$dropdown_options['blank_available'] = true;

	$radio_options = $group_options;
	$radio_options['blank_available'] = true;

	$location_options = $group_options;
	unset($location_options['output_as_tags']);

	profile_manager_add_custom_field_type('custom_group_field_types', 'text', elgg_echo('profile:field:text'), $group_options);
	profile_manager_add_custom_field_type('custom_group_field_types', 'longtext', elgg_echo('profile:field:longtext'), $group_options);
	profile_manager_add_custom_field_type('custom_group_field_types', 'tags', elgg_echo('profile:field:tags'), $group_options);
	profile_manager_add_custom_field_type('custom_group_field_types', 'url', elgg_echo('profile:field:url'), $group_options);
	profile_manager_add_custom_field_type('custom_group_field_types', 'email', elgg_echo('profile:field:email'), $group_options);
	profile_manager_add_custom_field_type('custom_group_field_types', 'date', elgg_echo('profile:field:date'), $group_options);
	profile_manager_add_custom_field_type('custom_group_field_types', 'location', elgg_echo('profile:field:location'), $location_options);
	profile_manager_add_custom_field_type('custom_group_field_types', 'dropdown', elgg_echo('profile_manager:admin:options:dropdown'), $dropdown_options);
	profile_manager_add_custom_field_type('custom_group_field_types', 'radio', elgg_echo('profile_manager:admin:options:radio'), $radio_options);
	profile_manager_add_custom_field_type('custom_group_field_types', 'multiselect', elgg_echo('profile_manager:admin:options:multiselect'), $group_options);

  //Extended Items
  $extra_group_fields =  elgg_trigger_plugin_hook("profile_manager:custom_field_register", "group", array());
  foreach ($extra_group_fields as $extra_group_field){
    $field_type = $extra_group_field["type"];
    $display_name = $extra_group_field["display_name"];
    $field_options = $extra_group_field["options"];
    profile_manager_add_custom_field_type('custom_profile_field_types', $field_type, $display_name, $field_options);
  }

}

/**
 * Function to add a custom field type to a register
 *
 * @param string $register_name      Name of the register where the fields are configured
 * @param string $field_type         Type op the field
 * @param string $field_display_name Display name of the field type
 * @param array  $options            Array of options
 *
 * @return void
 */
function profile_manager_add_custom_field_type($register_name, $field_type, $field_display_name, $options) {
	global $PROFILE_MANAGER_FIELD_TYPES;

	if (!isset($PROFILE_MANAGER_FIELD_TYPES)) {
		$PROFILE_MANAGER_FIELD_TYPES = array();
	}
	if (!isset($PROFILE_MANAGER_FIELD_TYPES[$register_name])) {
		$PROFILE_MANAGER_FIELD_TYPES[$register_name] = array();
	}

	$field_config = new stdClass();
	$field_config->name = $field_display_name;
	$field_config->type = $field_type;
	$field_config->options = $options;

	$PROFILE_MANAGER_FIELD_TYPES[$register_name][$field_type] = $field_config;
}

/**
 * Returns the profile manager field types
 *
 * @param string $register_name Name of the register to retrieve
 *
 * @return false|array
 */
function profile_manager_get_custom_field_types($register_name) {
	global $PROFILE_MANAGER_FIELD_TYPES;

  if (!isset($PROFILE_MANAGER_FIELD_TYPES)) {
    profile_manager_register_custom_field_types();
  }

	if (isset($PROFILE_MANAGER_FIELD_TYPES) && isset($PROFILE_MANAGER_FIELD_TYPES[$register_name])) {
		return $PROFILE_MANAGER_FIELD_TYPES[$register_name];
	}

	return false;
}

/**
 * Function to upload a profile icon on register of a user
 *
 * @param ElggUser $user The user to add the profile icons to
 *
 * @return boolean
 */
function profile_manager_add_profile_icon($user) {

	$icon_sizes = elgg_get_config('icon_sizes');

	// get the images and save their file handlers into an array
	// so we can do clean up if one fails.
	$files = [];

	foreach ($icon_sizes as $name => $size_info) {
		$resized = get_resized_image_from_uploaded_file('profile_icon', $size_info['w'], $size_info['h'], $size_info['square'], $size_info['upscale']);

		if ($resized) {
			$file = new ElggFile();
			$file->owner_guid = $user->guid;
			$file->setFilename("profile/{$user->guid}{$name}.jpg");
			$file->open('write');
			$file->write($resized);
			$file->close();
			$files[] = $file;
		} else {
			// cleanup on fail
			foreach ($files as $file) {
				$file->delete();
			}

			register_error(elgg_echo('avatar:resize:fail'));

			return false;
		}
	}

	$user->icontime = time();

	return true;
}

/**
 * Returns an array containing the categories and the fields ordered by category and field order
 *
 * @param ElggUser $user               User to check
 * @param boolean  $edit               Are you editing profile fields
 * @param boolean  $register           Are you on the register page
 * @param boolean  $profile_type_limit Should it be limited by the profile type
 * @param int      $profile_type_guid  The guid of the profile type to limit the results to
 *
 * @return unknown
 */
function profile_manager_get_categorized_fields($user = null, $edit = false, $register = false, $profile_type_limit = false, $profile_type_guid = false) {

	$result = [];
	$profile_type = null;

	if ($register == true) {
		// failsafe for edit
		$edit = true;
	}

	if (!empty($user) && ($user instanceof ElggUser)) {
		$profile_type_guid = $user->custom_profile_type;

		if (!empty($profile_type_guid)) {
			$profile_type = get_entity($profile_type_guid);

			// check if profile type is a REAL profile type
			if (!empty($profile_type) && ($profile_type instanceof \ColdTrick\ProfileManager\CustomProfileType)) {
				if ($profile_type->getSubtype() != CUSTOM_PROFILE_FIELDS_PROFILE_TYPE_SUBTYPE) {
					$profile_type = null;
				}
			}
		}
	} elseif (!empty($profile_type_guid)) {
		$profile_type = get_entity($profile_type_guid);
	}

	$result['categories'] = [];
	$result['categories'][0] = [];
	$result['fields'] = [];
	$ordered_cats = [];

	// get ordered categories
	$cats = elgg_get_entities([
		'type' => 'object',
		'subtype' => CUSTOM_PROFILE_FIELDS_CATEGORY_SUBTYPE,
		'limit' => false,
		'owner_guid' => elgg_get_config('site_guid'),
		'site_guid' => elgg_get_config('site_guid')
	]);
	if ($cats) {
		foreach ($cats as $cat) {
			$ordered_cats[$cat->order] = $cat;
		}
		ksort($ordered_cats);
	}

	// get filtered categories
	$filtered_ordered_cats = [];
	// default category at index 0
	$filtered_ordered_cats[0] = [];

	if (!empty($ordered_cats)) {
		foreach ($ordered_cats as $key => $cat) {

			if (!$edit || $profile_type_limit) {

				$rel_count = elgg_get_entities_from_relationship([
					'type' => 'object',
					'subtype' => CUSTOM_PROFILE_FIELDS_PROFILE_TYPE_SUBTYPE,
					'count' => true,
					'owner_guid' => $cat->getOwnerGUID(),
					'site_guid' => $cat->site_guid,
					'relationship' => CUSTOM_PROFILE_FIELDS_PROFILE_TYPE_CATEGORY_RELATIONSHIP,
					'relationship_guid' => $cat->getGUID(),
					'inverse_relationship' => true
				]);

				if ($rel_count == 0) {
					$filtered_ordered_cats[$cat->guid] = [];
					$result['categories'][$cat->guid] = $cat;
				} elseif (!empty($profile_type) && check_entity_relationship($profile_type->guid, CUSTOM_PROFILE_FIELDS_PROFILE_TYPE_CATEGORY_RELATIONSHIP, $cat->guid)) {
					$filtered_ordered_cats[$cat->guid] = [];
					$result['categories'][$cat->guid] = $cat;
				}
			} else {
				$filtered_ordered_cats[$cat->guid] = [];
				$result['categories'][$cat->guid] = $cat;
			}
		}
	}

	// adding fields to categories
	$fields = elgg_get_entities([
		'type' => 'object',
		'subtype' => CUSTOM_PROFILE_FIELDS_PROFILE_SUBTYPE,
		'limit' => false,
		'owner_guid' => elgg_get_config('site_guid'),
		'site_guid' => elgg_get_config('site_guid')
	]);

	if ($fields) {

		foreach ($fields as $field) {

			if (!($cat_guid = $field->category_guid)) {
				$cat_guid = 0; // 0 is default
			}

			$admin_only = $field->admin_only;
			if ($register || $admin_only != 'yes' || elgg_is_admin_logged_in()) {
				if ($edit) {
					if (!$register || $field->show_on_register == 'yes') {
						$filtered_ordered_cats[$cat_guid][$field->order] = $field;
					}
				} else {
					// only add if value exists
					$metadata_name = $field->metadata_name;
					$user_value = $user->$metadata_name;

					if (!empty($user_value) || $user_value === 0) {
						$filtered_ordered_cats[$cat_guid][$field->order] = $field;
					}
				}
			}
		}
	}

	// sorting fields and filtering empty categories
	foreach ($filtered_ordered_cats as $cat_guid => $fields) {
		if (!empty($fields)) {
			ksort($fields);
			$result['fields'][$cat_guid] = $fields;
		} else {
			unset($result['categories'][$cat_guid]);
		}
	}

	//  fire hook to see if other plugins have extra fields
	$hook_params = [
		'user' => $user,
		'edit' => $edit,
		'register' => $register,
		'profile_type_limit' => $profile_type_limit,
		'profile_type_guid' => $profile_type_guid
	];

	return elgg_trigger_plugin_hook('categorized_profile_fields', 'profile_manager', $hook_params, $result);
}

/**
 * Function just now returns only ordered (name is prepped for future release which should support categories)
 *
 * @param ElggGroup $group Group to check the values of the fields against
 *
 * @return array
 */
function profile_manager_get_categorized_group_fields($group = null) {

	$result = ['fields' => []];

	// Get all custom group fields
	$fields = elgg_get_entities([
		'type' => 'object',
		'subtype' => CUSTOM_PROFILE_FIELDS_GROUP_SUBTYPE,
		'limit' => false,
		'owner_guid' => elgg_get_config('site_guid'),
		'site_guid' => elgg_get_config('site_guid')
	]);

	if ($fields) {
		foreach ($fields as $field) {
			$admin_only = $field->admin_only;
			if ($admin_only != 'yes' || elgg_is_admin_logged_in()) {
				$result['fields'][$field->order] = $field;
			}
		}
		ksort($result['fields']);
	}

	//  fire hook to see if other plugins have extra fields
	return elgg_trigger_plugin_hook('categorized_group_fields', 'profile_manager', ['group' => $group], $result);
}

/**
 * Returns the max order from a specific profile field type
 *
 * @param string $field_type Type of fields to fetch
 *
 * @return boolean|int
 */
function profile_manager_get_max_order($field_type) {

	if (!in_array($field_type, [CUSTOM_PROFILE_FIELDS_PROFILE_SUBTYPE, CUSTOM_PROFILE_FIELDS_GROUP_SUBTYPE])) {
		return false;
	}

	$entities = elgg_get_entities_from_metadata([
		'type' => 'object',
		'subtype' => $field_type,
		'limit' => 1,
		'order_by_metadata' => [['name' => 'order', 'direction' => 'desc', 'as' => 'integer']],
		'owner_guid' => elgg_get_config('site_guid'),
		'site_guid' => elgg_get_config('site_guid'),
	]);

	if ($entities) {
		$entity = $entities[0];
		return (int) $entity->order;
	}

	return 0;
}

/**
 * Returns an array with percentage completeness and required / missing fields
 *
 * @param ElggUser $user User to count completeness for
 *
 * @return boolean|array
 */
function profile_manager_profile_completeness($user = null) {

	if (empty($user)) {
		$user = elgg_get_logged_in_user_entity();
	}

	if (!elgg_instanceof($user, 'user')) {
		return false;
	}

	$required_fields = [];
	$missing_fields = [];
	$percentage_completeness = 100;

	$fields = profile_manager_get_categorized_fields($user, true, false, true);

	if (!empty($fields['categories'])) {

		foreach ($fields['categories'] as $cat_guid => $cat) {
			$cat_fields = $fields['fields'][$cat_guid];

			foreach ($cat_fields as $field) {

				if ($field->count_for_completeness == 'yes') {
					$required_fields[] = $field;
					$metaname = $field->metadata_name;
					if (empty($user->$metaname) && ($user->$metaname !== 0)) {
						$missing_fields[] = $field;
					}
				}
			}
		}
	}

	if (count($required_fields) > 0) {
		$percentage_completeness = 100 - round(((count($missing_fields) / count($required_fields)) * 100));
	}

	return [
		'required_fields' => $required_fields,
		'missing_fields' => $missing_fields,
		'percentage_completeness' => $percentage_completeness,
	];
}

/**
 * Generates username based on emailaddress
 *
 * @param string $email Email address
 *
 * @return boolean|string
 */
function profile_manager_generate_username_from_email($email) {

	if (empty($email) || !is_email_address($email)) {
		return false;
	}

	list($username) = explode('@', $email);

	// show hidden entities (unvalidated users)
	$hidden = access_show_hidden_entities(true);

	// check if username is unique
	$original_username = $username;

	$i = 1;
	while (get_user_by_username($username)) {
		$username = $original_username . $i;
		$i++;
	}

	// restore hidden entities
	access_show_hidden_entities($hidden);

	return $username;
}
