<!doctype html>
 <html xmlns="http://www.w3.org/1999/xhtml">
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta name="viewport" content="initial-scale=1.0" />
  <meta name="format-detection" content="telephone=no" />
  <title></title>
  <style type="text/css">
 	body {
		width: 100%;
		margin: 0;
		padding: 0;
		-webkit-font-smoothing: antialiased;
	}
	@media only screen and (max-width: 600px) {
		table[class="table-row"] {
			float: none !important;
			width: 98% !important;
			padding-left: 20px !important;
			padding-right: 20px !important;
		}
		table[class="table-row-fixed"] {
			float: none !important;
			width: 98% !important;
		}
		table[class="table-col"], table[class="table-col-border"] {
			float: none !important;
			width: 100% !important;
			padding-left: 0 !important;
			padding-right: 0 !important;
			table-layout: fixed;
		}
		td[class="table-col-td"] {
			width: 100% !important;
		}
		table[class="table-col-border"] + table[class="table-col-border"] {
			padding-top: 12px;
			margin-top: 12px;
			border-top: 1px solid #E8E8E8;
		}
		table[class="table-col"] + table[class="table-col"] {
			margin-top: 15px;
		}
		td[class="table-row-td"] {
			padding-left: 0 !important;
			padding-right: 0 !important;
		}
		table[class="navbar-row"] , td[class="navbar-row-td"] {
			width: 100% !important;
		}
		img {
			max-width: 100% !important;
			display: inline !important;
		}
		img[class="pull-right"] {
			float: right;
			margin-left: 11px;
            max-width: 125px !important;
			padding-bottom: 0 !important;
		}
		img[class="pull-left"] {
			float: left;
			margin-right: 11px;
			max-width: 125px !important;
			padding-bottom: 0 !important;
		}
		table[class="table-space"], table[class="header-row"] {
			float: none !important;
			width: 98% !important;
		}
		td[class="header-row-td"] {
			width: 100% !important;
		}
	}
	@media only screen and (max-width: 480px) {
		table[class="table-row"] {
			padding-left: 16px !important;
			padding-right: 16px !important;
		}
	}
	@media only screen and (max-width: 320px) {
		table[class="table-row"] {
			padding-left: 12px !important;
			padding-right: 12px !important;
		}
	}
	@media only screen and (max-width: 608px) {
		td[class="table-td-wrap"] {
			width: 100% !important;
		}
	}
  </style>
 </head>
 <body style="font-family: Arial, sans-serif; font-size:13px; color: #444444; min-height: 200px;" bgcolor="#E4E6E9" leftmargin="0" topmargin="0" marginheight="0" marginwidth="0">
 <table width="100%" height="100%" bgcolor="#E4E6E9" cellspacing="0" cellpadding="0" border="0">
 <tr><td width="100%" align="center" valign="top" bgcolor="#E4E6E9" style="background-color:#E4E6E9; min-height: 200px;">
<table style="table-layout: auto; width: 100%; background-color: #438eb9;" width="100%" bgcolor="#438eb9" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td width="100%" align="center" style="width: 100%; background-color: #438eb9;" bgcolor="#438eb9" valign="top"><table class="table-row-fixed" height="50" width="600" cellspacing="0" cellpadding="0" border="0" style="table-layout: fixed;"><tbody><tr><td class="navbar-row-td" valign="middle" height="50" width="600" data-skipstyle="true" align="left">
 <table class="table-row" style="table-layout: auto; padding-right: 16px; padding-left: 16px; width: 600px;" width="600" cellspacing="0" cellpadding="0" border="0"><tbody><tr style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px;">
   <td class="table-row-td" style="padding-right: 16px; font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal; vertical-align: middle;" valign="middle" align="left">     
	  {{ config('app.name') }} 
	 </a>
   </td>
 </tr></tbody></table>
</td></tr></tbody></table></td></tr></tbody></table>


<table class="table-space" height="8" style="height: 8px; font-size: 0px; line-height: 0; width: 600px; background-color: #ffffff;" width="600" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="8" style="height: 8px; width: 600px; background-color: #ffffff;" width="600" bgcolor="#FFFFFF" align="left">&nbsp;</td></tr></tbody></table>

<table class="table-row-fixed" width="600" bgcolor="#FFFFFF" style="table-layout: fixed; background-color: #ffffff;" cellspacing="0" cellpadding="0" border="0">
<tbody>
<tr>
<td class="table-row-fixed-td" style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal; padding-left: 24px; padding-right: 24px;" valign="top" align="left">
   <h1>{{ config('app.name') }}</h1>
   <br/>
   <p>Olá,</p>
   <br/>   
   <p>Segue em anexo o relatório do fechamento para {{$tipoRanking->ds_nome}}.</p>
   <br/>
   <p>Atenciosamento,</p>
   <p>{{ config('app.name') }}</p>
</td></tr></tbody></table>

<table class="table-space" height="32" style="height: 32px; font-size: 0px; line-height: 0; width: 600px; background-color: #ffffff;" width="600" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="32" style="height: 32px; width: 600px; padding-left: 18px; padding-right: 18px; background-color: #ffffff;" width="600" bgcolor="#FFFFFF" align="center">&nbsp;<table bgcolor="#E8E8E8" height="0" width="100%" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td bgcolor="#E8E8E8" height="1" width="100%" style="height: 1px; font-size:0;" valign="top" align="left">&nbsp;</td></tr></tbody></table></td></tr></tbody></table>

<table class="table-row" width="600" bgcolor="#FFFFFF" style="table-layout: fixed; background-color: #ffffff;" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-row-td" style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal; padding-left: 36px; padding-right: 36px;" valign="top" align="left">
 <table class="table-col" align="left" width="528" cellspacing="0" cellpadding="0" border="0" style="table-layout: fixed;"><tbody><tr><td class="table-col-td" width="528" style="font-family: Arial, sans-serif; line-height: 19px; color: #444444; font-size: 13px; font-weight: normal;" valign="top" align="left">
	 <div style="font-family: Arial, sans-serif; line-height: 19px; color: #777777; font-size: 14px; text-align: center;">&copy; Macako Software</div>
	 <table class="table-space" height="8" style="height: 8px; font-size: 0px; line-height: 0; width: 528px; background-color: #ffffff;" width="528" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="8" style="height: 8px; width: 528px; background-color: #ffffff;" width="528" bgcolor="#FFFFFF" align="left">&nbsp;</td></tr></tbody></table>	
 </td></tr></tbody></table>
</td></tr></tbody></table>
<table class="table-space" height="14" style="height: 14px; font-size: 0px; line-height: 0; width: 600px; background-color: #ffffff;" width="600" bgcolor="#FFFFFF" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td class="table-space-td" valign="middle" height="14" style="height: 14px; width: 600px; background-color: #ffffff;" width="600" bgcolor="#FFFFFF" align="left">&nbsp;</td></tr></tbody></table>
</td></tr>
 </table>
 </body>
 </html>
