<% if $RecaptchaVersion != 3 %>
    <div class="g-recaptcha" id="Nocaptcha-$ID" data-sitekey="$SiteKey" data-theme="$CaptchaTheme.ATT" data-type="$CaptchaType.ATT" data-size="$CaptchaSize.ATT" data-form="$FormID" data-badge="$CaptchaBadge.ATT"></div>
<% else %>
    <input id="Nocaptcha-{$Form.FormName}" data-sitekey="$SiteKey" data-action="submit" name="g-recaptcha-response"/>
	<p class="terms-legend">
		<%t UndefinedOffset\NoCaptcha\Forms\NocaptchaField.ReCaptchaTermsTextStart "This site is protected by reCAPTCHA and the Google" %>
		<a href="https://policies.google.com/privacy?hl={$ContentLocaleShort}" target="_blank" rel="noopener noreferrer"><%t UndefinedOffset\NoCaptcha\Forms\NocaptchaField.ReCaptchaPrivacyPolicy "Privacy Policy" %></a> &amp;
		<a href="https://policies.google.com/terms?hl={$ContentLocaleShort}" target="_blank" rel="noopener noreferrer"><%t UndefinedOffset\NoCaptcha\Forms\NocaptchaField.ReCaptchaTermsOfService "Terms of Service" %></a>
		<%t UndefinedOffset\NoCaptcha\Forms\NocaptchaField.ReCaptchaTermsTextEnd "apply." %>
	</p>
<% end_if %>
<noscript>
    <p><%t UndefinedOffset\\NoCaptcha\\Forms\\NocaptchaField.NOSCRIPT "You must enable JavaScript to submit this form" %></p>
</noscript>
