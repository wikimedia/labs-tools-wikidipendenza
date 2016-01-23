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

class Wikiversity extends TestSource {

	protected static $baseUrl = '//it.wikiversity.org';

	protected static $testTitle = 'Wikiversità:Wikitest';

	protected static $testSection = 1;

	protected static $testSectionTitle = 'Ecco_il_test';

	protected static $scoreSection = 4;

	public static function getLinks() {
		$links = parent::getLinks();
		// this one is only relevant for Wikiversity
		array_unshift(
			$links,
			'<a href="//it.wikiversity.org/wiki/Wikiversit%C3%A0:Wikitest">fonte</a>'
		);
		return $links;
	}

}
