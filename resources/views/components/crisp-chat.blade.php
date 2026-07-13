@if ( defined('CRISP_CHAT_WIDGET_ID') AND !empty(CRISP_CHAT_WIDGET_ID) )
	<script type="text/javascript">window.$crisp=[];window.CRISP_WEBSITE_ID="{{ CRISP_CHAT_WIDGET_ID }}";(function(){d=document;s=d.createElement("script");s.src="https://client.crisp.chat/l.js";s.async=1;d.getElementsByTagName("head")[0].appendChild(s);})();</script>
@endif