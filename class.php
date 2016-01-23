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

abstract class TestSource {

	protected static $baseUrl;

	protected static $testTitle;

	protected static $testSection;

	protected static $testSectionTitle;

	protected static $scoreSection;

	public static function getTestSectionTitle() {
		return static::$testSectionTitle;
	}

	public static function getBaseUrl() {
		return static::$baseUrl;
	}

	public static function getApiUrl() {
		return 'https:' . static::$baseUrl . '/w/api.php';
	}

	public static function getLinks() {
		return array(
			'<a href="//it.wikipedia.org/wiki/Wikipedia:Bar/Discussioni/Wikidipendente%3F' .
				'">ispirato da Filnik</a>',
		);
	}

	protected static function getParsedPage( $params = array() ) {
		static $query = array(
			'action' => 'parse',
			'prop' => 'revid|text',
			'disabletoc' => 1,
			'noimages' => 1,
			'disableeditsection' => 1,
			'format' => 'json'
		);
		$query['page'] = static::$testTitle;
		$url = static::getApiUrl() . '?' . http_build_query( array_merge( $query, $params ) );
		$data = json_decode( file_get_contents( $url ), true );

		$revid = $data['parse']['revid'];
		$html = utf8_decode( $data['parse']['text']['*'] );
		return array( $html, $revid );
	}

	public static function getTest() {
		return static::getParsedPage( array( 'section' => static::$testSection ) );
	}

	public static function getScore() {
		return static::getParsedPage( array( 'section' => static::$scoreSection ) );
	}

	public static function getScorePlus( $cats, $score, $revid ) {
		return '';
	}

}
