<?php

defined('_JEXEC') or die;

//We need content plugin BIS to be installed !!!
require_once (JPATH_BASE . DS . 'plugins' . DS . 'content' . DS . 'bis' . DS . 'myr' . DS . 'myr.php');

jimport('joomla.html.parameter');

abstract class Mod_BisHelper {

  //Build query for myr based on module params
  public function buildQuery($params) {
    //Get parameters
    $show_type = $params->get('show-type');
    $custom_query = $params->get('custom-query');
    $limit_count = $params->get('limit-count');
    $random_sort = $params->get('random-sort');
    $only_year = $params->get('only-year');
    $only_program = $params->get('only-program');

    //Ret value
    $ret = array('queries' => array(), 'result_modify' => '');


    //Custom query
    if ($show_type == 'custom') {
      if (strlen($custom_query) > 0) {
        $ret['queries'] = array('0' => $custom_query);
        return $ret;
      } else {
        $ret['queries'] = array('0' => 'query=akce');
        return $ret;
      }
    }

    //Base query
    switch ($show_type) {
      case 'all':
        $ret['queries'] = array('0' => 'query=akce');
        break;
      case 'tab':
        $ret['queries'] = array('0' => 'query=akce&filter=tabor',
            '1' => 'query=akce&filter=vik',
            '2' => 'query=akce&filter=klub',
            '3' => 'query=akce&filter=ekostan',
            '4' => 'query=akce&filter=vikekostan');
        break;
      case 'vik':
        $ret['queries'] = array('0' => 'query=akce&filter=vik');
        break;
      case 'tabor':
        $ret['queries'] = array('0' => 'query=akce&filter=tabor');
        break;
      case 'klub':
        $ret['queries'] = array('0' => 'query=akce&filter=klub');
        break;
      case 'eko':
        $ret['queries'] = array('0' => 'query=akce&filter=ekostan');
        break;
      case 'vikeko':
        $ret['queries'] = array('0' => 'query=akce&filter=vikekostan');
        break;
    }


    //Add other parameters to query if needed
    $query_count = count($ret['queries']);
    for ($i = 0; $i < $query_count; $i++) {

      //Additional params
      //Limit
      if (strlen($limit_count) > 0 && intval($limit_count) > 0 && $random_sort == 0) {
        $ret['queries'][$i].='&limit_from=0&limit_count=' . $limit_count;
      }

      //Only year
      if (strlen($only_year) > 0 && intval($only_year) > 1970) {
        $ret['queries'][$i].='&rok=' . $only_year;
      }

      //Only program
      if (strlen($only_program) > 0) {
        $ret['queries'][$i].='&program=' . $only_program;
      }
    }

    //Random sort
    if ($random_sort == '1') {
      if (strlen($limit_count) > 0 && intval($limit_count) > 0) {
        $ret['result_modify'] = "randomize-$limit_count";
      } else {
        $ret['result_modify'] = "randomize";
      }
    }

    return $ret;
  }

  //Get result
  public function getResult($query) {
    $myr = new myr();
    $result = $myr->doQuery($query);
    return $result;
  }

  public function getFormattedResult($result, $params) {
    $template = new myrTemplateData;
    $template->head = $params->get('tpl-head');
    $template->item = $params->get('tpl-item');
    $template->foot = $params->get('tpl-foot');

    //Set up links
    $links['detail-url'] = $params->get('detail-url');
    $links['detail-url-vik'] = $params->get('detail-url-vik');
    $links['detail-url-tabor'] = $params->get('detail-url-tabor');
    $links['detail-url-klub'] = $params->get('detail-url-klub');
    $links['detail-url-eko'] = $params->get('detail-url-eko');
    $links['detail-url-vikeko'] = $params->get('detail-url-vikeko');

    $template->link_detail = $links;

    $myr = new myr;
    return $myr->displayFormattedResult($result, $template);
  }

  //Random sort of result
  public function randomizeResult($result, $count = 0) {
    $i_array = null;
    
    $count = intval($count);

    for ($i = 0; $i < count($result); $i++) {
      $i_array[$i] = $result[$i];
    }

    //Random order
    if (count($i_array) > 0) {
      shuffle($i_array);
    }
    $res_array = $i_array;



    if ($count > 0 && count($i_array) > $count) {
      $res_array = null;
      for ($i = 0; $i < $count; $i++) {
        $res_array[$i] = $i_array[$i];
      }
    }

    return $res_array;
  }

  public function makeOrderedTabs($show_camp, $show_vik, $show_club, $show_eko, $show_vikeko, $camp_result, $vik_result, $club_result, $eko_result, $vikeko_result) {
    $tabs = array('names' => array(0 => '',
            1 => '',
            2 => '',
            3 => '',
            4 => '',
            5 => ''),
        'results' => array(0 => '',
            1 => '',
            2 => '',
            3 => '',
            4 => '',
            5 => ''));

    $tabs['names'][$show_camp] = 'MOD_BIS_CAMPS';
    $tabs['names'][$show_vik] = 'MOD_BIS_VIKS';
    $tabs['names'][$show_club] = 'MOD_BIS_CLUBS';
    $tabs['names'][$show_eko] = 'MOD_BIS_EKOSTAN';
    $tabs['names'][$show_vikeko] = 'MOD_BIS_VIKS';

    $tabs['results'][$show_camp] = $camp_result;
    $tabs['results'][$show_vik] = $vik_result;
    $tabs['results'][$show_club] = $club_result;
    $tabs['results'][$show_eko] = $eko_result;
    $tabs['results'][$show_vikeko] = $vikeko_result;

    return $tabs;
  }

}

?>
