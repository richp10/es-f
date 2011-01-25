<?php
/**
 * Module GoogleGadget plugin
 *
 * @ingroup    Plugin
 * @ingroup    Module-GoogleGadgets
 * @author     Knut Kohl <knutkohl@users.sourceforge.net>
 * @copyright  2009-2011 Knut Kohl
 * @license    GNU General Public License http://www.gnu.org/licenses/gpl.txt
 * @version    1.0.0
 * @version    $Id$
 */
class esf_Plugin_Module_GoogleGadgets extends esf_Plugin {

  /**
   * @return array Array of events handled by the plugin
   */
  public function handles() {
    return array('BuildMenu');
  }

  /**
   *
   */
  public function BuildMenu() {
    // disable on mobile layouts
    if (Session::get('Mobile') AND !$this->Mobile) return;
    esf_Menu::addMain( array( 'module' => 'googlegadgets', 'id' => 99 ) );
    Event::dettach($this);
  }
}

Event::attach(new esf_Plugin_Module_GoogleGadgets);