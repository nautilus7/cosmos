/* Additional Theme Java Scripts
   Author: nautilus7, 2012
 */

// Replace parent href attribute with # in navbar menu
$(document).ready(function () { $('nav > ul > li:has(ul) > a').attr('href', function (i, val) { return val + '#'; }); });
