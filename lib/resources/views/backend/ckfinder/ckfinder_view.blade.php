<!DOCTYPE html>
<!--
Copyright (c) 2007-2016, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://cksource.com/ckfinder/license
-->
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
    <title>CKFinder 3 - File Browser</title>
</head>
<body>

<script src="{{ asset('public/ckfinder/ckfinder.js') }}"></script>
<script>
    var config = [];
    config.connectorPath = "{{ asset('admin/ckfinder/connector') }}";
    CKFinder.start();
</script>

</body>
</html>

