<!-- COMMENT
/*
 * Copyright (c) 2006-2009 Knut Kohl <knutkohl@users.sourceforge.net>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 *  (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * GPL: http://www.gnu.org/licenses/gpl.txt
 *
 */
-->

<a href="{DELETEURL}"
   <!-- IF CONST.MODULE.POPUPEDIT -->
   onclick="return CreatePopupWindow('PopupAuctionDelete{ITEM}',150,-1,false)"
   <!-- ENDIF -->
  >
  <img class="icon" src="layout/default/images/delete.gif" alt="D"
       title="[[Auction.DeleteAuction|striptags|quote]]"
       onmouseover="Tip('{js:[[Auction.DeleteAuction]]}')">
</a>
