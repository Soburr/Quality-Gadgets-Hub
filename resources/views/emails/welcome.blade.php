<x-email-layout>

<p style="margin:0 0 16px;font-size:16px;color:#20141A;">Hi {{ $user->name }},</p>

<p style="margin:0 0 16px;font-size:14px;line-height:1.6;color:#20141A;">
Welcome to Quality Gadgets Hub! Your account is ready — you can now track orders, save items to your wishlist, and check out faster next time.
</p>

<table role="presentation" cellpadding="0" cellspacing="0" style="margin:24px 0;">
<tr>
<td style="background-color:#C40356;border-radius:10px;">
<a href="{{ route('home') }}" style="display:inline-block;padding:14px 28px;font-size:14px;font-weight:bold;color:#FFFFFF;text-decoration:none;">
Start Shopping
</a>
</td>
</tr>
</table>

<p style="margin:0;font-size:13px;color:#6b5860;">
Every phone on Quality Gadgets Hub is inspected and verified before it ships, with a 7-day return window on everything.
</p>

</x-email-layout>