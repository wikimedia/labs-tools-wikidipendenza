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

?>
<!DOCTYPE html>
<html lang="it">
<head>
<meta charset="utf-8">
<title>Test Wikidipendenza - Wikimedia Labs</title>
<?php if ( isset( $class ) ) { ?>
<link rel="stylesheet" type="text/css" href="../common.css">
<?php } ?>
</head>
<body>
<h1>Test Wikidipendenza
<?php

define( 'WIKIDIPENDENZA', 1 );

if ( isset( $class ) ) {
	$links = $class::getLinks();
	if ( count( $links ) > 0 ) {
		echo '<small>[' . implode( ' &middot; ', $links ) . ']</small>';
	}
}

?></h1>
<?php

if ( isset( $class ) ) {
	if ( isset( $_POST['score'] ) ) {
		require_once 'score.php';
	} else {
		require_once 'test.php';
	}
} else {
	$links = array(
		'<a href="./wikipedia/">Wikipedia</a>',
		'<a href="./wikiversity/">Wikiversità</a>',
	);
	echo implode( ' &middot; ', $links );
}

?>
</body>
</html>
