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

if ( !defined( 'WIKIDIPENDENZA' ) ) {
	die();
}

require_once 'html.php';

list( $html, ) = $class::getTest();

$doc = new \DOMDocument();
$doc->loadHTML( $html );

$heading = $doc->getElementById( $class::getTestSectionTitle() );
if ( count( $heading ) !== 1 || $heading->parentNode->tagName !== 'h2' ) {

	echo 'Non trovo la sezione.';

} else {

	$ols = $doc->getElementsByTagName( 'ol' );
	if ( count( $ols ) !== 1 ) {

		echo 'Non trovo le domande.';

	} else {

		echo '<form method="post"><ol>';
		foreach ( $ols->item( 0 )->getElementsByTagName( 'li' ) as $node ) {
			echo '<li>';
			foreach ( $node->getElementsByTagName( 'a' ) as $a ) {
				relToAbs( $a, $class::getBaseUrl() );
			}
			$question = getCleanCode( $node );
			if ( $question === '' ) {
				echo '<i>domanda non rilevata</i>';
			} else {
				echo '<label>';
				preg_match( '/^(.+) *\((-?\d+)\)$/', $question, $match );
				if ( $match ) {
					$score = intval( $match[2] );
					echo '<input type="checkbox" name="score[]" value="' . $score . '">' . $match[1];
				} else {
					echo $question . '<br>punti: ' .
						'<input type="number" name="score[]" value="0" step="0.5">';
				}
				echo '</label>';
			}
			echo '</li>';
		}
		echo '</ol><input type="submit" value="Calcola!"></form>';

	}

}
