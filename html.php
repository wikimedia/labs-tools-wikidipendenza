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

/**
 * Get the HTML code for an element stripped of all tags but a few safe ones.
 *
 * @param \\DOMElement $dom The element to return the clean code for
 * @param bool $outer Whether to include the outermost element
 * @return string The cleaned HTML code
 */
function getCleanCode( \DOMElement $dom, $outer = false ) {
	static $allowed_tags = array( 'a', 'b', 'em', 'i', 'img', 'kbd', 'small', 'span', 'strong' );

	$remove = array();
	foreach ( $dom->getElementsByTagName( '*' ) as $el ) {
		if ( !in_array( $el->tagName, $allowed_tags ) ) {
			$remove[] = $el;
		}
	}
	foreach ( $remove as $el ) {
		$el->parentNode->removeChild( $el );
	}

	if ( $outer ) {
		return $dom->ownerDocument->saveHTML( $dom );
	}

	$ret = '';
	foreach ( $dom->childNodes as $node ) {
		$ret .= $dom->ownerDocument->saveHTML( $node );
	}
	return $ret;
}

/**
 * Change an HTML <a> element's href attribute from a relative to an absolute URL.
 * FIXME: only valid for the Italian Wikipedia.
 *
 * @param \\DOMElement $link The element to change
 * @param string $baseUrl The hostname of the wiki
 */
function relToAbs( \DOMElement &$link, $baseUrl ) {
	$href = $link->getAttribute( 'href' );
	if ( substr( $href, 0, 6 ) === '/wiki/' || substr( $href, 0, 3 ) === '/w/' ) {
		$link->setAttribute( 'href', $baseUrl . $href );
	}
}
