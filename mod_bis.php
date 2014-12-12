<?php

//no direct access
defined('_JEXEC') or die;

// include the helper file
require_once(dirname(__FILE__) . DS . 'helper.php');

// add jscript and css files for jquery tabs
$document = & JFactory::getDocument();
$base_url = JURI::base() . 'modules/mod_bis/';

$document->addStyleSheet($base_url . 'css/mod_bis.css');
$document->addScript($base_url . 'js/TabPane.js');
$document->addScript($base_url . 'js/TabPane.Extra.js');
$document->addScript($base_url . 'js/mod_bis.js');


//Params
$css_class = $params->get('css_class');
$show_type = $params->get('show-type');
$show_camp = $params->get('show-camp-tab');
$show_vik = $params->get('show-vik-tab');
$show_club = $params->get('show-club-tab');
$show_eko = $params->get('show-eko-tab');
$show_vikeko = $params->get('show-vikeko-tab');
$show_calendar_link = $params->get('show-calendar-link');
$calendar_link_position = $params->get('calendar-link-position');
$calendar_link = $params->get('calendar-link');
$calendar_link_link = $params->get('calendar-link-link');
$show_custom_header = $params->get('show-custom-header');
$custom_header_link = $params->get('custom-header-link');
$custom_header_text = $params->get('custom-header-text');
$custom_header_level = $params->get('custom-header-level');

//Get data
$query = Mod_BisHelper::buildQuery($params);
$result_1 = Mod_BisHelper::getResult($query['queries']['0']);

//Get data for other tabs
if (count($query['queries']) > 1) {
  $result_1 = Mod_BisHelper::getResult($query['queries']['0']);
  $result_2 = Mod_BisHelper::getResult($query['queries']['1']);
  $result_3 = Mod_BisHelper::getResult($query['queries']['2']);
  $result_4 = Mod_BisHelper::getResult($query['queries']['3']);
  $result_5 = Mod_BisHelper::getResult($query['queries']['4']);
}

//randomize result if parameters is set
if (preg_match('/randomize/', $query['result_modify'])) {
  $count = substr($query['result_modify'], strpos($query['result_modify'], '-') + 1);
  if (intval($count) > 0) {
    $result_1->data = Mod_BisHelper::randomizeResult($result_1->data, $count);
    if (count($query['queries']) > 1) {
      $result_2->data = Mod_BisHelper::randomizeResult($result_2->data, $count);
      $result_3->data = Mod_BisHelper::randomizeResult($result_3->data, $count);
      $result_4->data = Mod_BisHelper::randomizeResult($result_4->data, $count);
      $result_5->data = Mod_BisHelper::randomizeResult($result_5->data, $count);
    }
  } else {
    $result_1->data = Mod_BisHelper::randomizeResult($result_1->data);
    if (count($query['queries']) > 1) {
      $result_2->data = Mod_BisHelper::randomizeResult($result_2->data);
      $result_3->data = Mod_BisHelper::randomizeResult($result_3->data);
      $result_4->data = Mod_BisHelper::randomizeResult($result_4->data, $count);
      $result_5->data = Mod_BisHelper::randomizeResult($result_5->data, $count);
    }
  }
}


//Get formatted result for display
$formatted_result_text = Mod_BisHelper::getFormattedResult($result_1, $params);

//Get formatted result for other tabs
if (count($query['queries']) > 1) {
  $formatted_result_text_2 = Mod_BisHelper::getFormattedResult($result_2, $params);
  $formatted_result_text_3 = Mod_BisHelper::getFormattedResult($result_3, $params);
  $formatted_result_text_4 = Mod_BisHelper::getFormattedResult($result_4, $params);
  $formatted_result_text_5 = Mod_BisHelper::getFormattedResult($result_5, $params);

  $tabs = Mod_BisHelper::makeOrderedTabs($show_camp, $show_vik, $show_club, $show_eko, $show_vikeko, $formatted_result_text, $formatted_result_text_2, $formatted_result_text_3, $formatted_result_text_4, $formatted_result_text_5);
}

// include the template for display
require(JModuleHelper::getLayoutPath('mod_bis'));
?>
