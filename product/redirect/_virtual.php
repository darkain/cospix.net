<?php

$product = $db->rowId('pudl_product', 'product_id', $router->id);
\af\affirm(404, $product);
\af\affirm(422, $product['product_url']);

//TODO: analytics tracking of redirected URLs

$afurl->redirect($product['product_url']);
