<?php
/**
 * Copyright 2015 Ricordisamoa
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

namespace Wikidipendenza;

require_once '../class.php';

class Wikipedia extends TestSource {

	protected static $baseUrl = '//it.wikipedia.org';

	protected static $testTitle = 'Wikipedia:Scherzi e STUBidaggini/Wikidipendenza';

	protected static $testSection = 1;

	protected static $testSectionTitle = 'Il_test';

	protected static $scoreSection = 3;

	public static function getLinks() {
		$links = parent::getLinks();
		// these ones are only relevant for Wikipedia
		array_unshift(
			$links,
			'<a href="//it.wikipedia.org/wiki/Wikipedia:Scherzi_e_STUBidaggini/Wikidipendenza">fonte</a>'
		);
		$links[] = '<a href="//tools.wmflabs.org/apersonbot/wikipediholism-test/">versione inglese</a>';
		return $links;
	}

	public static function getScorePlus( $cats, $score, $revid ) {
		$date = new \DateTime();
		$fmt = new \IntlDateFormatter(
			'it_IT',
			\IntlDateFormatter::FULL,
			\IntlDateFormatter::FULL,
			'Europe/Rome',
			\IntlDateFormatter::GREGORIAN,
			'd MMMM yyyy'
		);
		$date = $fmt->format( $date );

		return '<br><br>Puoi aggiungere questo codice alla ' .
			'<a href="//it.wikipedia.org/wiki/Special:MyPage">tua pagina utente</a>:<br>' .
			"<pre>{{Infobox utente/Wikidipendenza|{$cats[0][2]}|$score" .
			"|oldid=$revid|data=$date}}</pre>";
	}

}
