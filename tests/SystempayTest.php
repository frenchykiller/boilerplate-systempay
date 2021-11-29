<?php

namespace Frenchykiller\LaravelSystempay\Tests;

use Frenchykiller\LaravelSystempay\View\Components\Systempay;
use Illuminate\View\ViewException;

class SystempayTest extends TestCase
{
    /**
     * @test
     * it should throw a ViewException
     */
    public function testSystempayComponentNoAmount()
    {
        // Arrange
        $this->expectException(ViewException::class);

        // Act & Assert
        $this->blade('<x-systempay />');
    }

    public function testMinimalSystempayComponent()
    {
        // Arrange
        $token = '25n8W_b2zZSk-fKauX5NCipA21BeyJhbW91bnQiOjI1MDAwMCwiY3VycmVuY3kiOiJFVVIiLCJtb2RlIjoiVEVTVCIsInZlcnNpb24iOjMsInNob3BOYW1lIjoiU28gZWFzeSB0byB0ZXN0IiwiYnJhbmRQcmlvcml0eSI6WyJDQiIsIkUtQ0FSVEVCTEVVRSIsIlZJU0EiLCJWSVNBX0RFQklUIiwiTUFTVEVSQ0FSRCIsIk1BU1RFUkNBUkRfREVCSVQiLCJWSVNBX0VMRUNUUk9OIiwiTUFFU1RSTyJdLCJjYXRlZ29yaWVzIjp7ImRlYml0Q3JlZGl0Q2FyZHMiOnsiYXBwSWQiOiJjYXJkcyIsInBhcmFtIjpbIk1BRVNUUk8iLCJFLUNBUlRFQkxFVUUiLCJNQVNURVJDQVJEX0RFQklUIiwiTUFTVEVSQ0FSRCIsIlZJU0EiLCJWSVNBX0VMRUNUUk9OIiwiQ0IiLCJWSVNBX0RFQklUIl19fSwiY2FyZHMiOnsiTUFFU1RSTyI6eyJmaWVsZHMiOnsic2VjdXJpdHlDb2RlIjp7InJlcXVpcmVkIjpmYWxzZX19LCJjb3B5RnJvbSI6ImNhcmRzLkRFRkFVTFQifSwiRS1DQVJURUJMRVVFIjp7ImNvcHlGcm9tIjoiY2FyZHMuREVGQVVMVCJ9LCJNQVNURVJDQVJEX0RFQklUIjp7ImNvcHlGcm9tIjoiY2FyZHMuREVGQVVMVCJ9LCJNQVNURVJDQVJEIjp7ImNvcHlGcm9tIjoiY2FyZHMuREVGQVVMVCJ9LCJWSVNBIjp7ImNvcHlGcm9tIjoiY2FyZHMuREVGQVVMVCJ9LCJWSVNBX0VMRUNUUk9OIjp7ImZpZWxkcyI6eyJzZWN1cml0eUNvZGUiOnsicmVxdWlyZWQiOmZhbHNlfX0sImNvcHlGcm9tIjoiY2FyZHMuREVGQVVMVCJ9LCJERUZBVUxUIjp7ImZpZWxkcyI6eyJwYW4iOnsibWluTGVuZ3RoIjoxMCwibWF4TGVuZ3RoIjoxOSwidmFsaWRhdG9ycyI6WyJOVU1FUklDIiwiTFVITiJdLCJyZXF1aXJlZCI6dHJ1ZSwic2Vuc2l0aXZlIjp0cnVlLCJoaWRkZW4iOmZhbHNlLCJjbGVhck9uRXJyb3IiOmZhbHNlfSwiZXhwaXJ5RGF0ZSI6eyJyZXF1aXJlZCI6dHJ1ZSwic2Vuc2l0aXZlIjp0cnVlLCJoaWRkZW4iOmZhbHNlLCJjbGVhck9uRXJyb3IiOmZhbHNlfSwic2VjdXJpdHlDb2RlIjp7Im1pbkxlbmd0aCI6MywibWF4TGVuZ3RoIjozLCJ2YWxpZGF0b3JzIjpbIk5VTUVSSUMiXSwicmVxdWlyZWQiOnRydWUsInNlbnNpdGl2ZSI6dHJ1ZSwiaGlkZGVuIjpmYWxzZSwiY2xlYXJPbkVycm9yIjp0cnVlfX19LCJWSVNBX0RFQklUIjp7ImNvcHlGcm9tIjoiY2FyZHMuREVGQVVMVCJ9LCJDQiI6eyJjb3B5RnJvbSI6ImNhcmRzLkRFRkFVTFQifX0sInBhc3NBY3RpdmF0ZWQiOnRydWUsImFwaVJlc3RWZXJzaW9uIjoiNC4wIiwiY291bnRyeSI6IkZSIn09c02';
        $key = '73239078:testpublickey_Zr3fXIKKx0mLY9YNBQEan42ano2QsdrLuyb2W54QWmUJQ';
        $request = [
            'amount' => 2500,
        ];
        $expected = <<<"HTML"
<div class="kr-embedded" kr-form-token="$token" >
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
        kr-public-key="$key"
        
        
        
        >
    </script>

    <link rel="stylesheet" href="https://api.systempay.fr/static/js/krypton-client/V4.0/ext/classic-reset.css">
    <script
        src="https://api.systempay.fr/static/js/krypton-client/V4.0/ext/classic.js">
    </script>

HTML;
        // Act
        $actual = $this->component(testStub::class, ['request' => $request]);

        // Assert
        $this->assertEquals($expected, $actual->__toString());
    }

    public function testSuccessPostUrl()
    {
        // Arrange
        $token = '25n8W_b2zZSk-fKauX5NCipA21BeyJhbW91bnQiOjI1MDAwMCwiY3VycmVuY3kiOiJFVVIiLCJtb2RlIjoiVEVTVCIsInZlcnNpb24iOjMsInNob3BOYW1lIjoiU28gZWFzeSB0byB0ZXN0IiwiYnJhbmRQcmlvcml0eSI6WyJDQiIsIkUtQ0FSVEVCTEVVRSIsIlZJU0EiLCJWSVNBX0RFQklUIiwiTUFTVEVSQ0FSRCIsIk1BU1RFUkNBUkRfREVCSVQiLCJWSVNBX0VMRUNUUk9OIiwiTUFFU1RSTyJdLCJjYXRlZ29yaWVzIjp7ImRlYml0Q3JlZGl0Q2FyZHMiOnsiYXBwSWQiOiJjYXJkcyIsInBhcmFtIjpbIk1BRVNUUk8iLCJFLUNBUlRFQkxFVUUiLCJNQVNURVJDQVJEX0RFQklUIiwiTUFTVEVSQ0FSRCIsIlZJU0EiLCJWSVNBX0VMRUNUUk9OIiwiQ0IiLCJWSVNBX0RFQklUIl19fSwiY2FyZHMiOnsiTUFFU1RSTyI6eyJmaWVsZHMiOnsic2VjdXJpdHlDb2RlIjp7InJlcXVpcmVkIjpmYWxzZX19LCJjb3B5RnJvbSI6ImNhcmRzLkRFRkFVTFQifSwiRS1DQVJURUJMRVVFIjp7ImNvcHlGcm9tIjoiY2FyZHMuREVGQVVMVCJ9LCJNQVNURVJDQVJEX0RFQklUIjp7ImNvcHlGcm9tIjoiY2FyZHMuREVGQVVMVCJ9LCJNQVNURVJDQVJEIjp7ImNvcHlGcm9tIjoiY2FyZHMuREVGQVVMVCJ9LCJWSVNBIjp7ImNvcHlGcm9tIjoiY2FyZHMuREVGQVVMVCJ9LCJWSVNBX0VMRUNUUk9OIjp7ImZpZWxkcyI6eyJzZWN1cml0eUNvZGUiOnsicmVxdWlyZWQiOmZhbHNlfX0sImNvcHlGcm9tIjoiY2FyZHMuREVGQVVMVCJ9LCJERUZBVUxUIjp7ImZpZWxkcyI6eyJwYW4iOnsibWluTGVuZ3RoIjoxMCwibWF4TGVuZ3RoIjoxOSwidmFsaWRhdG9ycyI6WyJOVU1FUklDIiwiTFVITiJdLCJyZXF1aXJlZCI6dHJ1ZSwic2Vuc2l0aXZlIjp0cnVlLCJoaWRkZW4iOmZhbHNlLCJjbGVhck9uRXJyb3IiOmZhbHNlfSwiZXhwaXJ5RGF0ZSI6eyJyZXF1aXJlZCI6dHJ1ZSwic2Vuc2l0aXZlIjp0cnVlLCJoaWRkZW4iOmZhbHNlLCJjbGVhck9uRXJyb3IiOmZhbHNlfSwic2VjdXJpdHlDb2RlIjp7Im1pbkxlbmd0aCI6MywibWF4TGVuZ3RoIjozLCJ2YWxpZGF0b3JzIjpbIk5VTUVSSUMiXSwicmVxdWlyZWQiOnRydWUsInNlbnNpdGl2ZSI6dHJ1ZSwiaGlkZGVuIjpmYWxzZSwiY2xlYXJPbkVycm9yIjp0cnVlfX19LCJWSVNBX0RFQklUIjp7ImNvcHlGcm9tIjoiY2FyZHMuREVGQVVMVCJ9LCJDQiI6eyJjb3B5RnJvbSI6ImNhcmRzLkRFRkFVTFQifX0sInBhc3NBY3RpdmF0ZWQiOnRydWUsImFwaVJlc3RWZXJzaW9uIjoiNC4wIiwiY291bnRyeSI6IkZSIn09c02';
        $key = '73239078:testpublickey_Zr3fXIKKx0mLY9YNBQEan42ano2QsdrLuyb2W54QWmUJQ';
        $request = [
            'amount' => 2500,
        ];
        $url = 'destination.url';
        $expected = <<<"HTML"
<div class="kr-embedded" kr-form-token="$token" >
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
        kr-public-key="$key"
        kr-post-url-success="$url"
        
        
        >
    </script>

    <link rel="stylesheet" href="https://api.systempay.fr/static/js/krypton-client/V4.0/ext/classic-reset.css">
    <script
        src="https://api.systempay.fr/static/js/krypton-client/V4.0/ext/classic.js">
    </script>

HTML;
        // Act
        $actual = $this->component(testStub::class, ['request' => $request, 'successPost' => $url]);

        // Assert
        $this->assertEquals($expected, $actual->__toString());
    }

    public function testSuccessGetUrl()
    {
        // Arrange
        $token = '25n8W_b2zZSk-fKauX5NCipA21BeyJhbW91bnQiOjI1MDAwMCwiY3VycmVuY3kiOiJFVVIiLCJtb2RlIjoiVEVTVCIsInZlcnNpb24iOjMsInNob3BOYW1lIjoiU28gZWFzeSB0byB0ZXN0IiwiYnJhbmRQcmlvcml0eSI6WyJDQiIsIkUtQ0FSVEVCTEVVRSIsIlZJU0EiLCJWSVNBX0RFQklUIiwiTUFTVEVSQ0FSRCIsIk1BU1RFUkNBUkRfREVCSVQiLCJWSVNBX0VMRUNUUk9OIiwiTUFFU1RSTyJdLCJjYXRlZ29yaWVzIjp7ImRlYml0Q3JlZGl0Q2FyZHMiOnsiYXBwSWQiOiJjYXJkcyIsInBhcmFtIjpbIk1BRVNUUk8iLCJFLUNBUlRFQkxFVUUiLCJNQVNURVJDQVJEX0RFQklUIiwiTUFTVEVSQ0FSRCIsIlZJU0EiLCJWSVNBX0VMRUNUUk9OIiwiQ0IiLCJWSVNBX0RFQklUIl19fSwiY2FyZHMiOnsiTUFFU1RSTyI6eyJmaWVsZHMiOnsic2VjdXJpdHlDb2RlIjp7InJlcXVpcmVkIjpmYWxzZX19LCJjb3B5RnJvbSI6ImNhcmRzLkRFRkFVTFQifSwiRS1DQVJURUJMRVVFIjp7ImNvcHlGcm9tIjoiY2FyZHMuREVGQVVMVCJ9LCJNQVNURVJDQVJEX0RFQklUIjp7ImNvcHlGcm9tIjoiY2FyZHMuREVGQVVMVCJ9LCJNQVNURVJDQVJEIjp7ImNvcHlGcm9tIjoiY2FyZHMuREVGQVVMVCJ9LCJWSVNBIjp7ImNvcHlGcm9tIjoiY2FyZHMuREVGQVVMVCJ9LCJWSVNBX0VMRUNUUk9OIjp7ImZpZWxkcyI6eyJzZWN1cml0eUNvZGUiOnsicmVxdWlyZWQiOmZhbHNlfX0sImNvcHlGcm9tIjoiY2FyZHMuREVGQVVMVCJ9LCJERUZBVUxUIjp7ImZpZWxkcyI6eyJwYW4iOnsibWluTGVuZ3RoIjoxMCwibWF4TGVuZ3RoIjoxOSwidmFsaWRhdG9ycyI6WyJOVU1FUklDIiwiTFVITiJdLCJyZXF1aXJlZCI6dHJ1ZSwic2Vuc2l0aXZlIjp0cnVlLCJoaWRkZW4iOmZhbHNlLCJjbGVhck9uRXJyb3IiOmZhbHNlfSwiZXhwaXJ5RGF0ZSI6eyJyZXF1aXJlZCI6dHJ1ZSwic2Vuc2l0aXZlIjp0cnVlLCJoaWRkZW4iOmZhbHNlLCJjbGVhck9uRXJyb3IiOmZhbHNlfSwic2VjdXJpdHlDb2RlIjp7Im1pbkxlbmd0aCI6MywibWF4TGVuZ3RoIjozLCJ2YWxpZGF0b3JzIjpbIk5VTUVSSUMiXSwicmVxdWlyZWQiOnRydWUsInNlbnNpdGl2ZSI6dHJ1ZSwiaGlkZGVuIjpmYWxzZSwiY2xlYXJPbkVycm9yIjp0cnVlfX19LCJWSVNBX0RFQklUIjp7ImNvcHlGcm9tIjoiY2FyZHMuREVGQVVMVCJ9LCJDQiI6eyJjb3B5RnJvbSI6ImNhcmRzLkRFRkFVTFQifX0sInBhc3NBY3RpdmF0ZWQiOnRydWUsImFwaVJlc3RWZXJzaW9uIjoiNC4wIiwiY291bnRyeSI6IkZSIn09c02';
        $key = '73239078:testpublickey_Zr3fXIKKx0mLY9YNBQEan42ano2QsdrLuyb2W54QWmUJQ';
        $request = [
            'amount' => 2500,
        ];
        $url = 'destination.url';
        $expected = <<<"HTML"
<div class="kr-embedded" kr-form-token="$token" >
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
        kr-public-key="$key"
        
        kr-get-url-success="$url"
        
        >
    </script>

    <link rel="stylesheet" href="https://api.systempay.fr/static/js/krypton-client/V4.0/ext/classic-reset.css">
    <script
        src="https://api.systempay.fr/static/js/krypton-client/V4.0/ext/classic.js">
    </script>

HTML;
        // Act
        $actual = $this->component(testStub::class, ['request' => $request, 'successGet' => $url]);

        // Assert
        $this->assertEquals($expected, $actual->__toString());
    }

    public function testFailPostUrl()
    {
        // Arrange
        $token = '25n8W_b2zZSk-fKauX5NCipA21BeyJhbW91bnQiOjI1MDAwMCwiY3VycmVuY3kiOiJFVVIiLCJtb2RlIjoiVEVTVCIsInZlcnNpb24iOjMsInNob3BOYW1lIjoiU28gZWFzeSB0byB0ZXN0IiwiYnJhbmRQcmlvcml0eSI6WyJDQiIsIkUtQ0FSVEVCTEVVRSIsIlZJU0EiLCJWSVNBX0RFQklUIiwiTUFTVEVSQ0FSRCIsIk1BU1RFUkNBUkRfREVCSVQiLCJWSVNBX0VMRUNUUk9OIiwiTUFFU1RSTyJdLCJjYXRlZ29yaWVzIjp7ImRlYml0Q3JlZGl0Q2FyZHMiOnsiYXBwSWQiOiJjYXJkcyIsInBhcmFtIjpbIk1BRVNUUk8iLCJFLUNBUlRFQkxFVUUiLCJNQVNURVJDQVJEX0RFQklUIiwiTUFTVEVSQ0FSRCIsIlZJU0EiLCJWSVNBX0VMRUNUUk9OIiwiQ0IiLCJWSVNBX0RFQklUIl19fSwiY2FyZHMiOnsiTUFFU1RSTyI6eyJmaWVsZHMiOnsic2VjdXJpdHlDb2RlIjp7InJlcXVpcmVkIjpmYWxzZX19LCJjb3B5RnJvbSI6ImNhcmRzLkRFRkFVTFQifSwiRS1DQVJURUJMRVVFIjp7ImNvcHlGcm9tIjoiY2FyZHMuREVGQVVMVCJ9LCJNQVNURVJDQVJEX0RFQklUIjp7ImNvcHlGcm9tIjoiY2FyZHMuREVGQVVMVCJ9LCJNQVNURVJDQVJEIjp7ImNvcHlGcm9tIjoiY2FyZHMuREVGQVVMVCJ9LCJWSVNBIjp7ImNvcHlGcm9tIjoiY2FyZHMuREVGQVVMVCJ9LCJWSVNBX0VMRUNUUk9OIjp7ImZpZWxkcyI6eyJzZWN1cml0eUNvZGUiOnsicmVxdWlyZWQiOmZhbHNlfX0sImNvcHlGcm9tIjoiY2FyZHMuREVGQVVMVCJ9LCJERUZBVUxUIjp7ImZpZWxkcyI6eyJwYW4iOnsibWluTGVuZ3RoIjoxMCwibWF4TGVuZ3RoIjoxOSwidmFsaWRhdG9ycyI6WyJOVU1FUklDIiwiTFVITiJdLCJyZXF1aXJlZCI6dHJ1ZSwic2Vuc2l0aXZlIjp0cnVlLCJoaWRkZW4iOmZhbHNlLCJjbGVhck9uRXJyb3IiOmZhbHNlfSwiZXhwaXJ5RGF0ZSI6eyJyZXF1aXJlZCI6dHJ1ZSwic2Vuc2l0aXZlIjp0cnVlLCJoaWRkZW4iOmZhbHNlLCJjbGVhck9uRXJyb3IiOmZhbHNlfSwic2VjdXJpdHlDb2RlIjp7Im1pbkxlbmd0aCI6MywibWF4TGVuZ3RoIjozLCJ2YWxpZGF0b3JzIjpbIk5VTUVSSUMiXSwicmVxdWlyZWQiOnRydWUsInNlbnNpdGl2ZSI6dHJ1ZSwiaGlkZGVuIjpmYWxzZSwiY2xlYXJPbkVycm9yIjp0cnVlfX19LCJWSVNBX0RFQklUIjp7ImNvcHlGcm9tIjoiY2FyZHMuREVGQVVMVCJ9LCJDQiI6eyJjb3B5RnJvbSI6ImNhcmRzLkRFRkFVTFQifX0sInBhc3NBY3RpdmF0ZWQiOnRydWUsImFwaVJlc3RWZXJzaW9uIjoiNC4wIiwiY291bnRyeSI6IkZSIn09c02';
        $key = '73239078:testpublickey_Zr3fXIKKx0mLY9YNBQEan42ano2QsdrLuyb2W54QWmUJQ';
        $request = [
            'amount' => 2500,
        ];
        $url = 'destination.url';
        $expected = <<<"HTML"
<div class="kr-embedded" kr-form-token="$token" >
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
        kr-public-key="$key"
        
        
        kr-post-url-refused="$url"
        >
    </script>

    <link rel="stylesheet" href="https://api.systempay.fr/static/js/krypton-client/V4.0/ext/classic-reset.css">
    <script
        src="https://api.systempay.fr/static/js/krypton-client/V4.0/ext/classic.js">
    </script>

HTML;
        // Act
        $actual = $this->component(testStub::class, ['request' => $request, 'failPost' => $url]);

        // Assert
        $this->assertEquals($expected, $actual->__toString());
    }

    public function testFailGetUrl()
    {
        // Arrange
        $token = '25n8W_b2zZSk-fKauX5NCipA21BeyJhbW91bnQiOjI1MDAwMCwiY3VycmVuY3kiOiJFVVIiLCJtb2RlIjoiVEVTVCIsInZlcnNpb24iOjMsInNob3BOYW1lIjoiU28gZWFzeSB0byB0ZXN0IiwiYnJhbmRQcmlvcml0eSI6WyJDQiIsIkUtQ0FSVEVCTEVVRSIsIlZJU0EiLCJWSVNBX0RFQklUIiwiTUFTVEVSQ0FSRCIsIk1BU1RFUkNBUkRfREVCSVQiLCJWSVNBX0VMRUNUUk9OIiwiTUFFU1RSTyJdLCJjYXRlZ29yaWVzIjp7ImRlYml0Q3JlZGl0Q2FyZHMiOnsiYXBwSWQiOiJjYXJkcyIsInBhcmFtIjpbIk1BRVNUUk8iLCJFLUNBUlRFQkxFVUUiLCJNQVNURVJDQVJEX0RFQklUIiwiTUFTVEVSQ0FSRCIsIlZJU0EiLCJWSVNBX0VMRUNUUk9OIiwiQ0IiLCJWSVNBX0RFQklUIl19fSwiY2FyZHMiOnsiTUFFU1RSTyI6eyJmaWVsZHMiOnsic2VjdXJpdHlDb2RlIjp7InJlcXVpcmVkIjpmYWxzZX19LCJjb3B5RnJvbSI6ImNhcmRzLkRFRkFVTFQifSwiRS1DQVJURUJMRVVFIjp7ImNvcHlGcm9tIjoiY2FyZHMuREVGQVVMVCJ9LCJNQVNURVJDQVJEX0RFQklUIjp7ImNvcHlGcm9tIjoiY2FyZHMuREVGQVVMVCJ9LCJNQVNURVJDQVJEIjp7ImNvcHlGcm9tIjoiY2FyZHMuREVGQVVMVCJ9LCJWSVNBIjp7ImNvcHlGcm9tIjoiY2FyZHMuREVGQVVMVCJ9LCJWSVNBX0VMRUNUUk9OIjp7ImZpZWxkcyI6eyJzZWN1cml0eUNvZGUiOnsicmVxdWlyZWQiOmZhbHNlfX0sImNvcHlGcm9tIjoiY2FyZHMuREVGQVVMVCJ9LCJERUZBVUxUIjp7ImZpZWxkcyI6eyJwYW4iOnsibWluTGVuZ3RoIjoxMCwibWF4TGVuZ3RoIjoxOSwidmFsaWRhdG9ycyI6WyJOVU1FUklDIiwiTFVITiJdLCJyZXF1aXJlZCI6dHJ1ZSwic2Vuc2l0aXZlIjp0cnVlLCJoaWRkZW4iOmZhbHNlLCJjbGVhck9uRXJyb3IiOmZhbHNlfSwiZXhwaXJ5RGF0ZSI6eyJyZXF1aXJlZCI6dHJ1ZSwic2Vuc2l0aXZlIjp0cnVlLCJoaWRkZW4iOmZhbHNlLCJjbGVhck9uRXJyb3IiOmZhbHNlfSwic2VjdXJpdHlDb2RlIjp7Im1pbkxlbmd0aCI6MywibWF4TGVuZ3RoIjozLCJ2YWxpZGF0b3JzIjpbIk5VTUVSSUMiXSwicmVxdWlyZWQiOnRydWUsInNlbnNpdGl2ZSI6dHJ1ZSwiaGlkZGVuIjpmYWxzZSwiY2xlYXJPbkVycm9yIjp0cnVlfX19LCJWSVNBX0RFQklUIjp7ImNvcHlGcm9tIjoiY2FyZHMuREVGQVVMVCJ9LCJDQiI6eyJjb3B5RnJvbSI6ImNhcmRzLkRFRkFVTFQifX0sInBhc3NBY3RpdmF0ZWQiOnRydWUsImFwaVJlc3RWZXJzaW9uIjoiNC4wIiwiY291bnRyeSI6IkZSIn09c02';
        $key = '73239078:testpublickey_Zr3fXIKKx0mLY9YNBQEan42ano2QsdrLuyb2W54QWmUJQ';
        $request = [
            'amount' => 2500,
        ];
        $url = 'destination.url';
        $expected = <<<"HTML"
<div class="kr-embedded" kr-form-token="$token" >
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
        kr-public-key="$key"
        
        
        
        kr-get-url-refused="$url">
    </script>

    <link rel="stylesheet" href="https://api.systempay.fr/static/js/krypton-client/V4.0/ext/classic-reset.css">
    <script
        src="https://api.systempay.fr/static/js/krypton-client/V4.0/ext/classic.js">
    </script>

HTML;
        // Act
        $actual = $this->component(testStub::class, ['request' => $request, 'failGet' => $url]);

        // Assert
        $this->assertEquals($expected, $actual->__toString());
    }
}

class testStub extends Systempay
{
    protected function getToken($site, $data)
    {
        return '25n8W_b2zZSk-fKauX5NCipA21BeyJhbW91bnQiOjI1MDAwMCwiY3VycmVuY3kiOiJFVVIiLCJtb2RlIjoiVEVTVCIsInZlcnNpb24iOjMsInNob3BOYW1lIjoiU28gZWFzeSB0byB0ZXN0IiwiYnJhbmRQcmlvcml0eSI6WyJDQiIsIkUtQ0FSVEVCTEVVRSIsIlZJU0EiLCJWSVNBX0RFQklUIiwiTUFTVEVSQ0FSRCIsIk1BU1RFUkNBUkRfREVCSVQiLCJWSVNBX0VMRUNUUk9OIiwiTUFFU1RSTyJdLCJjYXRlZ29yaWVzIjp7ImRlYml0Q3JlZGl0Q2FyZHMiOnsiYXBwSWQiOiJjYXJkcyIsInBhcmFtIjpbIk1BRVNUUk8iLCJFLUNBUlRFQkxFVUUiLCJNQVNURVJDQVJEX0RFQklUIiwiTUFTVEVSQ0FSRCIsIlZJU0EiLCJWSVNBX0VMRUNUUk9OIiwiQ0IiLCJWSVNBX0RFQklUIl19fSwiY2FyZHMiOnsiTUFFU1RSTyI6eyJmaWVsZHMiOnsic2VjdXJpdHlDb2RlIjp7InJlcXVpcmVkIjpmYWxzZX19LCJjb3B5RnJvbSI6ImNhcmRzLkRFRkFVTFQifSwiRS1DQVJURUJMRVVFIjp7ImNvcHlGcm9tIjoiY2FyZHMuREVGQVVMVCJ9LCJNQVNURVJDQVJEX0RFQklUIjp7ImNvcHlGcm9tIjoiY2FyZHMuREVGQVVMVCJ9LCJNQVNURVJDQVJEIjp7ImNvcHlGcm9tIjoiY2FyZHMuREVGQVVMVCJ9LCJWSVNBIjp7ImNvcHlGcm9tIjoiY2FyZHMuREVGQVVMVCJ9LCJWSVNBX0VMRUNUUk9OIjp7ImZpZWxkcyI6eyJzZWN1cml0eUNvZGUiOnsicmVxdWlyZWQiOmZhbHNlfX0sImNvcHlGcm9tIjoiY2FyZHMuREVGQVVMVCJ9LCJERUZBVUxUIjp7ImZpZWxkcyI6eyJwYW4iOnsibWluTGVuZ3RoIjoxMCwibWF4TGVuZ3RoIjoxOSwidmFsaWRhdG9ycyI6WyJOVU1FUklDIiwiTFVITiJdLCJyZXF1aXJlZCI6dHJ1ZSwic2Vuc2l0aXZlIjp0cnVlLCJoaWRkZW4iOmZhbHNlLCJjbGVhck9uRXJyb3IiOmZhbHNlfSwiZXhwaXJ5RGF0ZSI6eyJyZXF1aXJlZCI6dHJ1ZSwic2Vuc2l0aXZlIjp0cnVlLCJoaWRkZW4iOmZhbHNlLCJjbGVhck9uRXJyb3IiOmZhbHNlfSwic2VjdXJpdHlDb2RlIjp7Im1pbkxlbmd0aCI6MywibWF4TGVuZ3RoIjozLCJ2YWxpZGF0b3JzIjpbIk5VTUVSSUMiXSwicmVxdWlyZWQiOnRydWUsInNlbnNpdGl2ZSI6dHJ1ZSwiaGlkZGVuIjpmYWxzZSwiY2xlYXJPbkVycm9yIjp0cnVlfX19LCJWSVNBX0RFQklUIjp7ImNvcHlGcm9tIjoiY2FyZHMuREVGQVVMVCJ9LCJDQiI6eyJjb3B5RnJvbSI6ImNhcmRzLkRFRkFVTFQifX0sInBhc3NBY3RpdmF0ZWQiOnRydWUsImFwaVJlc3RWZXJzaW9uIjoiNC4wIiwiY291bnRyeSI6IkZSIn09c02';
    }
}
