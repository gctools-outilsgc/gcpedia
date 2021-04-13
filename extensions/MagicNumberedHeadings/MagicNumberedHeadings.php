<?php
/**
 * @copyright Copyright © 2007, Purodha Blissenabch.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation, version 2
 * of the License.
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 * See the GNU General Public License for more details.
 */
 
/**
 * This extension realizes a new MagicWord __NUMBEREDHEADINGS__.
 * If an article contains this MagicWord, numbering of the
 * headings is performed regardless of the user preference setting.
 * 
 * How to use:
 * * include this extension in LocalSettings.php: 
 *   require_once($IP.'/extensions/MagicNoNumberedHeadings.php');
 * * Add "__NUMBEREDHEADINGS__" to any article of your choice.
 * 
 * @author Purodha Blissenbach
 * @version $Revision: 1.12
 */

use MediaWiki\MediaWikiServices;

if (!defined('MEDIAWIKI')) {
        die("This requires the MediaWiki enviroment.");
}
 
$wgExtensionCredits['parserhook'][] = array(
        'name' => 'MagicNumberedHeadings',
        'version' => '1.12',
        'author' => 'Purodha Blissenbach',
        'url' => 'https://www.mediawiki.org/wiki/Extension:MagicNumberedHeadings',
        'description' => 'Adds MagicWord "<nowiki>__NUMBEREDHEADINGS__</nowiki>"',
);
$dir = dirname(__FILE__) . '/';

$wgExtensionMessagesFiles['MagicNumberedHeadings'] = $dir . 'MagicNumberedHeadings.i18n.php';

$wgHooks['MagicWordMagicWords'][] = 'MagicNumberedHeadingsMagicWordMagicWords';
$wgHooks['MagicWordwgVariableIDs'][] = 'MagicNumberedHeadingsMagicWordwgVariableIDs';
$wgHooks['InternalParseBeforeLinks'][] = 'MagicNumberedHeadingsInternalParseBeforeLinks';
 
function MagicNumberedHeadingsMagicWordMagicWords(&$magicWords)
{
        $magicWords[] = 'MAG_NUMBEREDHEADINGS';
        return true;
}
 
function MagicNumberedHeadingsMagicWordwgVariableIDs(&$wgVariableIDs)
{
        $wgVariableIDs[] = 'MAG_NUMBEREDHEADINGS';
        return true;
}
 
function MagicNumberedHeadingsInternalParseBeforeLinks(&$parser, &$text, &$stripState)
{
        if (MediaWikiServices::getInstance()->getMagicWordFactory()->get( 'MAG_NUMBEREDHEADINGS' )->matchAndRemove( $text ) )
        {
                $parser->mOptions->setNumberHeadings(TRUE);
        }
        return true;
}