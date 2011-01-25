<?php
/**
 * Parser for ebay.co.uk
 *
 * @ingroup    ebayParser
 * @author     Knut Kohl <knutkohl@users.sourceforge.net>
 * @copyright  2007-2011 Knut Kohl
 * @license    GNU General Public License http://www.gnu.org/licenses/gpl.txt
 * @version    1.0.0
 * @version    $Id$
 */
class ebayParser_co_uk extends ebayParser {

  /**
   * Class constructor
   */
  public function __construct() {
    parent::__construct('co_uk');
  }

  /**
   * Individually convert end time string to a timestamp
   *
   * @param string $dt Found string by reg. expression
   */
  public function getDetailEND( $dt ) {

    if (preg_match('~(\d+)-(\w{3})-(\d+)\s+(\d+):(\d+):(\d+)\s+(\w+)~', $dt, $ts)) {
      // translate month
      $ts[2] = array_search(strtoupper($ts[2]),
                            array(1=>'JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN',
                                     'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'));

  # _dbg($ts);

      // correct year ???
      // if ($ts[3] < 100) $ts[3] += 2000;

      // local and ebay time zone
      $tz = array($this->Timezone, $ts[7]);

  # _dbg($tz);

      foreach ($tz as $t) {
        if (!isset($this->TimeZones[$t])) {
          trigger_error('Missing time zone definition: '.$t);
          $this->TimeZones[$t] = 0;
        }
      }

      // offset between ebay.com used time and local time plus undocumented server offset
      $offset = $this->TimeZones[$tz[1]] - $this->TimeZones[$tz[0]] - Registry::get('TZOFFSET');

  # _dbg($this->TimeZones[$tz[1]].' - '.$this->TimeZones[$tz[0]]);

      $ts = mktime($ts[4],$ts[5],$ts[6],$ts[2],$ts[1],$ts[3]);
      $ts -= $offset * 60*60;

  # _dbg(date('r',$ts));

      return $ts;
    }
    return FALSE;
  }

} // class