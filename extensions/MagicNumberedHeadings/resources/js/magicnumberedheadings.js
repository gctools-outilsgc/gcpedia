/**
 * Auto-number headings
 *
 * @source https://www.mediawiki.org/wiki/Snippets/Auto-number_headings
 * @author Krinkle
 * @version 2024-04-25
 */
var toc = document.querySelector('#toc');
if (toc) {
  // Support legacy Parser: <h2><span class=mw-headline id=…>
  // Support Parsoid: <section><div class=mw-heading><h2 id…>
  document.querySelectorAll('.mw-parser-output :is(h1,h2,h3,h4,h5,h6) .mw-headline[id], .mw-parser-output .mw-heading [id]:is(h1,h2,h3,h4,h5,h6)').forEach(function (headline) {
    var num = toc.querySelector('a[href="#' + CSS.escape(headline.id) + '"] .tocnumber');
    if (num) headline.prepend(num.textContent + ' ');
  });
} else {
  document.body.classList.add('tpl-autonum');
}