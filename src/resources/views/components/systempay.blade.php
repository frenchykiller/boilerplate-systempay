@if(empty($amount))
    <code>
        &lt;x-boilerplate-systempay::systempay>
        The amount attribute has not been set
    </code>
@else
    <div class="kr-embedded" kr-form-token="{{ $token }}"{!! empty($attributes) ? '' : ' '.$attributes !!}>
        <!-- payment form fields -->
        <div class="kr-pan"></div>
        <div class="kr-expiry"></div>
        <div class="kr-security-code"></div>

        <!-- payment form submit button -->
        <button class="kr-payment-button"></button>

        <!-- error zone -->
        <div class="kr-form-error"></div>
    </div>
    <script
        src="https://api.systempay.fr/static/js/krypton-client/V4.0/stable/kr-payment-form.min.js"
        kr-public-key="{{ $key }}"
        kr-post-url-success="{{ isset($success) ? $success : '' }}">
    </script>

    <link rel="stylesheet" href="https://api.systempay.fr/static/js/krypton-client/V4.0/ext/classic-reset.css">
    <script
        src="https://api.systempay.fr/static/js/krypton-client/V4.0/ext/classic.js">
    </script>
@endif
