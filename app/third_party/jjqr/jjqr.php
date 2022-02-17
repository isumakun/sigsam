<?php

Class JJQR {

	protected static $instance_id = 0;
	protected static $qr = '';

	function __construct()
	{
		static::$qr ="<script src='".BASE_URL.'public/vendors/qrcode/jjqr.min.js'."'></script>";
	}

	public function render($text, $size, $redundancy='M', $color_dark='#000', $color_light='#FFF')
	{
		$unique_id = static::$instance_id++;

		static::$qr .= <<<CODE
<div id="qrcode_{$unique_id}" style="width:{$size}px; height:{$size}px;"></div>

<script type="text/javascript">

	var qrcode_{$unique_id} = new QRCode(document.getElementById("qrcode_{$unique_id}"),
	{
		width : $size,
		height : $size,
		correctLevel : QRCode.CorrectLevel.{$redundancy},
		colorDark: '$color_dark',
		colorLight: '$color_light'
	});

	qrcode_$unique_id.makeCode('{$text}');

</script>
CODE;

		echo static::$qr;
		static::$qr = '';
	}
}
