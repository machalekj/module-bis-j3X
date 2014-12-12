<?php
defined('_JEXEC') or die; // no direct access
//Custom header
if ($show_custom_header == 1) {
  echo "<$custom_header_level>";
  if (strlen($custom_header_link) > 0) {
    echo "<a href=\"$custom_header_link\"\>";
    echo $custom_header_text;
    echo "</a>";
  } else {
    echo $custom_header_text;
  }
  echo "</$custom_header_level>";
}

//Calendar link - up
if ($show_calendar_link == 1 && $calendar_link_position == 'up') {
  echo '<p class="calendar_link"><a href="' . $calendar_link_link . '">' . $calendar_link . '</a></p>';
}

if ($show_type != "tab") {
//Classic view
  ?>
  <div class="<?php echo $css_class; ?>">
    <?php echo $formatted_result_text; ?>
  </div>

  <?php
} else {
  ?>
  <noscript>
  <p><?php echo JText::_('MOD_BIS_ENABLE_JAVASCRIPT'); ?></p>
  </noscript>

  <div id="mod_bis_tabs" class="<?php echo $css_class; ?>">
    <?php
    //TAB view

    $less_tabs = 0;

    echo "<ul class=\"tabs\" id=\"mod_bis_tab_selector\">\n";
    for ($i = 1; $i < 6; $i++) {
      if ($tabs['names'][$i] != '') {
        echo "<li class=\"tab " . strtolower($tabs['names'][$i]) . "\" id=\"tab-num-" . $i . "\">"
        . JText::_($tabs['names'][$i])
        . "</li>\n";
        $less_tabs++;
      }
    }
    echo "</ul>\n";

    for ($i = 1; $i < 6; $i++) {
      if ($tabs['results'][$i] != '') {

        $less_tab_style = "";

        if ($less_tabs < 3) {
          $less_tab_style = "less_tabs";
        }

        echo "<div id=\"mod_bis_tabs-$i\" class=\"content $less_tab_style\">\n";
        echo $tabs['results'][$i];
        echo "</div>\n";
      }
    }
    ?>
  </div>
  <?php
}

//Calendar link - up
if ($show_calendar_link == 1 && $calendar_link_position == 'bottom') {
  echo '<p class="calendar_link"><a href="' . $calendar_link_link . '">' . $calendar_link . '</a></p>';
}

