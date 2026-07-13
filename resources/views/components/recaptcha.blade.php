@if ( GOOGLE_RECAPTCHA_ENABLED )
    <div class="form-group">
        <div class="g-recaptcha" data-sitekey="{{ GOOGLE_RECAPTCHA_KEY }}"></div>
    </div>
@endif