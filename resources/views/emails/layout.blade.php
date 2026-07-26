<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body style="margin:0;padding:0;background-color:#FFF8F6;font-family:Arial,Helvetica,sans-serif;">
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#FFF8F6;padding:32px 16px;">
<tr>
<td align="center">
<table role="presentation" width="560" cellpadding="0" cellspacing="0" style="background-color:#FFFFFF;border-radius:16px;overflow:hidden;border:1px solid #F0DDE2;">

<tr>
<td style="background-color:#8C0027;padding:24px 32px;">
<span style="font-size:18px;font-weight:bold;color:#FFFFFF;">Quality Gadgets Hub</span>
</td>
</tr>

<tr>
<td style="padding:32px;">
{{ $slot }}
</td>
</tr>

<tr>
<td style="background-color:#FFF8F6;padding:20px 32px;border-top:1px solid #F0DDE2;">
<p style="margin:0;font-size:12px;color:#6b5860;">
&copy; {{ now()->year }} Quality Gadgets Hub. Original phones, real prices.
</p>
</td>
</tr>

</table>
</td>
</tr>
</table>
</body>
</html>