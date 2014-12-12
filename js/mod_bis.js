document.addEvent('domready', function() {
  var tabPane = new TabPane('mod_bis_tabs', {}, function() {
    var showTab = window.location.hash.match(/tab=(\d+)/);

    //Get default tab from cookie
    var tabIndexCookie = Cookie.read('mod_bis_actual_tab');
    if(tabIndexCookie == null) {
      tabIndexCookie = 0;
    }

    var list = document.id("mod_bis_tab_selector").getElements("li");
    numList = list.length;
    numList--;

    if(tabIndexCookie > numList) {
      tabIndexCookie=0;
    }

    return showTab ? showTab[1] : parseInt(tabIndexCookie);
  });

  var tab1 = $('tab-num-1');
  var tab2 = $('tab-num-2');
  var tab3 = $('tab-num-3');

  if(tab1) {
    tab1.addEvent('click', function(e) {
      // stop the event from bubbling up and causing a native click
      e.stop();
      //Main code
      tabPane.show(0);
      var cookie  = Cookie.write('mod_bis_actual_tab', 0, {
        duration: 1
      });
    });
  }

  if(tab2) {
    tab2.addEvent('click', function(e) {
      // stop the event from bubbling up and causing a native click
      e.stop();
      //Main code
      tabPane.show(1);
      var cookie  = Cookie.write('mod_bis_actual_tab', 1, {
        duration: 1
      });
    });
  }
  if(tab3) {
    tab3.addEvent('click', function(e) {
      // stop the event from bubbling up and causing a native click
      e.stop();
      //Main code
      tabPane.show(2);
      var cookie  = Cookie.write('mod_bis_actual_tab', 2, {
        duration: 1
      });
    });
  }

});
