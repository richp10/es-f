<?php
/**
@defgroup Module-ExchangeRates Module ExchangeRates

*/

/**
 * Module ExchangeRates
 *
 * @ingroup    Module
 * @ingroup    Module-ExchangeRates
 * @author     Knut Kohl <knutkohl@users.sourceforge.net>
 * @copyright  2009-2011 Knut Kohl
 * @license    GNU General Public License http://www.gnu.org/licenses/gpl.txt
 * @version    1.0.0
 * @version    $Id: v2.4.1-62-gb38404e 2011-01-30 22:35:34 +0100 $
 */
class esf_Module_ExchangeRates extends esf_Module {

  /**
   * @return array Array of actions handled by the module
   */
  public function handles() {
    return array('index');
  }

  /**
   * Handles index action
   */
  public function IndexAction() {
    $path = dirname(__file__).'/classes';

    if (time() > (Session::get('Module.ExchangeRates.TS')+$this->CacheLifespan*24*60*60) OR
        !($rates = Session::get('Module.ExchangeRates.Rates')) OR
        !($source = Session::get('Module.ExchangeRates.Source'))) {

      /// Yryie::Info('Read exchange rates from ECB: '.$this->URL);

      Loader::Load($path.'/xmlparser.class.php');

      $parser = new XMLParser;
      $data = $parser->loadFile($this->URL);
      $data = $data[0]['childs'];

      // _dbg($data);

      // currency names
      $ini = parse_ini_file($path.'/currencies.ini', true);
      $curr = $ini['en'];
      $lang = Session::get('Language');
      if (isset($ini[$lang])) $curr = array_merge($curr, $ini[$lang]);

      $rates['EUR'] = array( 'rate' => 1, 'name' => 'Euro' );

      foreach ($data[2]['childs'][0]['childs'] as $c) {
        $key = $c['attr']['CURRENCY'];
        $rates[$key]['rate'] = $c['attr']['RATE'];
        $rates[$key]['name'] = array_key_exists($key, $curr) ? $curr[$key] : NULL;
      }

      $source = $data[1]['childs'][0]['value'] . ', '
               .$data[0]['value'] . ', '
               .$data[2]['childs'][0]['attr']['TIME'];

      Session::set('Module.ExchangeRates.TS', time());
      Session::set('Module.ExchangeRates.Rates',  $rates);
      Session::set('Module.ExchangeRates.Source', $source);

    /* ///
    } else {
      Yryie::Info('Use buffered exchange rates.');
    /// */
    }

    TplData::set('sourceurl', $this->URL);
    TplData::set('source', $source);
    TplData::set('rates', $rates);

    if (!$this->isPost()) {
      TplData::set('Amount', 1);
      TplData::set('SCurr', 'EUR');
      TplData::set('Calced', 1);
      TplData::set('DCurr', 'EUR');
    } else {
      TplData::set('Amount', $this->Request('amount'));
      TplData::set('SCurr',  $this->Request('scurr'));
      TplData::set('Calced', toNum(iif($this->Request('amount'), $this->Request('amount'), 1))
                           * @$rates[$this->Request('dcurr')]['rate']
                           / @$rates[$this->Request('scurr')]['rate']);
      TplData::set('DCurr',  $this->Request('dcurr'));
    }
  }

}