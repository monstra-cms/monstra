/**
 *	Monstra JS module
 *	@package Monstra
 *	@author Romanenko Sergey / Awilum
 *	@copyright 2012 Romanenko Sergey / Awilum
 *	@version $Id$
 *	@since 1.0.0
 *  @license http://opensource.org/licenses/gpl-license.php GNU Public License
 *  Monstra is free software. This version may have been modified pursuant
 *  to the GNU General Public License, and as distributed it includes or
 *  is derivative of works licensed under the GNU General Public License or
 *  other free or open source software licenses.
 *  See COPYING.txt for copyright notices and details.
 *  @filesource
 */


/* Confirm delete */
function confirmDelete(msg){var data=confirm(msg+" ?"); return data;}

$(document).ready(function() {
    /* DropDown Menu for Mobile Devices */
    $("#sections").change(function(){
       window.location = $('#sections option:selected').attr('rel');
    });
});
