<?php
/**
@defgroup Module-Index Module Index


*/

/**
 * Module Index plugin
 *
 * @ingroup    Plugin
 * @ingroup    Module-Index
 * @author     Knut Kohl <knutkohl@users.sourceforge.net>
 * @copyright  2009-2011 Knut Kohl
 * @license    GNU General Public License http://www.gnu.org/licenses/gpl.txt
 * @version    1.0.0
 * @version    $Id: v2.4.1-62-gb38404e 2011-01-30 22:35:34 +0100 $
 */
class esf_Plugin_Module_Index extends esf_Plugin {

  /**
   * @return array Array of events handled by the plugin
   */
  public function handles() {
    return array('BuildMenu');
  }

  /**
   *
   */
  function BuildMenu() {
    esf_Menu::addMain( array( 'module' => 'index', 'id' => -1 ) );

    Event::dettach($this);
  }
}

Event::attach(new esf_Plugin_Module_Index);