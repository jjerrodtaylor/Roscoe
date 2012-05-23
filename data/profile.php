<?php
/** 
 *  SeekQuarry/Yioop --
 *  Open Source Pure PHP Search Engine, Crawler, and Indexer
 *
 *  Copyright (C) 2009-2012  Chris Pollett chris@pollett.org
 *
 *  LICENSE:
 *
 *  This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 *  END LICENSE
 *
 * Computer generated file giving the key defines of directory locations
 * as well as database settings used to run the SeekQuarry/Yioop search engine
 *
 * @author Chris Pollett chris@pollett.org
 * @package seek_quarry
 * @subpackage config
 * @license http://www.gnu.org/licenses/ GPL3
 * @link http://www.seekquarry.com/
 * @copyright 2009-2012
 * @filesource
 */

if(!defined('BASE_DIR')) {echo "BAD REQUEST"; exit();}
define('USER_AGENT_SHORT', "Please Name Your robot");
define('DEFAULT_LOCALE', "en-US");
define('DEBUG_LEVEL', 0);
define('DBMS', "sqlite3");
define('DB_HOST', "");
define('DB_NAME', "default");
define('DB_USER', "");
define('DB_PASSWORD', "");
define('NAME_SERVER', "http://localhost/");
define('AUTH_KEY', "0");
define('WEB_URI', "/roscoe/results/");
define('USE_MEMCACHE', "");
define('MEMCACHE_SERVERS', "");
define('USE_FILECACHE', "");
define('WORD_SUGGEST', "1");
define('CACHE_LINK', "1");
define('SIMILAR_LINK', "1");
define('IN_LINK', "1");
define('IP_LINK', "1");
define('SIGNIN_LINK', "1");
define('ROBOT_INSTANCE', "");
define('WEB_ACCESS', "1");
define('RSS_ACCESS', "1");
define('API_ACCESS', "1");
define('TITLE_WEIGHT', "4");
define('DESCRIPTION_WEIGHT', "1");
define('LINK_WEIGHT', "2");