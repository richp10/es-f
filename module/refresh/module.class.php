<?php
/** @defgroup Module-Refresh Module Refresh

*/

/**
 * Module Refresh
 *
 * @ingroup    Module
 * @ingroup    Module-Refresh
 * @author     Knut Kohl <knutkohl@users.sourceforge.net>
 * @copyright  2009-2011 Knut Kohl
 * @license    http://www.gnu.org/licenses/gpl.txt GNU General Public License
 * @version    1.0.0
 * @version    $Id: v2.4.1-62-gb38404e 2011-01-30 22:35:34 +0100 $
 */
class esf_Module_Refresh extends esf_Module {

  /**
   * @return array Array of actions handled by the module
   */
  public function handles() {
    return array('index');
  }

  /**
   *
   */
  public function IndexAction() {
    // set marker for plugin
    if (!Session::get('Module.Refresh.Items')) {
      // all auctions
      Session::set('Module.Refresh.Items', array_keys(esf_Auctions::$Auctions));
      Event::ProcessInform('setLastUpdate');
    }

    // redirect to last module
    $lastmodule = Session::get('Module.Refresh.Module');
    $this->redirect($lastmodule ? $lastmodule : STARTMODULE);
  }

}