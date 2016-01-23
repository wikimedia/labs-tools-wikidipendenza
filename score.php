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

$score = array_sum( $_POST['score'] );

echo 'Hai totalizzato un punteggio di <big class="score">' . $score . '</big>';

list( $html, $revid ) = $class::getScore();

$doc = new \DOMDocument();
$doc->loadHTML( $html );

$allBounds = array();

foreach ( $doc->getElementsByTagName( 'li' ) as $li ) {
	if ( preg_match( '/\bgallerybox\b/', $li->getAttribute( 'class' ) ) ) {
		$images = array();
		foreach ( $li->getElementsByTagName( 'a' ) as $a ) {
			if ( preg_match( '/\bimage\b/', $a->getAttribute( 'class' ) ) ) {
				$images[] = $a;
			}
		}
		if ( count( $images ) !== 1 ) {
			continue;
		}
		$descs = array();
		foreach ( $li->getElementsByTagName( 'div' ) as $div ) {
			if ( preg_match( '/\bgallerytext\b/', $div->getAttribute( 'class' ) ) ) {
				$ps = $div->getElementsByTagName( 'p' );
				if ( count( $ps ) === 1 ) {
					$p = $ps->item( 0 );
					foreach ( $p->getElementsByTagName( 'a' ) as $a ) {
						relToAbs( $a, $class::getBaseUrl() );
					}
					$desc = trim( getCleanCode( $p ) );
					preg_match( '/^Da (\d+) a (\d+) p\. \- (\w+( \w+)*!?)/', $desc, $bounds );
					if ( $bounds ) {
						$descs[] = array( intval( $bounds[1] ), intval( $bounds[2] ), $bounds[3], $desc );
					} else {
						preg_match( '/^(\d+) p\. e oltre \- (\w+( \w+)*!?)/', $desc, $lowerBound );
						if ( $lowerBound ) {
							$descs[] = array( intval( $lowerBound[1] ), null, $lowerBound[2], $desc );
						}
					}
				}
			}
		}
		if ( count( $descs ) !== 1 ) {
			continue;
		}
		$descs[0][] = $images[0];
		$allBounds[] = $descs[0];
	}
}

$cats = array();

foreach ( $allBounds as $cfg ) {
	if ( $cfg[0] <= $score && ( $cfg[1] === null || $score < $cfg[1] ) ) {
		$cats[] = $cfg;
	}
}

if ( count( $cats ) === 1 ) {
	$img = $cats[0][4];
	relToAbs( $img, $class::getBaseUrl() );
	echo ' pertanto appartieni alla seguente categoria:<br><br>' .
		getCleanCode( $img, true ) . $cats[0][3];

	echo $class::getScorePlus( $cats, $score, $revid );
}
