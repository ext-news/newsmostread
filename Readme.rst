

Documentation
^^^^^^^^^^^^^

All you need to do is:

* Install extension
* Include static TS
* Place a call in the detail.html template with something like this: ::

	<img src="http://www.domain.tld/index.php?eID=tx_newsmostread&uid={newsItem.uid}" />

* Done

mod_rewrite
"""""""""""

You can use mod_rewrite to hide the eID call. E.g.: ::

	RewriteEngine On
	RewriteRule ^newsimg-([^/\.]+)/?$ index.php?eID=tx_newsmostread&uid=$1 [L]

Then you will need to call the request like: ::

	http://www.domain.tld/newsimg-123666

By using: ::

	<img src="http://www.domain.tld/newsimg-{newsItem.uid}" />
